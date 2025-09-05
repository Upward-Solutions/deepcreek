<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contacto@deepcreeksolutions.es';
    $mail->Username   = 'info@deepcreeksolutions.com';
    $mail->Password   = 'CONTRASEÑA_O_APP_PASSWORD';
    $mail->Port       = 587;
//     $mail->Host       = 'sandbox.smtp.mailtrap.io';
//     $mail->SMTPAuth   = true;
//     $mail->Username   = '1ec0905bd31b46';
//     $mail->Password   = 'b1d349e63bed8e';
//     $mail->Port       = 25;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->setFrom('contacto@deepcreeksolutions.es', 'Formulario Web');
    $mail->addAddress('tudestino@otrodominio.com');

    $name    = $_POST['your-name']    ?? '';
    $email   = $_POST['your-email']   ?? '';
    $phone   = $_POST['tel-502']      ?? '';
    $message = $_POST['your-message'] ?? '';

    $mail->isHTML(true);
    $mail->Subject = 'Nueva consulta desde el formulario';
    $mail->Body    = "
        <h3>Consulta recibida</h3>
        <p><strong>Nombre:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Teléfono:</strong> {$phone}</p>
        <p><strong>Mensaje:</strong><br>{$message}</p>
    ";
    $mail->AltBody = "Nombre: $name\nEmail: $email\nTeléfono: $phone\nMensaje:\n$message";
    $mail->send();
    header("Location: site/index.html?status=ok");
} catch (Exception $e) {
//     echo "Error: {$mail->ErrorInfo}";
    header("Location: site/index.html?status=error");
} finally {
    exit;
}

