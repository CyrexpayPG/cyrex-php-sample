<!DOCTYPE html>
<html>
<head>
    <title>Cultureland</title>
</head>

<body>
    <h1>PHP Cultureland CodeSandbox</h1>
    
    <button onClick="checkout('culturecash');">상품권</button>
    <div>상품금액: <input id="amount-tag" value="1004"></input></div>
    <div>주문번호: <span id="trackId-tag"></span></div>

    <div style="margin-top:100px;">
        <textarea id="request-tag" cols="100" rows="40">
        </textarea>
    </div>
    <div style="margin-top:50px;">
        <textarea id="response-tag" cols="100" rows="40">
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
        
        function checkout(directMethod) {
            request.directMethod = directMethod;
            request.amount = Number(document.getElementById('amount-tag').value);
            request.products[0].price = request.amount;
            
            document.getElementById('request-tag').innerHTML = JSON.stringify(request,null,2);
            
            alert('결제창 요청');
            
            fetch('./checkout.php', {
                method: 'POST',
                cache: 'no-cache',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                },
                body: JSON.stringify(request)
            })
            .then((res) => res.text())
            .then((data) => {
                document.getElementById('response-tag').innerHTML = data;
                alert('결제창 요청 결과 확인');
                if(data == 'ERROR') {
                    alert('결제창 호출에 실패 했습니다.');
                } else {
                    var response = JSON.parse(data);
                    if(response.result.resultCd == '0000') {
                        window.location.href = response.link;
                    } else {
                        alert(response.result.resultCd);
                        // 오류상황 DB 저장 및 추가 처리 필요
                    }
                }

            });
        }
    </script>
</body>
</html>