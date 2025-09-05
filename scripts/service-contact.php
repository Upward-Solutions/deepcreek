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
        $idioma = $_GET['idioma'] ?? 'es';
        $mail->isSMTP();
        $mail->Host       = 'c2661787.ferozo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@deepcreeksolutions.es';
        $mail->Password   = '/loUkDq1cU';
        $mail->Port       = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom('info@deepcreeksolutions.es', 'Formulario Web');
        $mail->addAddress('info@deepcreeksolutions.es');

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

        if ($idioma === 'en') {
            header("Location: /en/home.html?status=ok");
        } else {
            header("Location: /index.html?status=ok");
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
}
