$(function () {
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1); // Set the date to tomorrow

    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        duration: "fast",
        minDate: tomorrow // Set the minimum date to tomorrow
    });
});
