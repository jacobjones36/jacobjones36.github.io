<?php
header('Access-Control-Allow-Origin: https://jacobjones36.github.io');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Workato-Dedup');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$workato_url = 'https://webhooks.workato.com/webhooks/rest/df8233f0-887c-4239-89de-c13afcce444f/manual-reduction';L
$payload = file_get_contents('php://input');
$dedup_header = isset($_SERVER['HTTP_X_WORKATO_DEDUP']) ? $_SERVER['HTTP_X_WORKATO_DEDUP'] : '';

$ch = curl_init($workato_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Workato-Dedup: ' . $dedup_header
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($status);
echo $response;
?>
