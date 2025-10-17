<?php
// =============================
// PayFast Checkout Integration
// =============================

$merchant_id  = "30520771";
$merchant_key = "edx939hu9sglg";
$passphrase   = "B/s1ntFl0raL_";

// Collect posted form data
$data = array(
    'merchant_id'    => $merchant_id,
    'merchant_key'   => $merchant_key,
    'return_url'     => 'https://bsilentofficial.co.za/order-success.html',
    'cancel_url'     => 'https://bsilentofficial.co.za/cancel.html',
    'notify_url'     => 'https://bsilentofficial.co.za/notify.php', // Only include if you want IPN
    'amount'         => $_POST['amount'] ?? '0.00',
    'item_name'      => $_POST['item_name'] ?? 'Flower Order',
    'name_first'     => $_POST['name_first'] ?? '',
    'name_last'      => $_POST['name_last'] ?? '',
    'email_address'  => $_POST['email_address'] ?? '',
    'cell_number'    => $_POST['cell_number'] ?? '',
    'custom_str1'    => $_POST['custom_str1'] ?? '',
    'custom_str2'    => $_POST['custom_str2'] ?? '',
    'custom_str3'    => $_POST['custom_str3'] ?? ''
);

// Step 1: Build the signature string in the correct order
$pfOutput = '';
foreach ($data as $key => $val) {
    if ($val !== '') {
        $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
    }
}
$pfOutput = rtrim($pfOutput, '&');

// Step 2: Add passphrase
if (!empty($passphrase)) {
    $pfOutput .= '&passphrase=' . urlencode($passphrase);
}

// Step 3: Generate signature
$signature = md5($pfOutput);

// Step 4: Add signature to data
$data['signature'] = $signature;

// Step 5: Redirect form to PayFast
$payfast_url = "https://www.payfast.co.za/eng/process";

echo '<form id="payfast_redirect" action="'.$payfast_url.'" method="post">';
foreach ($data as $key => $val) {
    if ($val !== '') {
        echo '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($val).'">';
    }
}
echo '</form>';
echo '<script>document.getElementById("payfast_redirect").submit();</script>';