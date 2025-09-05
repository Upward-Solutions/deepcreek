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
    $linkedin = htmlspecialchars($_POST['url-726'] ?? '');
    $present  = htmlspecialchars($_POST['presentacion'] ?? '');

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP (ejemplo con Mailtrap para pruebas)
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Port       = 587;
        $mail->Username   = 'TU_USERNAME_MAILTRAP';
        $mail->Password   = 'TU_PASSWORD_MAILTRAP';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // Remitente y destinatario
        $mail->setFrom('form@tu-dominio.com', 'Formulario Web');
        $mail->addAddress('destino@tu-dominio.com', 'RRHH');

        // Adjuntar CV si se subió
        if (!empty($_FILES['cvadjunto']['tmp_name'])) {
            $mail->addAttachment($_FILES['cvadjunto']['tmp_name'], $_FILES['cvadjunto']['name']);
        }

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Nueva postulación desde el formulario web';
        $mail->Body = "
            <h3>Datos del postulante</h3>
            <p><strong>Nombre:</strong> $name $surname</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Teléfono:</strong> $phone</p>
            <p><strong>LinkedIn:</strong> <a href='$linkedin'>$linkedin</a></p>
            <p><strong>Presentación:</strong><br>$present</p>
            <p><em>El CV se adjunta en este correo si fue cargado.</em></p>
        ";
        $mail->AltBody = "Nombre: $name $surname\nEmail: $email\nTeléfono: $phone\nLinkedIn: $linkedin\nPresentación:\n$present";

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
