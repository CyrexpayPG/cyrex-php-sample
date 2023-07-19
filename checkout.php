<?php
$post_raw = file_get_contents('php://input');
try {
    $post_data = json_decode($post_raw);
    $curl = curl_init();
    $configVars = parse_ini_file('config.ini', TRUE);
    $domain = $configVars['basic']['domain'];
    $directMethod = $post_data->directMethod;
    $cookieName = $post_data->trackId;
    setcookie($cookieName, $directMethod, time() + 3600);
    $sk = $configVars['basic']['sk_'.$directMethod];
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => $domain.'/payment/v1/checkout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_raw,
        CURLOPT_HTTPHEADER => array(
            'Authorization: '.$sk,
            'Content-Type: application/json'
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);

    echo $response;
} catch (\Throwable $th) {
    echo '{"error": "통신장애"}';
}
?>