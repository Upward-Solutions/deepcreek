<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $idioma = $_GET['idioma'] ?? 'es';
    $mail->isSMTP();
//     $mail->Host       = 'smtp.gmail.com';
    $mail->Host       = 'c2661787.ferozo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@deepcreeksolutions.es';
    $mail->Password   = '/loUkDq1cU';
    $mail->Port       = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->setFrom('info@deepcreeksolutions.es', 'Formulario Web');
    $mail->addAddress('info@deepcreeksolutions.es');

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
        if ($idioma === 'en') {
            header("Location: /en/home.html?status=error");
        } else {
            header("Location: /index.html?status=error");
        }
    exit;
    } catch (Exception $e) {
        if ($idioma === 'en') {
            header("Location: /en/home.html?status=error");
        } else {
            header("Location: /index.html?status=error");
        }
        exit;
}


