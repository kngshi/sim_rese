@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/manager/dashboard.css') }}" />
@endsection

@section('content')
    <h1>店舗責任者用ダッシュボード</h1>
    <h2>店舗管理</h2>
    <div class="dashboard-sections">
        <div class="dashboard-section">
            <a href="/manager/create" class="link" >店舗情報の作成</a>
            <a href="/manager/edit" class="link" >店舗情報の更新</a>
        </div>
    </div>
    <h2>予約管理</h2>
    <div class="dashboard-sections">
        <div class="dashboard-section">
            <a href="/manager/index" class="link">予約情報の確認</a>
            <a href="/manager/notify" class="link">お知らせメールの送信</a>
        </div>
    </div>
    <h2>QRコードの読み取り</h2>
    <div class="dashboard-section">
    <a href="#" id="scanQRCode" class="link">QRコードを読み取る</a>
    <div id="scanner-container"></div>
</div>
<script>
    document.getElementById('scanQRCode').addEventListener('click', function() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner-container'), // カメラプレビューを表示するための要素
            },
            decoder: {
                readers: ["code_128_reader"] // QRコードを読み取るためのリーダー
            }
        }, function(err) {
            if (err) {
                console.error(err);
                return;
            }
            Quagga.start();
        });
            // バックエンドの処理を呼び出すなどの追加処理を行う
            // QRコード読み取り時の処理
            Quagga.onDetected(function (result) {
            const code = result.codeResult.code; // QRコードの内容
            console.log("Detected code: " + code);

            // バックエンドのqrConfirmアクションにリクエストを送信する
            axios.post('/mypage', { reservation_id: code })
            .then(function (response) {
                // バックエンドからのレスポンスに応じて処理を行う
                const data = response.data;
                if (data.message === '来店が確認されました。') {
                    alert(data.message); // 成功メッセージを表示
                    // 予約情報のステータスが変更されたため、ページを更新して最新の情報を表示する
                    location.reload();
                } else {
                    alert(data.message); // エラーメッセージを表示
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        });

            Quagga.stop();
        });
</script>
@endsection
