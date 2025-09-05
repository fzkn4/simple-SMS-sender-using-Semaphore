<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['phone']) || !isset($input['message']) || !isset($input['api_key'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Phone number, message, and API key are required']);
    exit();
}

$phone = trim($input['phone']);
$message = trim($input['message']);
$apiKey = trim($input['api_key']);

// Validate input
if (empty($phone) || empty($message) || empty($apiKey)) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit();
}

// Validate phone number format
$phone = preg_replace('/[^0-9+]/', '', $phone);
if (strlen($phone) < 10) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid phone number format']);
    exit();
}

// Check message length
if (strlen($message) > 1600) {
    http_response_code(400);
    echo json_encode(['error' => 'Message too long. Maximum 1600 characters allowed']);
    exit();
}

try {
    // Send SMS using Semaphore API
    $data = [
        'apikey' => $apiKey,
        'number' => $phone,
        'message' => $message,
        'sendername' => 'SMSAPP'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        throw new Exception('CURL Error: ' . $curlError);
    }
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        
        if (isset($result[0]['message_id'])) {
            echo json_encode([
                'success' => true,
                'message' => 'SMS sent successfully',
                'message_id' => $result[0]['message_id']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Invalid response from SMS provider: ' . $response
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'SMS provider returned HTTP ' . $httpCode . ': ' . $response
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'SMS sending failed: ' . $e->getMessage()
    ]);
}
?>
