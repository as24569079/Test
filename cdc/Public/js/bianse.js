$(document).ready(function () {
    var color = "#F9F9F9"
    $("#neirong>tr:odd").css("background-color", color);
    $(".neirong").mouseenter(function () {
        $(this).css("background-color", "#D0DDE3");
    }).mouseleave(function () {
        $(this).css("background-color", "#fff");
        $(".neirong:odd").css("background-color", color);
    })
})