<?php
// === Retrieve POST/GET request data ===
$transid = $_REQUEST["TransId"];
$status  = $_REQUEST["Status"];
$errdesc = $_REQUEST["ErrDesc"];

// === Replace with your actual logic ===
$status = 1;

if ($status == "1") {
    // ✅ Payment successful
    // TODO: Update your database order status to "PAID" using $transid

    // Set HTTP response code to 200 (OK)
    http_response_code(200);

    // Output RECEIVEOK (plain text)
    echo "RECEIVEOK";
    exit;
}
?>
