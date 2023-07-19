PHP 결제 샘플
=============

## 데모결제

결제수단을 선택하고 결제하기 버튼을 누릅니다.

## 결제 순서

### 1. [index.php] 결제하기 버튼을 누르면, 결제 정보(JSON)를 [checkout.php]으로 ajax 요청을 보냅니다.

### 2. [checkout.php] 에서 Checkout API 요청을 보냅니다.

### 3. Checkout API 응답을 받았고 결과가 성공이라면, 응답 데이터에 포함된 link 를 [index.php] 에게 반환합니다.

>   Checkout API 응답은 JSON 형태입니다. result.resutCd 값이 "0000"이면 성공으로 판단합니다.

>   그 외에 에러코드를 받았다면, 실패사유에 따라 처리하시면 됩니다.

### 4. [index.php] 에서 ajax 응답으로 checkout 응답데이터 "link" 를 브라우저에 보여줍니다.

>   페이지를 redirect 할 수 있고, popup, iframe을 이용한 layer를 사용할 수 있습니다.

### 5. 사용자에의해 결제창이 완료되면, success.php 페이지로 응답이 전송됩니다.

>   에러 상황에서는 falture.php 로 응답을 받을 수 있습니다.

### 6. [success.php] 성공으로 결과를 전달받았다면, 마지막으로 "set" API 요청을 전송합니다.

>    "set" 요청을 전송하지 않으면 결제가 완료되지 않습니다.

>    "set" 요청이 끝난 후 응답 JSON을 DB에 저장합니다.

## 예외상황

"Set" 요청 후, 결제가 완료(실패포함)되면 [webhook.php] 으로 "set" API 응답과 동일한 응답을 전송합니다.

통신 또는 브라우저 문제로 [success.php]로 응답을 받지 못했을 경우에 사용할 수 있습니다.
 
trxId 로 중복 체크를 해서 중복된 거래내역 생성을 방지해야 합니다.
