<?php
echo 'webhook (Backend async request)';
$post_raw = file_get_contents('php://input');
echo $post_raw;
// $post_data = json_decode($post_raw);
// trxId or trackId 중복체크 필수
?>