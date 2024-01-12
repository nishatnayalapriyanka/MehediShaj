// This function runs when the document is ready
$(function () {

    // Create a new Date object representing the current date and time
    var tomorrow = new Date();

    // Set the date of the 'tomorrow' variable to one day ahead
    tomorrow.setDate(tomorrow.getDate() + 1);

    // Select the HTML element with the id 'datepicker' and apply the datepicker function to it
    $("#datepicker").datepicker({

        // Set the date format to "yy-mm-dd"
        dateFormat: "yy-mm-dd",

        // Set the minimum selectable date to tomorrow
        minDate: tomorrow,
    });

});
