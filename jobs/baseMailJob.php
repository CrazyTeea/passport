<?php


namespace app\jobs;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use yii\base\BaseObject;
use yii\queue\JobInterface;

abstract class baseMailJob extends BaseObject implements JobInterface
{
    protected $mailer;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->mailer = new PHPMailer(true);
        $this->mailer->SMTPDebug = /*getenv('YII_DEBUG') ? SMTP::DEBUG_SERVER : */SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $this->mailer->isSMTP();                                   //Send using SMTP
        $this->mailer->Host = getenv('MAIL_HOST');           //Set the SMTP server to send through
        $this->mailer->SMTPAuth = true;                            //Enable SMTP authentication
        $this->mailer->Username = getenv('MAIL_LOGIN');      //SMTP username
        $this->mailer->Password = getenv('MAIL_PASSWORD');   //SMTP password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;//Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mailer->Port = getenv('MAIL_PORT');           //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->setFrom(getenv('MAIL_LOGIN'), 'ИАС Мониторинг');
    }
}
