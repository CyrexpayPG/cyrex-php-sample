<?php
echo '<h1>[가맹점] 결제 실패 페이지</h1>';
$result = $_GET['result'];
$trackId = $_GET['trackId'];
$token = $_GET['token'];
$trxId = $_GET['trxId'];

echo '<div>result: '.$result.'</div>';
echo '<div>token: '.$token.'</div>';
echo '<div>trackId: '.$trackId.'</div>';
echo '<div style="margin-bottom:50px;">trxId: '.$trxId.'</div>';


?>