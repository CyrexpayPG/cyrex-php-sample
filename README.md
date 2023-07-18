# PHP 결제 샘플

# 결제 순서

1. [index.php] 화면에서 결제 정보(JSON)를 생성합니다.
- ajax 통신으로 [checkout.php]으로 데이터를 전송합니다.

2. [checkout.php] backend 에서 checkout 요청을 보내 결과를 가져옵니다.

3. [index.php] 에서 ajax 응답으로 checkout 응답데이터 "link" 를 브라우저에 보여줍니다.
 - 예제에서처럼 redirect 할 수 있고, popup, iframe을 이용한 layer를 사용할 수 있습니다.

4. 사용자에의해 결제창이 완료되면, success.php, faulure.php 중 하나의 페이지로 응답이 전송됩니다.

5. [success.php] 성공으로 결과를 전달받았다면, 마지막으로 "set" API 요청을 전송합니다.
 - "set" 요청을 전송하지 않으면 결제가 완료되지 않습니다.
 - "set" 요청이 끝난 후 응답 JSON을 DB에 저장합니다.

# 예외상황

- 결제창이 중간에 종료되면 결과를 알 수 없습니다.
- "Set" 요청 후, 결제가 완료(실패포함)되면 [webhook.php] 으로 [success.php]와 동일한 응답을 전송합니다.
 통신 또는 브라우저 문제로 [success.php]로 응답을 받지 못했을 경우에 사용할 수 있습니다.
 trxId 로 중복 체크를 해서 중복된 거래내역 생성을 방지해야 합니다.