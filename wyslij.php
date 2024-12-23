<?php

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



require 'vendor/autoload.php';



// Przechwycenie danych z formularza

$nameL = trim($_POST['nameL'] ?? 'Anonim');

$company = trim($_POST['company'] ?? '');

$email = trim($_POST['email'] ?? '');

$tel = trim($_POST['tel'] ?? '');

$message = trim($_POST['message'] ?? '');



// Walidacja po stronie serwera

$errors = [];



if (empty($nameL) || strlen($nameL) < 2) {

    $errors[] = 'Proszę podać imię (co najmniej 2 znaki).';

}



if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $errors[] = 'Proszę podać prawidłowy adres e-mail.';

}



if (empty($message) || strlen($message) < 10) {

    $errors[] = 'Wiadomość musi zawierać co najmniej 10 znaków.';

}



// Sprawdź, czy wystąpiły błędy

if (!empty($errors)) {

    // Tutaj możesz zdecydować, jak obsłużyć błędy, np. wyświetlić je użytkownikowi

    echo join('<br>', $errors);

    exit; // Zakończ wykonanie skryptu, jeśli wystąpiły błędy

}



$mail = new PHPMailer(true);



try {

    // Konfiguracja i wysyłanie wiadomości, jak w poprzednim przykładzie...

    $mail->isSMTP();

    $mail->Host = 'mail.sweetsteviam.com';

    $mail->SMTPAuth = true;

    $mail->Username = '';

    $mail->Password = '';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;



    $mail->setFrom('office@sweetsteviam.com', 'Website Contact');

    $mail->addAddress('office@sweetsteviam.com', 'sweetsteviam');

    $mail->addReplyTo($email, $nameL);



    $mail->isHTML(true);

    $mail->Subject = 'Message from ' . $nameL;

    $mail->Body    = "From $nameL (e-mail: $email) (company: $company) (tel: $tel):<br><br>" . nl2br($message);

    $mail->AltBody = "Message from $nameL (e-mail: $email) (company: $company) (tel: $tel):\n\n$message";



    $mail->send();

    echo 'Wiadomość została wysłana.';

} catch (Exception $e) {

    echo "Wiadomość nie mogła zostać wysłana. Błąd: {$mail->ErrorInfo}";

}

