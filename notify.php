<?php
// =============================
// PayFast Notify Script (IPN)
// =============================

// 1. Read POST data from PayFast
$data = $_POST;

// 2. Create a log (optional but very useful for debugging)
$logFile = __DIR__ . "/payfast_ipn.log";
$logData = date("Y-m-d H:i:s") . " - " . json_encode($data) . PHP_EOL;
file_put_contents($logFile, $logData, FILE_APPEND);

// 3. Prepare email
$to = "info@bsilentofficial.co.za";
$subject = "New PayFast Payment Notification";
$message = "Hello,\n\nYou received a new payment via PayFast.\n\nDetails:\n\n";

// Add POST data to email body
foreach ($data as $key => $value) {
    $message .= ucfirst($key) . ": " . $value . "\n";
}

$message .= "\nRegards,\nYour Website";

// 4. Send email
$headers = "From: no-reply@bsilentofficial.co.za\r\n";
$headers .= "Reply-To: no-reply@bsilentofficial.co.za\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

mail($to, $subject, $message, $headers);

// 5. Always return 200 OK to PayFast
header("HTTP/1.1 200 OK");
