<?php
namespace Telelab\Mailer;

use Telelab\Component\ComponentStatic;

 /**
  * Class Mailer
  *
  * @author gdievart <g.dievart@telemaque.fr>
  */
class Mailer extends ComponentStatic
{
    /**
     * @var array Required fields
     */
    protected static $_requiredFields = array(
        'host_default',
        'host_attachments'
    );

    /**
     * @var array Ref to PhpMailer
     */
    private static $phpMailer;

    /**
     * @var string Ip default host
     */
    private static $hostDefault;

    /**
     * @var string Ip attachments host
     */
    private static $hostAttachments;


    /**
     * Create a new mail
     *
     * @param array $config
     */
    public static function _init($config)
    {
        require_once ROOT_DIR.'/vendor/phpmailer/class.phpmailer.php';
        self::$phpMailer       = new \PHPMailer();
        self::$hostDefault     = $config['host_default'];
        self::$hostAttachments = $config['host_attachments'];
    }


    /**
     * Sendmail
     *
     * @param string $from
     * @param string $fromName
     * @param string $to
     * @param string $subject
     * @param string $msgHtml
     * @param string $msgTxt
     * @param array $attachments
     * @param string $utf8
     * @param string $replyTo
     * @return boolean
     */
    public static function sendMail($from = '', $fromName = '', $to = '', $subject = '',
            $msgHtml = '', $msgTxt = '', $attachments = null, $utf8 = false, $replyTo = null)
    {
        self::$phpMailer->IsSMTP();

        if (is_array($attachments)) {
            self::$phpMailer->Host = self::$hostDefault;
        } else {
            self::$phpMailer->Host = self::$hostAttachments;
        }
        self::$phpMailer->SMTPAuth = false;
        self::$phpMailer->From = $from;
        self::$phpMailer->FromName = $fromName;

        self::$phpMailer->AddAddress($to);

        if (!empty($replyTo)) {
            self::$phpMailer->AddReplyTo(strtolower($replyTo), '');
        }

        if ($utf8) {
            self::$phpMailer->CharSet = "UTF-8";
        }

        if (!$utf8 && mb_detect_encoding($msgHtml) === 'UTF-8')
            $msgHtml = utf8_decode($msgHtml);

        if (!$utf8 && mb_detect_encoding($subject) === 'UTF-8')
            $subject = utf8_decode($subject);

        self::$phpMailer->Subject = $subject;

        self::$phpMailer->AltBody = $msgTxt;
        self::$phpMailer->Body = $msgHtml;

        if (is_array($attachments)) {
            if (array_key_exists('path', $attachments)) {
                $attachments = array($attachments);
            }

            foreach ($attachments as $attachment) {
                if (array_key_exists('path', $attachment) && array_key_exists('name', $attachment)) {
                    if (!$utf8 && mb_detect_encoding($attachment['name']) === 'UTF-8') {
                        $attachment['name'] = utf8_decode($attachment['name']);
                    }
                    if (!$utf8 && mb_detect_encoding($attachment['path']) === 'UTF-8') {
                        $attachment['path'] = utf8_decode($attachment['path']);
                    }

                    self::$phpMailer->AddAttachment($attachment['path'], $attachment['name']);
                }
            }
        }
        return self::$phpMailer->Send();
    }
}
