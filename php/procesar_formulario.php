<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name'];
    $email = $_POST['email'];
    $mensaje = $_POST['subject'];
    $captcha = $_POST['h-captcha-response'];
    
    // Verificar el CAPTCHA
    $respuesta = file_get_contents("https://hcaptcha.com/siteverify?secret=ES_502fb82dae1c408186fae444f4ddd9d9&response=$captcha");
    $respuesta = json_decode($respuesta);
    
    if ($respuesta->success) {
        // El CAPTCHA es válido, procede a enviar el correo
        $destinatario = "fesotopedrero@gmail.com";
        $asunto = "Nuevo mensaje del formulario de contacto ZedTech";
        $cuerpo = "Nombre: $nombre\n";
        $cuerpo .= "Email: $email\n";
        $cuerpo .= "Mensaje:\n$mensaje";
        
        if (mail($destinatario, $asunto, $cuerpo)) {
            echo "¡El formulario se ha enviado con éxito!";
        } else {
            echo "Hubo un error al enviar el formulario.";
        }
    } else {
        // El CAPTCHA no es válido, muestra un mensaje de error o redirige al usuario
        echo "Por favor, complete el CAPTCHA correctamente.";
    }
} else {
    echo "Hubo un error al procesar el formulario.";
}
?>
