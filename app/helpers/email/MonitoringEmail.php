<?php

namespace app\helpers\email;
require_once dirname(dirname(dirname(__DIR__))) . '/public/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MonitoringEmail
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

    public function sendMonitoringRequest($recipientEmail, $recipientName, $token, $doctorName, $duration, $verificationCode)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->clearReplyTos();

            $this->mailer->addAddress($recipientEmail, $recipientName);
            $this->mailer->Subject = 'TeleCure - Health Monitoring Access Code';

            // Update the URL to match the route pattern
            $monitoringLink = BASE_URL . '/patient/verify/' . $token;

            $emailContent = $this->getMonitoringEmailTemplate([
                'patient_name' => $recipientName,
                'doctor_name' => $doctorName,
                'monitoring_link' => $monitoringLink,
                'duration' => $duration,
                'verification_code' => $verificationCode,
                'clinic_name' => $_ENV['CLINIC_NAME'] ?? 'TeleCure',
                'clinic_phone' => $_ENV['CLINIC_PHONE'] ?? '(555) 123-4567',
            ]);

            $this->mailer->isHTML(true);
            $this->mailer->Body = $emailContent;
            $this->mailer->AltBody = strip_tags(str_replace(['<br>', '</p>'], "\n", $emailContent));

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log('Monitoring request email sending failed: ' . $e->getMessage());
            return false;
        }
    }

    private function getMonitoringEmailTemplate($data)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #4F46E5; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background-color: #f9fafb; }
                .button { display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: white; 
                          text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .verification-code { font-size: 24px; font-weight: bold; text-align: center; 
                                   padding: 20px; margin: 20px 0; background-color: #e5e7eb; 
                                   border-radius: 5px; letter-spacing: 2px; }
                .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>TeleCure Health Monitoring Access</h2>
                </div>
                <div class="content">
                    <p>Dear ' . htmlspecialchars($data['patient_name']) . ',</p>
                    
                    <p>Dr. ' . htmlspecialchars($data['doctor_name']) . ' has requested to monitor your health status for the next ' . htmlspecialchars($data['duration']) . ' days.</p>
                    
                    <p>Your verification code is:</p>
                    <div class="verification-code">' . htmlspecialchars($data['verification_code']) . '</div>
                    
                    <p>Please use this code when accessing your monitoring dashboard through the link below:</p>
                    
                    <p style="text-align: center;">
                        <a href="' . htmlspecialchars($data['monitoring_link']) . '" class="button">Access Monitoring Dashboard</a>
                    </p>
                    
                    <p><strong>Important Notes:</strong></p>
                    <ul>
                        <li>This verification code is valid for 15 minutes</li>
                        <li>The code can only be used once</li>
                        <li>Please log your health status daily</li>
                        <li>Contact us immediately if you experience severe symptoms</li>
                    </ul>
                    
                    <p>If you have any questions, please contact us at ' . htmlspecialchars($data['clinic_phone']) . '.</p>
                </div>
                <div class="footer">
                    <p>' . htmlspecialchars($data['clinic_name']) . '</p>
                    <p>This is an automated message, please do not reply directly to this email.</p>
                </div>
            </div>
        </body>
        </html>';
    }
}