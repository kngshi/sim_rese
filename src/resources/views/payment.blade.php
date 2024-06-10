<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Stripe決済</title>
    </head>
    <body>
    
    <form id="payment-form" action="{{ url('payment') }}" method="POST">
        @csrf
        <input type="hidden" id="amount" name="amount" value="">
        <input type="hidden" name="stripeToken" id="stripeToken">
        <input type="hidden" name="stripeEmail" id="stripeEmail">
        <button id="custom-button" type="button">決済をする</button>
        <a href="/mypage" class="back" >戻る</a>
    </form>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            text-align: center;
        }
        #payment-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        #custom-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 20px 40px; /* ボタンのサイズを大きく */
            cursor: pointer;
            font-size: 20px; /* フォントサイズを大きく */
        }
        #custom-button:hover {
            background-color: #0056b3;
        }
        .back {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            margin-top: 20px; /* ボタンからの距離を追加 */
        }
        .back:hover {
            color: #0056b3;
        }
    </style>

    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
        document.getElementById('custom-button').addEventListener('click', function() {
            // 例: 動的に金額を設定する
            var amount = prompt("請求金額を入力してください（円）:");
            amount = parseInt(amount, 10) ; // 最小通貨単位に変換（例: 100円 -> 10000）
            
            var stripe = StripeCheckout.configure({
                key: '{{ env('STRIPE_KEY') }}',
                locale: 'auto',
                token: function(token) {
                    // token をサーバーに送信
                    document.getElementById('stripeToken').value = token.id;
                    document.getElementById('stripeEmail').value = token.email;
                    document.getElementById('amount').value = amount;
                    var form = document.getElementById('payment-form');
                    form.submit();
                }
            });

            stripe.open({
                name: 'Stripe決済デモ',
                description: 'これはデモ決済用のフォームです',
                amount: amount,
                currency: 'JPY',
                image: 'https://stripe.com/img/documentation/checkout/marketplace.png'
            });
        });
    </script>
</body>
</html>