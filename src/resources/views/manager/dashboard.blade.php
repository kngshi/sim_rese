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
    <div class="dashboard-sections">
    <a href="#" id="scanQRCode" class="link">QRコードを読み取る</a>
    </div>
    <div id="scanner-container"></div>
    <script>
        document.getElementById('scanQRCode').addEventListener('click', function() {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container'),
                },
                decoder: {
                    readers: ["code_128_reader"]
                }
            }, function(err) {
                if (err) {
                    console.error(err);
                    return;
                }
                Quagga.start();
            });
                Quagga.onDetected(function (result) {
                const code = result.codeResult.code;
                console.log("Detected code: " + code);

                axios.post('/manager/dashboard', { reservation_id: code })
                .then(function (response) {
                    const data = response.data;
                    if (data.message === '来店が確認されました。') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
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
