<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/payment.css') }}" />
        <title>Stripe決済</title>
    </head>
    <body>
        <form class="payment-form" id="payment-form" action="{{ url('payment') }}" method="POST">
            @csrf
            <input type="hidden" id="amount" name="amount" value="">
            <input type="hidden" name="stripeToken" id="stripeToken">
            <input type="hidden" name="stripeEmail" id="stripeEmail">
            <button class="custom-button" id="custom-button" type="button">決済をする</button>
            <a href="/mypage" class="back" >戻る</a>
        </form>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            document.getElementById('custom-button').addEventListener('click', function() {
                var amount = prompt("請求金額を入力してください（円）:");
                amount = parseInt(amount, 10) ;

                var stripe = StripeCheckout.configure({
                    key: '{{ env('STRIPE_KEY') }}',
                    locale: 'auto',
                    token: function(token) {
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