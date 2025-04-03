<?php

namespace app\helpers\email;

require_once dirname(dirname(dirname(__DIR__))) . '/public/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);


        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['EMAIL_HOST'] ?? 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;

        $this->mailer->Username = $_ENV['EMAIL_USERNAME'] ?? '';
        $this->mailer->Password = $_ENV['EMAIL_PASSWORD'] ?? '';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $_ENV['EMAIL_PORT'] ?? 587;


        $this->mailer->setFrom($_ENV['EMAIL_USERNAME'] ?? '', $_ENV['EMAIL_FROM_NAME'] ?? 'Health Recording System');
    }

    

  


}