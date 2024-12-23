<?php
include 'config.php';
include 'mpesa_config.php';

if(isset($_POST['booking_id']) && isset($_POST['phone']) && isset($_POST['amount'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    // Get Access Token
    $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic UUxhejhhcW02dWtoS0VoOUdFaTBVM0dva0V2SjlSbktROFdxTHBpQUtKNnBnWHZXOnBldlJ2WXRnYkJrQWRxa3RUdEM2QXlQUXVVaGtLSjZnaTU2Um5henJ0MjliZVB3R2dsbmJaUzNNeUlaWldsMlA=']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $access_token = json_decode($response)->access_token;

    $curl_post_data = array(
        'Initiator' => 'testapi',
        'SecurityCredential' => 'U1RISKUaP/+qQzOcs3/FXngxbxvLjbm4RuxRnvwazw8u9U/IZxThENcAFoI00U9lGWlox3SJGhw/JSHt2b9s+0aejSvH6Nd61d1uJQD0Xy5Bmpm8gYaB6buDYwDd9Ru1V56tedDsIOlR8D3WHvpXBUjnNF4IpT6uu5NyxJjLMBdxVZ9d2hg3cUE3xKONSvJg9HUzQDuToYD4nd/pUZ21W7tpaRq8viKRQezei/3sQQgkmltJd2bzHwbcBAwTXjouFc7AACfjnMmUqUvEHvCPn7aS12QQduwKFPqIVLgOmmeBJ9fmw/2p8ppywIOiLstoWeEKtslIPgFd287f9zfBYA==',
        'CommandID' => 'BusinessPayBill',
        'SenderIdentifierType' => '4',
        'RecieverIdentifierType' => 4,
        'Amount' => ceil($amount),
        'PartyA' => 600982,
        'PartyB' => 400200,
        'AccountReference' => 25476886203101,
        'Requester' => $phone,
        'Remarks' => 'Parking Payment #'.$booking_id,
        'QueueTimeOutURL' => TIMEOUT_URL,
        'ResultURL' => CALLBACK_URL
    );

    $data_string = json_encode($curl_post_data);
    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);

    file_put_contents('mpesa_log.txt', date('Y-m-d H:i:s') . ": Response: " . $response . "\n", FILE_APPEND);
    
    curl_close($ch);
    
    echo $response;
}
?>
