<?php

namespace app\helpers\email;

require_once dirname(dirname(dirname(__DIR__))) . '/public/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AppointmentConfirmation
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
     * Send appointment confirmation email
     * 
     * @param object $appointment The appointment object
     * @param string $notes Additional notes
     * @return bool Whether the email was sent successfully
     */
    public function sendAppointmentConfirmation($appointment, $notes = '')
    {
        try {

            $this->mailer->clearAllRecipients();
            $this->mailer->clearAttachments();


            $this->mailer->addAddress($appointment->email, $appointment->first_name . ' ' . $appointment->last_name);


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


            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Your Appointment Confirmation';


            $formattedTime = date('h:i A', strtotime($appointment->appointment_time));
            $formattedDate = date('l, F j, Y', strtotime($appointment->appointment_date));

            // Get doctor name
            $doctorName = '';
            if (!empty($appointment->doctor_first_name) && !empty($appointment->doctor_last_name)) {
                $doctorName = "Dr. {$appointment->doctor_first_name} {$appointment->doctor_last_name}";
            } else if (!empty($appointment->doctor_name)) {
                $doctorName = $appointment->doctor_name;
            }

            // Build email body with modern design
            $body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Appointment Confirmation</title>
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
                    .check-icon i {
                        display: block;
                        line-height: 1;
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
                        <h1>Confirmed!</h1>
                        <p class="subtitle">Your appointment has been successfully scheduled</p>
                    </div>
                    
                    <div class="content">
                        <p>Dear ' . $appointment->first_name . ' ' . $appointment->last_name . ',</p>
                        
                        <p>Thank you for scheduling an appointment with us. We\'re looking forward to seeing you!</p>
                        
                        <div class="appointment-details">
                            <h3><img src="cid:calendar-icon" alt="Calendar" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Appointment Details</h3>
                            
                            <div class="detail-row">
                                <div class="detail-label">Date:</div>
                                <div class="detail-value">' . $formattedDate . '</div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Time:</div>
                                <div class="detail-value">' . $formattedTime . '</div>
                            </div>';

            if (!empty($doctorName)) {
                $body .= '
                            <div class="detail-row">
                                <div class="detail-label">Provider:</div>
                                <div class="detail-value">' . $doctorName . '</div>
                            </div>';
            }

            if (!empty($appointment->appointment_type)) {
                $body .= '
                            <div class="detail-row">
                                <div class="detail-label">Type:</div>
                                <div class="detail-value">' . $appointment->appointment_type . '</div>
                            </div>';
            }

            if (!empty($appointment->location)) {
                $body .= '
                            <div class="detail-row">
                                <div class="detail-label">Location:</div>
                                <div class="detail-value">' . $appointment->location . '</div>
                            </div>';
            }

            $body .= '
                        </div>';

            if (!empty($notes)) {
                $body .= '
                        <div class="appointment-details">
                            <h3><img src="cid:notepad-icon" alt="Notes" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 5px;"> Additional Notes</h3>
                            <p>' . nl2br($notes) . '</p>
                        </div>';
            }

            $body .= '
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
                        
                        <a href="tel:+1234567890" class="button"><img src="cid:phone-icon" alt="Call" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;"> Call Us</a>
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
                        <p>© ' . date('Y') . ' Health Recording System. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ';

            $this->mailer->Body = $body;
            $this->mailer->AltBody = "Appointment Confirmation\n\nDear {$appointment->first_name} {$appointment->last_name},\n\nYour appointment has been confirmed for {$formattedDate} at {$formattedTime}.\n\nPlease arrive 15 minutes before your scheduled appointment time.\n\nIf you need to reschedule or cancel, please contact us at least 24 hours in advance.\n\nThank you for choosing our clinic.";

            // Enable debug output
            $this->mailer->SMTPDebug = 0; // Set to 2 for verbose debug output if needed

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }



    public function sendTrackingNumberConfirmation($data)
    {
        try {
            $this->mailer->clearAllRecipients();
            $this->mailer->clearAttachments();

            $this->mailer->addAddress($data['email'], $data['first_name'] . ' ' . $data['last_name']);

            // Add embedded images
            $logoPath = dirname(dirname(dirname(__DIR__))) . '/public/images/logo.png';
            $checkIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/check.png';
            $calendarIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/calendar-icon.png';
            $timeIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/time-icon.png';
            $idCardIconPath = dirname(dirname(dirname(__DIR__))) . '/public/images/icons/id-card-icon.png';

            $this->mailer->addEmbeddedImage($logoPath, 'logo', 'logo.png');
            $this->mailer->addEmbeddedImage($checkIconPath, 'check-icon', 'check.png');
            $this->mailer->addEmbeddedImage($calendarIconPath, 'calendar-icon', 'calendar-icon.png');
            $this->mailer->addEmbeddedImage($timeIconPath, 'time-icon', 'time-icon.png');
            $this->mailer->addEmbeddedImage($idCardIconPath, 'id-card-icon', 'id-card-icon.png');

            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Your Appointment Tracking Number';

            // Format date and time
            $formattedDate = date('l, F j, Y', strtotime($data['appointment_date']));
            $formattedTime = date('h:i A', strtotime($data['appointment_time']));

            // Email template
            $emailContent = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <div style="text-align: center; padding: 20px;">
                    <img src="cid:logo" alt="Logo" style="max-width: 150px;">
                </div>
                
                <div style="background-color: #f8f9fa; padding: 30px; border-radius: 10px; margin-top: 20px;">
                    <div style="text-align: center;">
                        <img src="cid:check-icon" alt="Success" style="width: 60px; margin-bottom: 20px;">
                        <h1 style="color: #28a745; margin: 0;">Appointment Booked!</h1>
                        <p style="color: #6c757d; margin-top: 10px;">Your appointment has been successfully booked.</p>
                    </div>

                    <div style="background-color: #e9ecef; padding: 20px; border-radius: 5px; margin: 20px 0; text-align: center;">
                        <h2 style="color: #495057; margin: 0;">Your Tracking Number</h2>
                        <div style="font-family: monospace; font-size: 24px; color: #212529; margin: 10px 0; padding: 10px; background-color: #fff; border-radius: 5px;">
                            ' . $data['tracking_number'] . '
                        </div>
                        <p style="color: #6c757d; margin: 0; font-size: 14px;">Please save this number to track your appointment</p>
                    </div>

                    <div style="margin-top: 30px;">
                        <h3 style="color: #495057;">Appointment Details</h3>
                        <div style="background-color: #fff; padding: 20px; border-radius: 5px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="padding: 10px; color: #6c757d;"><img src="cid:calendar-icon" alt="Date" style="width: 20px; vertical-align: middle;"> Date</td>
                                    <td style="padding: 10px;">' . $formattedDate . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; color: #6c757d;"><img src="cid:time-icon" alt="Time" style="width: 20px; vertical-align: middle;"> Time</td>
                                    <td style="padding: 10px;">' . $formattedTime . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; color: #6c757d;"><img src="cid:id-card-icon" alt="Doctor" style="width: 20px; vertical-align: middle;"> Doctor</td>
                                    <td style="padding: 10px;">Dr. ' . $data['doctor_name'] . '</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; color: #6c757d;">Type</td>
                                    <td style="padding: 10px;">' . ucfirst($data['appointment_type']) . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 10px;">
                    <h3 style="color: #495057;">What happens next?</h3>
                    <p style="color: #6c757d;">Our staff will review your appointment request and confirm it shortly.<br>You\'ll receive a confirmation email once approved.</p>
                </div>

                <div style="text-align: center; margin-top: 20px; color: #6c757d; font-size: 14px;">
                    <p>If you have any questions, please contact us at support@testclinic.com</p>
                </div>
            </div>';

            $this->mailer->Body = $emailContent;
            $this->mailer->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n\n"], $emailContent));

            return $this->mailer->send();
        } catch (\Exception $e) {
            error_log("Error sending tracking number confirmation email: " . $e->getMessage());
            return false;
        }
    }
}