let startTime;       // Lưu thời điểm màn hình chuyển xanh (bắt đầu đếm giờ).
let timeoutHandle;   // Lưu ID của bộ đếm ngược (để có thể hủy nó nếu bấm quá sớm).
let delay = 0;       // Thời gian chờ ngẫu nhiên trước khi chuyển xanh.
let waitgreen = false; // Biến cờ (flag): true = đang màn hình đỏ, false = các trạng thái khác.
const area = document.getElementById("area");       // Lấy phần tử vùng bấm (thường là cái div to).
const display = document.getElementById("display"); // Lấy phần tử hiển thị chữ hướng dẫn.
const result = document.getElementById('result');   // Lấy phần tử hiển thị kết quả (ms).
function startRound(){
    waitgreen = false;              // Không phải đang chờ xanh, để tránh bị tính là bấm sớm.
    area.style.backgroundColor = 'blue'; // Đổi màu nền sang Xanh dương.
    display.textContent = 'Bấm vào màn hình để bắt đầu'; // Hướng dẫn người chơi.
    result.textContent = 'Time --'; // Reset kết quả cũ.

    area.onclick = handleclick;     // Gán sự kiện: khi click vào 'area' thì chạy hàm 'handleclick'.
}
function handleclick(){
    if(waitgreen){
        // Nếu waitgreen = true (đang đỏ) mà đã bấm -> Bấm sớm -> Thua.
        earlyclick();
    }
    else if(area.style.backgroundColor === 'green'){
        // Nếu màn hình đang xanh lá -> Bấm đúng lúc -> Tính giờ.
        endTimer();
    }else{
        // Trường hợp còn lại (đang xanh dương) -> Bắt đầu bài test.
        preparetest();
    }
}
function preparetest(){
    waitgreen = true;               // Bật cờ báo hiệu "đang chờ xanh".
    area.style.backgroundColor = 'red'; // Đổi màu đỏ.
    display.textContent = 'chờ xanh lá...';
    result.textContent = 'Đang chờ...';

    // Tạo thời gian ngẫu nhiên từ 2500ms đến 5000ms (2.5s - 5s)
    delay = Math.random() * 2500 + 2500;

    // Đặt bộ hẹn giờ: Sau khoảng 'delay', chạy hàm startTimer (chuyển xanh).
    // Lưu ID vào timeoutHandle để dùng cho việc hủy nếu cần.
    timeoutHandle = setTimeout(startTimer, delay);

    area.onclick = handleclick;     // Gán lại sự kiện click (đoạn này hơi thừa nhưng không sai).
}
function startTimer(){
    waitgreen = false;              // Tắt cờ chờ, giờ bấm là hợp lệ.
    startTime = new Date().getTime(); // QUAN TRỌNG: Lấy mốc thời gian hiện tại (theo mili giây).
    area.style.backgroundColor = 'green'; // Đổi màu xanh lá.
    display.textContent = 'BẤM NGAY!';

    area.onclick = handleclick;
}
function endTimer(){
    // Tính phản xạ: Thời điểm bấm (hiện tại) - Thời điểm bắt đầu (startTime).
    const reactionTime = new Date().getTime() - startTime;

    display.textContent = 'Thời gian phản ứng';
    result.textContent = ${reactionTime} ms; // Hiển thị kết quả.
    area.style.backgroundColor = "darkgreen"; // Đổi màu để báo hiệu đã xong.

    // Tự động reset game sau 2.5 giây.
    setTimeout(startRound, 2500);
}
function earlyclick(){
    clearTimeout(timeoutHandle);    // QUAN TRỌNG: Hủy cái hẹn giờ chuyển sang xanh lá (vì đã thua rồi).
    area.style.backgroundColor = 'darkred'; // Đổi màu báo lỗi.
    display.textContent = "thua";
    result.textContent = "thời gian"; // Thông báo lỗi bấm sớm.

    // Tự động reset game sau 2.5 giây.
    setTimeout(startRound, 2500);
}
startRound(); // Gọi hàm này đầu tiên để bắt đầu game khi trang web vừa tải xong.
