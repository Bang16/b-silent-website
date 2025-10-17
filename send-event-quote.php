<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access not allowed');
}

// Get form data
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$event_name = htmlspecialchars($_POST['event_name']);
$event_date = htmlspecialchars($_POST['event_date']);
$event_location = htmlspecialchars($_POST['event_location']);
$guest_count = htmlspecialchars($_POST['guest_count']);
$event_details = htmlspecialchars($_POST['event_details']);
$services = implode(', ', $_POST['services']);

$to = "info@bsilentofficial.co.za"; // Your business email

$email_subject = "Event Quote Request: $event_name";
$headers = "From: website@bsilentofficial.co.za\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$body = "
<h2>New Event Quote Request</h2>
<p><strong>Name:</strong> $name</p>
<p><strong>Email:</strong> $email</p>
<p><strong>Phone:</strong> $phone</p>
<p><strong>Event:</strong> $event_name</p>
<p><strong>Date:</strong> $event_date</p>
<p><strong>Location:</strong> $event_location</p>
<p><strong>Guests:</strong> $guest_count</p>
<p><strong>Services Needed:</strong> $services</p>
<p><strong>Details:</strong></p>
<p>$event_details</p>
";

// Send to business
$mail_sent = mail($to, $email_subject, $body, $headers);

// Auto-reply to user
$reply_subject = "Thank you for your event quote request";
$reply_headers = "From: B'Silent Events <website@bsilentofficial.co.za>\r\n";
$reply_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$reply_body = "
<h2>Thank you, $name!</h2>
<p>Your event quote request has been received. Our team will review your details and contact you soon.</p>
<p><strong>Event:</strong> $event_name<br>
<strong>Date:</strong> $event_date<br>
<strong>Location:</strong> $event_location<br>
<strong>Guests:</strong> $guest_count<br>
<strong>Services:</strong> $services</p>
<p>If you have urgent questions, please call or WhatsApp us directly.</p>
<p>Warm regards,<br>B'Silent Events Team</p>
";

mail($email, $reply_subject, $reply_body, $reply_headers);

if ($mail_sent) {
    header('Location: contact.html?status=event_success');
} else {
    header('Location: contact.html?status=event_error');
}
exit();
?>