<?php
echo '<h1>[가맹점] 결제 실패 페이지</h1>';
$result = $_GET['result'];
$resultMsg = $_GET['resultMsg'];
$trackId = $_GET['trackId'];
$token = $_GET['token'];
$trxId = $_GET['trxId'];

echo '<div>result: '.$result.'</div>';
echo '<div>resultMsg: '.$resultMsg.'</div>';
echo '<div>token: '.$token.'</div>';
echo '<div>trackId: '.$trackId.'</div>';
echo '<div style="margin-bottom:50px;">trxId: '.$trxId.'</div>';

try {
    $curl = curl_init();
    $configVars = parse_ini_file('config.ini', TRUE);
    $domain = $configVars['basic']['domain'];
    $directMethod = $_COOKIE[$trackId];
    $sk = $configVars['basic']['sk_'.$directMethod];
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => $domain.'/payment/v1/get/'.$token,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '',
        CURLOPT_HTTPHEADER => array(
            'Authorization: '.$sk
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);

    echo $response;
} catch (\Throwable $th) {
    echo '<div>RESPONSE ERROR</div>';
}
?>