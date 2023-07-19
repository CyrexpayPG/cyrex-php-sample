<!DOCTYPE html>
<html>
<head>
    <title>Cultureland</title>
</head>

<body>
    <button onClick="checkout('culturecash')">상품권</button>
    <button onClick="checkout('microcb')">휴대폰결제</button>
    
    <div style="display:none;">
        <div>상품금액: <input id="amount-tag" value="1004"></input></div>
        <div>주문번호: <span id="trackId-tag"></span></div>
    </div>
    <div style="margin-top:100px;">
        <h3 id="request-title"></h3>
        <textarea id="request-tag" cols="100" rows="40">
        </textarea>
    </div>
    
    <script>
        const trackId = 'TRX-' + new Date().getTime();
        document.getElementById('trackId-tag').innerText = trackId;

        var request = {
            "trackId": trackId,
            "directMethod": "",
            "currency": "KRW",
            "amount": 0,
            "returnUrl": window.location.origin + "/success.php",
            "failureUrl": window.location.origin + "/failure.php",
            "webhook": window.location.origin + "/webhook.php",
            "products": [
                {
                    "name": "상품명",
                    "qty": 1,
                    "price": 0
                }
            ],
            "customer": {
                "memberId": "USER-1689660742",
                "email": "dev@cyrexpay.com",
                "name": "홍길동",
                "bill": {
                    "countryCode": "KR"
                }
            },
            "udf1": "유저 세팅값",
            "udf2": "유저 세팅값 2번째",
            "udf3": "유저 세팅값 3번째"
        }
        
        async function checkout(directMethod) {
            request.directMethod = directMethod;
            request.amount = Number(document.getElementById('amount-tag').value);
            request.products[0].price = request.amount;
            
            await showRequest(request, '현재 생성된 결제창을 요청하는 데이터 입니다.');
            alert('요청 전문 확인을 위해 진행을 일시 정지했습니다.\n전문 데이터 중 일부는 서버에서 설정됩니다.');
            // 가맹점 Backend 서버와 통신합니다.
            const responseFeatch = await fetch('./checkout.php', {
                method: 'POST',
                cache: 'no-cache',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                },
                body: JSON.stringify(request)
            });
            const response = await responseFeatch.json();
            if(response.error && response.error == '통신장애') {
                alert('결제창 호출에 실패 했습니다.');
                return;
            }
            
            await showRequest(response, '현재 응답받은 데이터 입니다.');
            alert('응답 전문 확인을 위해 진행을 일시 정지했습니다.');
            
            if(response.result.resultCd == '0000') {
                window.location.href = response.link;
            } else {
                alert(response.result.resultCd);
                // 오류상황 DB 저장 및 추가 처리 필요
            }
        }

        // ------------ UTIL
        async function showRequest(request, title) {
            document.getElementById('request-title').innerHTML = title;
            document.getElementById('request-tag').innerHTML = JSON.stringify(request,null,2);
            await sleep(100);
        }
        function sleep(msec) {
            return new Promise(resolve => setTimeout(resolve, msec));
        }
    </script>
</body>
</html>