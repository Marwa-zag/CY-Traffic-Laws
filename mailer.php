<?php
// Inclure l'autoload de Composer pour charger les dépendances
require 'vendor/autoload.php';

// Utilisez les namespaces de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact.cy.traffic.lawsl@gmail.com';
        $mail->Password = 'groupen2024';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Utilisez SMTPS
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Utilisez STARTTLS si vous utilisez le port 587
        $mail->Port = 465; // Utilisez le port 465 pour SMTPS ou 587 pour STARTTLS

        // Expéditeur et destinataire
        $mail->setFrom('contact.cy.traffic.lawsl@gmail.com', 'CY Traffic Laws');
        $mail->addAddress($to);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}");
        return false;
    }
}
?>
