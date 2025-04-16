<?php


namespace app\helpers\email;
require_once dirname(dirname(dirname(__DIR__))) . '/public/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PrescriptionEmail
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
     * Send prescription email with attachments
     * 
     * @param string $recipientEmail
     * @param string $recipientName
     * @param string $prescriptionImage Base64 encoded image
     * @param string $additionalMessage Optional message to include
     * @param bool $includeInstructions Whether to include medication instructions
     * @return bool
     */
    public function sendPrescription($recipientEmail, $recipientName, $prescriptionImage, $additionalMessage = '')
    {
        try {
            // Reset all recipients and attachments
            $this->mailer->clearAddresses();
            $this->mailer->clearReplyTos();
            $this->mailer->clearAttachments();

            // Set recipient
            $this->mailer->addAddress($recipientEmail, $recipientName);
            $this->mailer->Subject = 'Your Medical Prescription';
            $this->mailer->setFrom($_ENV['EMAIL_USERNAME'] ?? '', $_ENV['EMAIL_FROM_NAME'] ?? 'Health Recording System');
            $this->mailer->addReplyTo($_ENV['EMAIL_USERNAME'] ?? '', $_ENV['EMAIL_FROM_NAME'] ?? 'Health Recording System');

            // Process and attach prescription as both image and PDF
            if (!empty($prescriptionImage)) {
                if (strpos($prescriptionImage, 'data:image/') === 0) {
                    $prescriptionImage = preg_replace('/^data:image\/\w+;base64,/', '', $prescriptionImage);
                }

                $imageData = base64_decode($prescriptionImage);

                // Attach original image
                $this->mailer->addStringAttachment($imageData, 'prescription.png', 'base64', 'image/png');

                // Convert to PDF and attach
                $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage();

                // Convert image data to temporary file
                $tempImage = tempnam(sys_get_temp_dir(), 'prescription');
                file_put_contents($tempImage, $imageData);

                // Add image to PDF with proper scaling
                $pdf->Image($tempImage, 10, 10, 190);
                unlink($tempImage); // Clean up temp file

                $pdfData = $pdf->Output('prescription.pdf', 'S');
                $this->mailer->addStringAttachment($pdfData, 'prescription.pdf', 'base64', 'application/pdf');
            }

            // Create email content
            $emailContent = $this->getPrescriptionEmailTemplate([
                'patient_name' => $recipientName,
                'additional_message' => $additionalMessage,
                'clinic_name' => $_ENV['CLINIC_NAME'] ?? 'Health Recording System',
                'clinic_address' => $_ENV['CLINIC_ADDRESS'] ?? '123 Medical Center Blvd, Suite 100',
                'clinic_phone' => $_ENV['CLINIC_PHONE'] ?? '(555) 123-4567',
            ]);

            $this->mailer->isHTML(true);
            $this->mailer->Body = $emailContent;
            $this->mailer->AltBody = strip_tags(str_replace('<br>', "\n", $emailContent));

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Prescription email sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get prescription email HTML template
     *
     * @param array $data Email template data
     * @return string HTML email content
     */
    private function getPrescriptionEmailTemplate($data)
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Your Medical Prescription</title>
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
                h1 {
                    margin: 10px 0;
                    font-size: 28px;
                }
                .subtitle {
                    font-size: 16px;
                    opacity: 0.9;
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
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <h2>' . ($data['clinic_name'] ?? 'Health Recording System') . '</h2>
                </div>
                
                <div class="banner">
                    <h1>Your Medical Prescription</h1>
                    <p class="subtitle">Please find your prescription attached</p>
                </div>
                
                <div class="content">
                    <p>Dear ' . $data['patient_name'] . ',</p>
                    
                    <p>Your medical prescription is attached to this email. Please find the following documents:</p>
                    
                    <ul>
                        <li><strong>Prescription Image</strong> - A digital copy of your prescription</li>
                        <li><strong>Prescription Details</strong> - A PDF with additional information (if applicable)</li>
                    </ul>
                    
                    ' . (!empty($data['additional_message']) ? '<p><strong>Doctor\'s Note:</strong> ' . nl2br($data['additional_message']) . '</p>' : '') . '
                    
                    <p>If you have any questions about your prescription or need further assistance, please contact our office.</p>
                    
                    <p>Thank you for choosing our healthcare services.</p>
                    
                    <p>Best regards,<br>
                    ' . ($data['clinic_name'] ?? 'Health Recording System') . ' Team</p>
                </div>
                
                <div class="footer">
                    <p>' . ($data['clinic_name'] ?? 'Health Recording System') . '</p>
                    <p>' . ($data['clinic_address'] ?? '123 Medical Center Blvd, Suite 100') . '</p>
                    <p>Phone: ' . ($data['clinic_phone'] ?? '(555) 123-4567') . '</p>
                    <p>© ' . date('Y') . ' Health Recording System. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';
    }
}