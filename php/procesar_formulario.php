<?php
// Iniciar sesión si no está iniciada
session_start();

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se completó el reCAPTCHA
    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = "6Lc7zXYpAAAAAL6Z9FKCvD35fuBn90wGTwSiEWYp";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha);
    $responseKeys = json_decode($response, true);
    
    // Si el reCAPTCHA fue completado correctamente, procesar el formulario
    if ($responseKeys["success"]) {
        // Recoger los datos del formulario
        $nombre = $_POST['name'];
        $email = $_POST['email'];
        $mensaje = $_POST['subject'];
        
        // Aquí puedes añadir más validaciones de los campos del formulario si es necesario
        
        // Procesar el envío del correo electrónico
        $para = "fesotopedrero@gmail.com";
        $asunto = "Mensaje de contacto de $nombre";
        $contenido = "Nombre: $nombre\nCorreo electrónico: $email\nMensaje: $mensaje";
        $cabeceras = "From: $email";

        // Enviar el correo electrónico
        $envio_exitoso = mail($para, $asunto, $contenido, $cabeceras);

        // Configurar el mensaje de respuesta
        if ($envio_exitoso) {
            $response = array('message' => '¡Gracias! Tu mensaje ha sido enviado correctamente.', 'type' => 'success');
        } else {
            $response = array('message' => 'Error: No se pudo enviar el formulario. Por favor, intenta nuevamente.', 'type' => 'error');
        }

        // Devolver la respuesta al cliente
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Si el reCAPTCHA no fue completado correctamente, configurar un mensaje de error
        $_SESSION['message'] = "Error: Por favor, completa el reCAPTCHA correctamente.";
    }
}
?>
