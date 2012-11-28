<?php
namespace Telelab\Mail;

use Telelab\Component\Component;

 /**
  * Class Mail
  *
  * @author gdievart <g.dievart@telemaque.fr>
  */
class Mail extends Component
{

    /**
     * @staticvar string End of Line characters
     */
    const MAIL_EOF = "\r\n" ;

    /**
     * @var string Sender
     */
    private $_from;

    /**
     * @var string Unique string for boundary limit
     */
    private $_boundary;

    /**
     * @var array Recipients
     */
    private $_recipients = array();

    /**
     * @var array Copy carbon
     */
    private $_cc = array();

    /**
     * @var array Blind copy carbon
     */
    private $_bcc = array();

    /**
     * @var string Mail to reply-to
     */
    private $_replyTo;

    /**
     * @var array Contains all filename for attachments
     */
    private $_attachments = array();


    /**
     * Create a new mail
     *
     * @param array $config
     */
    public function _init($config)
    {
        if (isset($config['from']) && isset($config['from']['address'])) {
            $name = isset($config['from']['name'])
                  ? $config['from']['name'] : null;
            $this->setFrom($config['from']['address'], $name);
        }

        if (isset($config['reply']) && isset($config['reply']['address'])) {
            $name = isset($config['reply']['name'])
                  ? $config['reply']['name'] : null;
            $this->setFrom($config['reply']['address'], $name);
        }

        if (isset($config['to']) && isset($config['to']['address'])) {
            $name = isset($config['to']['name']) ? $config['to']['name'] : null;
            $this->setFrom($config['to']['address'], $name);
        }
    }


    /**
     * Set mail sender
     *
     * @param string $address
     * @param string $name
     * @return Mail
     */
    public function setFrom($address, $name = null)
    {
        if ($this->_isMail($address)) {
            $this->_from = $this->_formatMail($address, $name);
        }

        return $this;
    }


    /**
     * Set mail reply to
     *
     * @param string $address
     * @param string $name
     * @return Mail
     */
    public function setReplyTo($address, $name = null)
    {
        if ($this->_isMail($address)) {
            $this->_replyTo = $this->_formatMail($address, $name);
        }

        return $this;
    }


    /**
     * Set mail main recipients
     *
     * @param string $address
     * @param string $name
     * @return Mail
     */
    public function addRecipient($address, $name = null)
    {
        if ($this->_isMail($address)) {
            $this->_recipients[] = $this->_formatMail($address, $name);
        }

        return $this;
    }


    /**
     * Set mail hide copy recipients
     *
     * @param string $address
     * @param string $name
     * @return Mail
     */
    public function addBcc($address, $name = null)
    {
        if ($this->_isMail($address)) {
            $this->_bcc[] = $this->_formatMail($address, $name);
        }

        return $this;
    }


    /**
     * Set mail copy recipients
     *
     * @param string $address
     * @param string $name
     * @return Mail
     */
    public function addCc($address, $name = null)
    {
        if ($this->_isMail($address)) {
            $this->_cc[] = $this->_formatMail($address, $name);
        }

        return $this;
    }


    /**
     * Add an attachement to mail
     *
     * @param string $fileName
     * @return Mail
     */
    public function addAttachement($fileName)
    {
        if (file_exists($fileName) && is_readable($fileName)) {
            $this->_attachments[] = $fileName;
        }

        return $this;
    }


    /**
     * Send mail with all options that are previously configure
     *
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    public function send($subject, $message)
    {
        $this->_boundary = 'mix='.md5(uniqid(mt_rand()));

        $body = $this->_getBody($message);
        $body.= $this->_getBodyAttachements();

        if (!empty($this->_attachments)) {
            $body.= "--".$this->_boundary."--".self::MAIL_EOF;
        }

        $to = implode(',', $this->_recipients);

        return mail(
            implode(',', $this->_recipients),
            $subject, $body, $this->_getHeaders()
        );
    }


    /**
     * Prepare Headers for mail
     */
    private function _getHeaders()
    {
        $header = '';
        if (!empty($this->_from)) {
            $header.= 'From: '.$this->_from.self::MAIL_EOF;
        }

        if (!empty($this->_cc)) {
            $header.= 'Cc: '.implode(',', $this->_cc).self::MAIL_EOF;
        }

        if (!empty($this->_bcc)) {
            $header.= 'Bcc: '.implode(',', $this->_bcc).self::MAIL_EOF;
        }

        if (!empty($this->_replyTo)) {
            $header.= 'Reply-To: '.$this->_replyTo.self::MAIL_EOF;
        }


        $header.= 'MIME-Version: 1.0'. "\n";
        if (!empty($this->_attachments)) {
            $header.= 'Content-Type: multipart/mixed; boundary="'
                    . $this->_boundary.'"'. self::MAIL_EOF;
        } else {
            $header.= 'Content-type: text/html; charset=iso-8859-1'
                    . self::MAIL_EOF;
        }
    }


    /**
     * Prepare message for mail
     *
     * @throws MS_Exception
     */
    private function _getBody($message)
    {
        $body = "";
        if (!empty($this->_attachments)) {
            $body.= "--".$this->_boundary.self::MAIL_EOF ;
            $body.= "Content-Type: text/html; charset=\"iso-8859-1\""
                  . self::MAIL_EOF;
            $body.= "Content-Transfer-Encoding: 7bit"
                  . self::MAIL_EOF.self::MAIL_EOF;
        }

        $body.= '<html><head></head><body>';
        $body.= $message;
        $body.= '</body></html>';
        $body.= self::MAIL_EOF.self::MAIL_EOF;

        return $body;
    }


    /**
     * Prepare atachement for mail
     *
     * @return string|boolean
     */
    private function _getBodyAttachements()
    {
        if (!empty($this->_attachments)) {
            $body = '';
            foreach ($this->_attachments as $file) {
                $body.= '--'.$this->_boundary.self::MAIL_EOF;
                $body.= 'Content-Type: $mimeType; name="'
                      . basename($file).'"'.self::MAIL_EOF;
                $body.= 'Content-Transfer-Encoding: base64'.self::MAIL_EOF;
                $body.= 'Content-Disposition: attachment; filename="'
                      . basename($file).'"';
                $body.= self::MAIL_EOF.self::MAIL_EOF;
                $body.= chunk_split(base64_encode(file_get_contents($file)));
                $body.= self::MAIL_EOF.self::MAIL_EOF;
            }
            return $body;
        }
        return false;
    }


    /**
     * Check if the mail is valid
     *
     * @param string $address
     * @return boolean
     */
    private function _isMail($address)
    {
        return preg_match(
            '/^[a-z0-9\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is',
            $address
        );
    }


    /**
     * Format address mail to the standard RFC2822
     *
     * @param string $address
     * @param string $name
     * @return string
     */
    private function _formatMail($address, $name)
    {
        if ($name !== null) {
            $mail = "$name <$address>";
        } else {
            $mail = "$address";
        }

        return $mail;
    }
}
