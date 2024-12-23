<?php
include 'config.php';
include 'lipia_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required parameters
    if (!isset($_POST['phone']) || !isset($_POST['amount']) || !isset($_POST['booking_id'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
        exit;
    }

    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $booking_id = $_POST['booking_id'];

    // Initialize cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://lipia-api.kreativelabske.com/api/request/stk",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'phone' => $phone,
            'amount' => $amount
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer 6cca150aa8b3eac5ee0a0f8d425e72e0659fffdb",
            'Content-Type: application/json'
        ],
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        echo json_encode(['success' => false, 'message' => 'Connection error']);
        exit;
    }

    $data = json_decode($response, true);
    // Add debug logging
    error_log("Lipia Response: " . print_r($data, true));
    
    // If reference is received, store it
    if (isset($data['data']['reference'])) {
        $reference = mysqli_real_escape_string($conn, $data['data']['reference']);
        $insert_query = "INSERT INTO payment_logs (booking_id, reference) VALUES ($booking_id, '$reference')";
        // Add debug logging
        error_log("SQL Query: " . $query);
        
        if(mysqli_query($conn, $query)) {
            error_log("Reference saved successfully");
        } else {
            error_log("Error saving reference: " . mysqli_error($conn));
        }
    }
    
    echo $response;
}
?>
