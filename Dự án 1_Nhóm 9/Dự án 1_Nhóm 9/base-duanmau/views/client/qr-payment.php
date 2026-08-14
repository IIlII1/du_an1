<br> <br>
<div class="container mt-5">
    <h2>Thanh toán qua QR Code</h2>
    <div class="text-center">
        <p>Vui lòng quét mã QR dưới đây để thanh toán đơn hàng <strong>#<?= $orderId ?></strong></p>
        
        <?php $amount = $order['total_money'] ?? $order['total_amount'] ?? 0; ?>
        <p>Số tiền: <strong><?= number_format((float)$amount, 0, ',', '.') ?> VNĐ</strong></p>
        
        <!-- VietQR API -->
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Rickrolling_QR_code.png?amount=<?= (int)$amount ?>&addInfo=DH<?= $orderId ?>&accountName=YOUR_NAME" alt="QR Code" style="max-width: 300px;">
        
        <p class="mt-3">Thời gian còn lại: <span id="countdown" style="font-weight: bold; color: red;">05:00</span></p>
    </div>
</div>

<script>
    let timeLeft = 300;
    const countdownEl = document.getElementById('countdown');
    const orderId = <?= $orderId ?>;

    const timer = setInterval(() => {
        timeLeft--;
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        countdownEl.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft <= 0) {
            clearInterval(timer);
            fetch('?mode=client&action=cancelOrder&order_id=' + orderId)
                .then(() => {
                    alert('Đơn hàng đã hết hạn và bị hủy.');
                    window.location.href = '?mode=client&action=cart';
                });
        }
    }, 1000);
</script>
