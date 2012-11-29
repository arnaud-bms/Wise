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
     * @var array Ref to PhpMailer
     */
    private static $_phpMailer;


    /**
     * Create a new mail
     *
     * @param array $config
     */
    public function _init($config)
    {
        require ROOT_DIR.'/vendor/phpmailer/class.phpmailer.php';
        self::$_phpMailer = new PHPMailer();
    }


    /**
     * Send mail
     */
    public static function sendMail($from = '', $fromName = '', $to = '', $subject = '',
            $msgHtml = '', $msgTxt = '', $attachments = null, $utf8 = false, $replyTo = null)
    {
        self::$_phpMailer->IsSMTP();
        //self::$_phpMailer->Host = '192.168.250.90';
        self::$_phpMailer->Host = '212.234.169.1';
        if (is_array($attachments))
            self::$_phpMailer->Host = '91.209.191.90';
        self::$_phpMailer->SMTPAuth = false;
        self::$_phpMailer->From = $from;
        self::$_phpMailer->FromName = $from_name;

        self::$_phpMailer->AddAddress($to);

        if (!empty($reply_to)) {
            self::$_phpMailer->AddReplyTo(strtolower($reply_to), '');
        }

        //if (is_utf8($msg_html) || $utf8) {
        if ($utf8)
            self::$_phpMailer->CharSet = "UTF-8";
        //	$utf8 = true;
        //}

        if (!$utf8 && is_utf8($msg_html))
            $msg_html = utf8_decode($msg_html);

        if (!$utf8 && is_utf8($subject))
            $subject = utf8_decode($subject);

        self::$_phpMailer->Subject = $subject;

        self::$_phpMailer->AltBody = $msg_txt;
        self::$_phpMailer->Body = $msg_html;

        if ($subject == 'Votre Avis sur le salon de la voyance')
            self::$_phpMailer->AddBCC('web@telemaque.fr');

        if (is_array($attachments)) {
            if (array_key_exists('path', $attachments))
                $attachments = array($attachments);
            foreach ($attachments as $attachment) {
                if (array_key_exists('path', $attachment) && array_key_exists('name', $attachment)) {
                    if (!$utf8 && is_utf8($attachment['name']))
                        $attachment['name'] = utf8_decode($attachment['name']);
                    if (!$utf8 && is_utf8($attachment['path']))
                        $attachment['path'] = utf8_decode($attachment['path']);

                    self::$_phpMailer->AddAttachment($attachment['path'], $attachment['name']);
                }
            }
        }

        return self::$_phpMailer->Send();
    }
}
