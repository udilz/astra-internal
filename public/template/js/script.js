function currentTime() {
    var date = new Date();
    var day = date.getDay();
    var hour = date.getHours();
    var min = date.getMinutes();
    var sec = date.getSeconds();
    var month = date.getMonth();
    var currDate = date.getDate();
    var year = date.getFullYear();
    var monthName = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    var showDay = $(".hari span ");
    var midDay = "AM";
    midDay = (hour >= 12) ? "PM" : "AM";
    hour = (hour == 0) ? 12 : ((hour < 12) ? hour : (hour - 12));
    hour = updateTime(hour);
    min = updateTime(min);
    sec = updateTime(sec);
    currDate = updateTime(currDate);
    $("#time").html(`${hour}:${min}:`);
    $("#sec").html(`${sec}`);
    $("#mid").html(`${midDay}`);
    $(".tanggal").html(`${currDate}, ${monthName[month]} ${year}`);
    showDay.eq(day).css('opacity', '10');
}
updateTime = function (x) {
    if (x < 10) {
        return "0" + x;
    } else {
        return x;
    }
}
setInterval(currentTime, 1000);

