<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access not allowed');
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$subject = htmlspecialchars($_POST['subject']);
$message = htmlspecialchars($_POST['message']);

$to = "info@bsilentofficial.co.za";
$email_subject = "B'Silent Contact: $subject";
$headers = "From: info@bsilentofficial.co.za\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$body = "
<h2>New Contact Form Submission</h2>
<p><strong>Name:</strong> $name</p>
<p><strong>Email:</strong> $email</p>
<p><strong>Phone:</strong> $phone</p>
<p><strong>Subject:</strong> $subject</p>
<p><strong>Message:</strong></p>
<p>$message</p>
";

if (mail($to, $email_subject, $body, $headers)) {
    header('Location: contact.html?status=success');
    exit();
} else {
    header('Location: contact.html?status=error');
    exit();
}
?>