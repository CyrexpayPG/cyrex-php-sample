<?php
$post_raw = file_get_contents('php://input');
// $post_data = json_decode($post_raw);
try {
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dapi.cyrexpay.com/payment/v1/checkout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_raw,
        CURLOPT_HTTPHEADER => array(
            'Authorization: sk_real_culturecash',
            'Content-Type: application/json'
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);

    echo $response;
} catch (\Throwable $th) {
    echo 'ERROR';
}
?>