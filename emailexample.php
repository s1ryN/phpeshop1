<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';

// Admin email
$admin_email = "example@example.cz";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Očištění proměnných převzetých z HTML a převedení na PHP
    $name = strip_tags(trim($_POST["jmeno"]));
    $surname = strip_tags(trim($_POST["prijmeni"]));
    $phone = strip_tags(trim($_POST["telefon"]));
    $user_email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $loading_address = strip_tags(trim($_POST["adrnas"]));
    $unloading_address = strip_tags(trim($_POST["adrvys"]));
    $note = strip_tags(trim($_POST["poznamka"]));
    $check = $_POST["check"]; // Honeypot proti botům

    // Check honeypotu, pokud tam něco je, formulář se nepošle
    if (!empty($check)) {
        echo "Bzzzzzzz.";
        exit;
    }

    // Checkne formulář
    if (empty($name) || empty($surname) || empty($phone) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        // Pokud něco chybí
        echo "Prosím vyplňte všechna požadovaná pole.";
    } else {
        $mail = new PHPMailer(true);
        try {
            //Nastavení serveru
            $mail->isSMTP();                                            // Používá SMTP (Simple Mail Transfer Protocol)
            $mail->Host       = 'smtp.supermailserver.cz';              // Určení SMTP serveru (dle WEDOSu se může měnit)
            $mail->SMTPAuth   = true;                                   // Povolí ověření SMTP
            $mail->Username   = 'exampleemail@example.cz';              // SMTP přihlašovací jméno 
            $mail->Password   = 'example';                              // SMTP heslo
            $mail->SMTPSecure = 'tls';                                  // TLS šifrování pro SMTPS
            $mail->Port       = 420;                                    // TCP Port pro připojení

            // Nastavení charsetu na UTF-8
            $mail->CharSet = 'UTF-8';

            //Zákazník dostane mail
            $mail->setFrom('exampleemail@example.cz', 'Example');
            $mail->addAddress($user_email);     // Dodá toho, komu se pošle

            // Obsah emailu pro zákazníka
            $mail->isHTML(true);                                        // Formátování emailu do html
            $mail->ContentType = 'text/html; charset=UTF-8';      
            // Hlavička emailu                            
            $mail->Subject = 'Random hlavička';
            // Kontent emailu
            $mail->Body    = "Dobrý den $name,<br><br>Vaše zpráva k nám dorazila a naši kolegové se vám v co nejkratší době ozvou.<br><br>S přáním krásného dne firma XXXX";

            // Odeslání mailu a zpráva o jeho odeslání
            $mail->send();
            echo "Potvrzovací email odeslán na $user_email.";

            // Vyčistí původní adresy, aby případně email pro admina nedošel na email zákazníka
            $mail->clearAddresses();

            // Poslání emailu adminovi
            $mail->addAddress($admin_email);   // Vezme adminův email

            // Obsah emailu pro admina
            $mail->ContentType = 'text/html; charset=UTF-8';  
            // Hlavička emailu
            $mail->Subject = "Random Example: $name $surname";
            // Kontent emailu
            $mail->Body    = "Nová žádost obdržena:<br><br>Jméno: $name $surname<br>Tel. číslo: $phone<br>Email: $user_email<br>Adresa naložení: $loading_address<br>Adresa vyložení: $unloading_address<br>Poznámka: $note";

            // Odeslání emailu a zprávy ohledně odeslání
            $mail->send();
            echo "Email byl odeslán adminovi.";
        } catch (Exception $e) {
            echo "Email nemohl být odeslán: {$mail->ErrorInfo}";
        }
    }
} else {
    // Není POST request
    echo "Odeslání formuláře selhalo.";
}
?>