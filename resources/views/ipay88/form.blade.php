<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to iPay88...</title>
    <style>
        /* Full-page loader styles */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(203, 200, 200, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 4px solid rgba(15, 87, 34, 0.3);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body onload="document.forms['ipay88Form'].submit();">

    <!-- Full-page loader -->
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <!-- Hidden form for submitting the payment -->
    <form name="ipay88Form" method="post" action="{{ $response_body['action_url'] }}">
        <input type="hidden" name="MerchantCode" value="{{ $response_body['merchantCode'] }}">
        <input type="hidden" name="RefNo" value="{{ $response_body['refNo'] }}">
        <input type="hidden" name="Amount" value="{{ $response_body['amount'] }}">
        <input type="hidden" name="Currency" value="{{ $response_body['currency'] }}">
        <input type="hidden" name="ProdDesc" value="{{ $response_body['prodDesc'] }}">
        <input type="hidden" name="UserName" value="{{ $response_body['userName'] }}">
        <input type="hidden" name="UserEmail" value="{{ $response_body['userEmail'] }}">
        <input type="hidden" name="UserContact" value="{{ $response_body['userContact'] }}">
        <input type="hidden" name="Lang" value="UTF-8">
        <input type="hidden" name="SignatureType" value="HMAC-SHA512">
        <input type="hidden" name="Signature" value="{{ $response_body['signature'] }}">
        <input type="hidden" name="ResponseURL" value="{{ url('/ipay/response') }}">
        <input type="hidden" name="BackendURL" value="{{ url('/ipay/response') }}">
    </form>

</body>
</html>
