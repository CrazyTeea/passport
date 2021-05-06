<?php

namespace app\jobs;

class fileMail extends baseMailJob
{
    public $file;
    public $mail;
    public $subject;
    public $message;

    public function execute($queue)
    {
        $this->mailer->addAddress($this->mail);
        $this->mailer->Body = $this->message;
        $this->mailer->addAttachment($this->file);
        $this->mailer->send();
        // TODO: Implement execute() method.
    }
}