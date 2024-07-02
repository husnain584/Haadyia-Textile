


<?php
// Verify reCAPTCHA
$recaptcha_secret = '6LdgKgUqAAAAAAmmQejr7w81jP-f9CnPJxg7HiDk';
$recaptcha_response = $_POST['g-recaptcha-response'];

$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
$response_keys = json_decode($response, true);

if (intval($response_keys["success"]) !== 1) {
    // reCAPTCHA verification failed
    die('reCAPTCHA verification failed.');
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];


    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    // Compose email headers
    $to = 'info@haadyiatextile.com';
    $subject = "Contact Form: $subject";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

    // Compose email body
    $message_body = "--boundary\r\n";
    $message_body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $message_body .= "Content-Transfer-Encoding: 7bit\r\n";
    $message_body .= "\r\n";
    $message_body .= "Name: $name\n\nEmail: $email\n\nMessage:\n$message\n\n";



    // Send email
    if (mail($to, $subject, $message_body, $headers)) {
        echo 'Email sent successfully.';
    } else {
        echo 'Failed to send email.';
    }
}
?>
