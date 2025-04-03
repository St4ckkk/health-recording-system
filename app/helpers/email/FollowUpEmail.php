<?php

namespace app\helpers\email;

require_once dirname(dirname(dirname(__DIR__))) . '/public/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class FollowUpEmail
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






    /**
     * Send follow-up appointment notification email
     * 
     * @param string $recipientEmail
     * @param string $recipientName
     * @param array $data
     * @return bool
     */
    public function sendFollowUpNotification($recipientEmail, $recipientName, $data)
    {
        try {
            // Reset all recipients and reply-to
            $this->mailer->clearAddresses();
            $this->mailer->clearReplyTos();
            $this->mailer->clearAttachments();

            // Set recipient
            $this->mailer->addAddress($recipientEmail, $recipientName);

            // Set email subject
            $this->mailer->Subject = 'Follow-up Appointment Scheduled';

            // Set sender - use the same sender configuration as in the constructor
            $this->mailer->setFrom($_ENV['EMAIL_USERNAME'] ?? '', $_ENV['EMAIL_FROM_NAME'] ?? 'Health Recording System');

            // Set reply-to
            $this->mailer->addReplyTo($_ENV['EMAIL_USERNAME'] ?? '', $_ENV['EMAIL_FROM_NAME'] ?? 'Health Recording System');

            // Add all necessary images
            $logoPath = dirname(dirname(dirname(__DIR__))) . '/public/images/logo.png';
            $checkIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/check.png';
            $calendarIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/calendar-icon.png';
            $notepadIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/notepad-icon.png';
            $infoIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/info-icon.png';
            $timeIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/time-icon.png';
            $idCardIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/id-card-icon.png';
            $phoneIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/phone-icon.png';
            $facebookIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/facebook-icon.png';
            $twitterIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/twitter-icon.png';
            $instagramIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/instagram-icon.png';

            $this->mailer->addEmbeddedImage($logoPath, 'logo', 'logo.png');
            $this->mailer->addEmbeddedImage($checkIconPath, 'check-icon', 'check.png');
            $this->mailer->addEmbeddedImage($calendarIconPath, 'calendar-icon', 'calendar-icon.png');
            $this->mailer->addEmbeddedImage($notepadIconPath, 'notepad-icon', 'notepad-icon.png');
            $this->mailer->addEmbeddedImage($infoIconPath, 'info-icon', 'info-icon.png');
            $this->mailer->addEmbeddedImage($timeIconPath, 'time-icon', 'time-icon.png');
            $this->mailer->addEmbeddedImage($idCardIconPath, 'id-card-icon', 'id-card-icon.png');
            $this->mailer->addEmbeddedImage($phoneIconPath, 'phone-icon', 'phone-icon.png');
            $this->mailer->addEmbeddedImage($facebookIconPath, 'facebook-icon', 'facebook-icon.png');
            $this->mailer->addEmbeddedImage($twitterIconPath, 'twitter-icon', 'twitter-icon.png');
            $this->mailer->addEmbeddedImage($instagramIconPath, 'instagram-icon', 'instagram-icon.png');

            // Create email content
            $emailContent = $this->getFollowUpTemplate($data);

            // Set email body
            $this->mailer->isHTML(true);
            $this->mailer->Body = $emailContent;
            $this->mailer->AltBody = strip_tags(str_replace('<br>', "\n", $emailContent));

            // Send email
            $this->mailer->send();

            return true;
        } catch (Exception $e) {
            error_log('Follow-up email sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get follow-up email template
     * 
     * @param array $data
     * @return string
     */
    private function getFollowUpTemplate($data)
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Follow-up Appointment Scheduled</title>
            <style>
                body, html {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                    overflow: hidden;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                }
                .header {
                    padding: 20px;
                    text-align: center;
                    background-color: #ffffff;
                    border-bottom: 1px solid #f0f0f0;
                }
                .banner {
                    background-color: #00406a;
                    background-image: linear-gradient(135deg, #00406a 0%, #005d99 100%);
                    color: white;
                    text-align: center;
                    padding: 40px 20px;
                }
                .check-icon-container {
                    width: 70px;
                    height: 70px;
                    margin: 0 auto 15px;
                    position: relative;
                }
                .check-icon {
                    background-color: #2ecc71;
                    color: white;
                    width: 70px;
                    height: 70px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 35px;
                    position: absolute;
                    top: 0;
                    left: 0;
                }
                .check-icon img {
                    display: block;
                    margin: auto;
                }
                .content {
                    padding: 30px;
                    background-color: #ffffff;
                }
                .footer {
                    background-color: #f9f9f9;
                    padding: 20px;
                    text-align: center;
                    font-size: 12px;
                    color: #666;
                    border-top: 1px solid #f0f0f0;
                }
                .social-icons {
                    text-align: center;
                    padding: 15px 0;
                }
                .social-icons a {
                    display: inline-block;
                    margin: 0 10px;
                    color: #00406a;
                    text-decoration: none;
                }
                .social-icon {
                    width: 36px;
                    height: 36px;
                    background-color: #00406a;
                    border-radius: 50%;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 18px;
                }
                .social-icon img {
                    display: block;
                    margin: auto;
                }
                h1 {
                    margin: 10px 0;
                    font-size: 28px;
                }
                .subtitle {
                    font-size: 16px;
                    opacity: 0.9;
                }
                .appointment-details {
                    background-color: #f9f9f9;
                    border-radius: 5px;
                    padding: 15px;
                    margin: 20px 0;
                }
                .appointment-details h3 {
                    margin-top: 0;
                    color: #00406a;
                }
                .button {
                    display: inline-block;
                    background-color: #00406a;
                    color: white;
                    padding: 12px 25px;
                    text-decoration: none;
                    border-radius: 5px;
                    margin-top: 15px;
                    font-weight: bold;
                }
                .detail-row {
                    display: flex;
                    margin-bottom: 8px;
                }
                .detail-label {
                    font-weight: bold;
                    width: 100px;
                }
                .detail-value {
                    flex: 1;
                }
                .reminder-item {
                    display: flex;
                    align-items: flex-start;
                    margin-bottom: 10px;
                }
                .reminder-icon {
                    color: #00406a;
                    margin-right: 10px;
                    font-size: 18px;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <img src="cid:logo" alt="Health Recording System Logo" style="max-height: 50px;">
                </div>
                
                <div class="banner">
                    <div class="check-icon-container">
                        <div class="check-icon">
                            <img src="cid:check-icon" alt="✓" style="width: 40px; height: 40px; display: block; margin: auto;">
                        </div>
                    </div>
                    <h1>Follow-up Scheduled!</h1>
                    <p class="subtitle">Your follow-up appointment has been confirmed</p>
                </div>
                
                <div class="content">
                    <p>Dear ' . $data['patient_name'] . ',</p>
                    
                    <p>This is to confirm that your follow-up appointment with ' . $data['doctor_name'] . ' has been scheduled.</p>
                    
                    <div class="appointment-details">
                        <h3><img src="cid:calendar-icon" alt="Calendar" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Follow-up Appointment Details</h3>
                        
                        <div class="detail-row">
                            <div class="detail-label">Date:</div>
                            <div class="detail-value">' . $data['appointment_date'] . '</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Time:</div>
                            <div class="detail-value">' . $data['appointment_time'] . '</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Doctor:</div>
                            <div class="detail-value">' . $data['doctor_name'] . '</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Reason:</div>
                            <div class="detail-value">' . $data['follow_up_reason'] . '</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Tracking #:</div>
                            <div class="detail-value">' . $data['tracking_number'] . '</div>
                        </div>
                    </div>
                    
                    ' . (!empty($data['special_instructions']) ? '
                    <div class="appointment-details">
                        <h3><img src="cid:notepad-icon" alt="Notes" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Special Instructions</h3>
                        <p>' . nl2br($data['special_instructions']) . '</p>
                    </div>' : '') . '
                    
                    <p><strong><img src="cid:info-icon" alt="Info" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Please remember:</strong></p>
                    
                    <div class="reminder-item">
                        <img src="cid:time-icon" alt="Time" style="width: 18px; height: 18px; margin-right: 10px;">
                        <div>Arrive 15 minutes before your scheduled appointment time</div>
                    </div>
                    
                    <div class="reminder-item">
                        <img src="cid:id-card-icon" alt="ID Card" style="width: 18px; height: 18px; margin-right: 10px;">
                        <div>Bring your insurance card and photo ID</div>
                    </div>
                    
                    <div class="reminder-item">
                        <img src="cid:phone-icon" alt="Phone" style="width: 18px; height: 18px; margin-right: 10px;">
                        <div>If you need to reschedule or cancel, please contact us at least 24 hours in advance</div>
                    </div>
                    
                    <p>If you have any questions or need to make changes to your appointment, please contact our office.</p>
                    
                    <a href="tel:' . $data['clinic_phone'] . '" class="button"><img src="cid:phone-icon" alt="Call" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;"> Call Us</a>
                </div>
                
                <div class="social-icons">
                    <a href="#" title="Facebook">
                        <div class="social-icon">
                            <img src="cid:facebook-icon" alt="Facebook" style="width: 18px; height: 18px; display: block; margin: auto;">
                        </div>
                    </a>
                    <a href="#" title="Twitter">
                        <div class="social-icon">
                            <img src="cid:twitter-icon" alt="Twitter" style="width: 18px; height: 18px; display: block; margin: auto;">
                        </div>
                    </a>
                    <a href="#" title="Instagram">
                        <div class="social-icon">
                            <img src="cid:instagram-icon" alt="Instagram" style="width: 18px; height: 18px; display: block; margin: auto;">
                        </div>
                    </a>
                </div>
                
                <div class="footer">
                    <p>' . $data['clinic_name'] . '</p>
                    <p>' . $data['clinic_address'] . '</p>
                    <p>Phone: ' . $data['clinic_phone'] . '</p>
                    <p>© ' . date('Y') . ' Health Recording System. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Get follow-up email HTML template
     *
     * @param array $data Email template data
     * @return string HTML email content
     */
    private function getFollowUpEmailTemplate($data)
    {
        $template = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Follow-up Appointment Scheduled</title>
            <style>
            body, html {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                border: 1px solid #e0e0e0;
                border-radius: 5px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }
            .header {
                padding: 20px;
                text-align: center;
                background-color: #ffffff;
                border-bottom: 1px solid #f0f0f0;
            }
            .banner {
                background-color: #4CAF50;
                background-image: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
                color: white;
                text-align: center;
                padding: 40px 20px;
            }
            .content {
                padding: 30px;
                background-color: #ffffff;
            }
            .footer {
                background-color: #f9f9f9;
                padding: 20px;
                text-align: center;
                font-size: 12px;
                color: #666;
                border-top: 1px solid #f0f0f0;
            }
            .social-icons {
                text-align: center;
                padding: 15px 0;
            }
            .social-icons a {
                display: inline-block;
                margin: 0 10px;
                color: #4CAF50;
                text-decoration: none;
            }
            .social-icon {
                width: 36px;
                height: 36px;
                background-color: #4CAF50;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 18px;
            }
            .social-icon img {
                display: block;
                margin: auto;
            }
            h1 {
                margin: 10px 0;
                font-size: 28px;
            }
            .subtitle {
                font-size: 16px;
                opacity: 0.9;
            }
            .appointment-details {
                background-color: #f9f9f9;
                border-radius: 5px;
                padding: 15px;
                margin: 20px 0;
            }
            .appointment-details h3 {
                margin-top: 0;
                color: #4CAF50;
            }
            .button {
                display: inline-block;
                background-color: #4CAF50;
                color: white;
                padding: 12px 25px;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 15px;
                font-weight: bold;
            }
            .detail-row {
                display: flex;
                margin-bottom: 8px;
            }
            .detail-label {
                font-weight: bold;
                width: 100px;
            }
            .detail-value {
                flex: 1;
            }
            .reminder-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 10px;
            }
            .reminder-icon {
                margin-right: 10px;
                font-size: 18px;
            }
        </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <img src="cid:logo" alt="Health Recording System Logo" style="max-height: 50px;">
                </div>
                
                <div class="banner">
                    <h1>Follow-up Scheduled</h1>
                    <p class="subtitle">Your follow-up appointment has been confirmed</p>
                </div>
                
                <div class="content">
                    <p>Dear ' . $data['patient_name'] . ',</p>
                    
                    <p>This email confirms that a follow-up appointment has been scheduled for you. We look forward to seeing you again!</p>
                    
                    <div class="appointment-details">
                        <h3><img src="cid:calendar-icon" alt="Calendar" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Follow-up Appointment Details</h3>
                        
                        <div class="detail-row">
                            <div class="detail-label">Date:</div>
                            <div class="detail-value">' . $data['appointment_date'] . '</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Time:</div>
                            <div class="detail-value">' . $data['appointment_time'] . '</div>
                        </div>';

        if (!empty($data['doctor_name'])) {
            $template .= '
                        <div class="detail-row">
                            <div class="detail-label">Provider:</div>
                            <div class="detail-value">' . $data['doctor_name'] . '</div>
                        </div>';
        }

        $template .= '
                        <div class="detail-row">
                            <div class="detail-label">Type:</div>
                            <div class="detail-value">Follow-up</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Tracking #:</div>
                            <div class="detail-value">' . $data['tracking_number'] . '</div>
                        </div>
                    </div>';

        if (!empty($data['follow_up_reason'])) {
            $template .= '
                    <div class="appointment-details">
                        <h3><img src="cid:notepad-icon" alt="Notes" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Reason for Follow-up</h3>
                        <p>' . nl2br($data['follow_up_reason']) . '</p>
                    </div>';
        }

        if (!empty($data['special_instructions'])) {
            $template .= '
                    <div class="appointment-details">
                        <h3><img src="cid:info-icon" alt="Info" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Special Instructions</h3>
                        <p>' . nl2br($data['special_instructions']) . '</p>
                    </div>';
        }

        $template .= '
                    <p><strong><img src="cid:info-icon" alt="Info" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Please remember:</strong></p>
                    
                    <div class="reminder-item">
                        <img src="cid:time-icon" alt="Time" style="width: 18px; height: 18px; margin-right: 10px;">
                        <div>Arrive 15 minutes before your scheduled appointment time</div>
                    </div>
                    
                    <div class="reminder-item">
                        <img src="cid:id-card-icon" alt="ID Card" style="width: 18px; height: 18px; margin-right: 10px;">
                        <div>Bring your insurance card and photo ID</div>
                    </div>
                    
                    <div class="reminder-item">
                        <img src="cid:phone-icon" alt="Phone" style="width: 18px; height: 18px; margin-right: 10px;">
                        <div>If you need to reschedule or cancel, please contact us at least 24 hours in advance</div>
                    </div>
                    
                    <p>If you have any questions or need to make changes to your appointment, please contact our office.</p>
                    
                    <a href="tel:' . $data['clinic_phone'] . '" class="button">
                        <img src="cid:phone-icon" alt="Call" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                        Call Us
                    </a>
                </div>
                
                <div class="social-icons">
                    <a href="#" title="Facebook">
                        <div class="social-icon">
                            <img src="cid:facebook-icon" alt="Facebook" style="width: 18px; height: 18px; display: block; margin: auto;">
                        </div>
                    </a>
                    <a href="#" title="Twitter">
                        <div class="social-icon">
                            <img src="cid:twitter-icon" alt="Twitter" style="width: 18px; height: 18px; display: block; margin: auto;">
                        </div>
                    </a>
                    <a href="#" title="Instagram">
                        <div class="social-icon">
                            <img src="cid:instagram-icon" alt="Instagram" style="width: 18px; height: 18px; display: block; margin: auto;">
                        </div>
                    </a>
                </div>
                
                <div class="footer">
                    <p>' . $data['clinic_name'] . '</p>
                    <p>' . $data['clinic_address'] . '</p>
                    <p>Phone: ' . $data['clinic_phone'] . '</p>
                    <p>© ' . date('Y') . ' Health Recording System. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';

        return $template;
    }

    /**
     * Get follow-up email plain text version
     * 
     * @param array $data Email template data
     * @return string Plain text email content
     */
    private function getFollowUpEmailPlainText($data)
    {
        $text = "Follow-up Appointment Scheduled\n\n" .
            "Dear {$data['patient_name']},\n\n" .
            "This email confirms that a follow-up appointment has been scheduled for you. We look forward to seeing you again!\n\n" .
            "FOLLOW-UP APPOINTMENT DETAILS\n" .
            "Date: {$data['appointment_date']}\n" .
            "Time: {$data['appointment_time']}\n";

        if (!empty($data['doctor_name'])) {
            $text .= "Provider: {$data['doctor_name']}\n";
        }

        $text .= "Type: Follow-up Appointment\n" .
            "Tracking #: {$data['tracking_number']}\n";

        if (!empty($data['follow_up_reason'])) {
            $text .= "\nREASON FOR FOLLOW-UP\n" .
                "{$data['follow_up_reason']}\n";
        }

        if (!empty($data['special_instructions'])) {
            $text .= "\nSPECIAL INSTRUCTIONS\n" .
                "{$data['special_instructions']}\n";
        }

        $text .= "\nPLEASE REMEMBER:\n" .
            "- Arrive 15 minutes before your scheduled appointment time\n" .
            "- Bring your insurance card and photo ID\n" .
            "- If you need to reschedule or cancel, please contact us at least 24 hours in advance\n\n" .
            "If you have any questions or need to make changes to your appointment, please contact our office at {$data['clinic_phone']}.\n\n" .
            "Thank you for choosing {$data['clinic_name']}.\n\n" .
            "{$data['clinic_name']}\n" .
            "{$data['clinic_address']}\n" .
            "Phone: {$data['clinic_phone']}\n\n" .
            "© " . date('Y') . " Health Recording System. All rights reserved.";

        return $text;
    }

}