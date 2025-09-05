<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar entradas
    $name     = htmlspecialchars($_POST['your-name'] ?? '');
    $surname  = htmlspecialchars($_POST['your-surnanme'] ?? '');
    $email    = htmlspecialchars($_POST['your-email'] ?? '');
    $phone    = htmlspecialchars($_POST['tel-502'] ?? '');
    $country  = htmlspecialchars($_POST['your-country'] ?? '');
    $company  = htmlspecialchars($_POST['your-company'] ?? '');
    $message  = htmlspecialchars($_POST['your-message'] ?? '');

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP (Mailtrap)
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Port       = 587;
        $mail->Username   = 'TU_USERNAME_MAILTRAP'; // 👈 reemplazar
        $mail->Password   = 'TU_PASSWORD_MAILTRAP'; // 👈 reemplazar
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // Remitente y destinatario
        $mail->setFrom('form@tu-dominio.com', 'Formulario Web');
        $mail->addAddress('destino@tu-dominio.com', 'Destinatario');

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Nueva consulta desde el formulario';
        $mail->Body = "
            <h3>Nuevo contacto</h3>
            <p><strong>Nombre:</strong> $name $surname</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Teléfono:</strong> $phone</p>
            <p><strong>País:</strong> $country</p>
            <p><strong>Empresa:</strong> $company</p>
            <p><strong>Mensaje:</strong><br>$message</p>
        ";
        $mail->AltBody = "Nombre: $name $surname\nEmail: $email\nTeléfono: $phone\nPaís: $country\nEmpresa: $company\nMensaje:\n$message";

        $mail->send();

        // Redirigir con parámetro de éxito
        header("Location: /index.html?status=ok");
        exit;
    } catch (Exception $e) {
        // Redirigir con parámetro de error
        header("Location: /index.html?status=error");
        exit;
    }
}
