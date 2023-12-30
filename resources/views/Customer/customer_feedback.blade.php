<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/customer_submit_feedback" enctype="multipart/form-data" class="form">
        @csrf 

        <div class="text_box">
            <p class="title"> Appointment Summary </p>
            <br>
            <p class="text">
                <span class="sub_title">Artist: </span> {{$appointment->artist->name}}
                <br>
                <span class="sub_title">Date: </span> {{$appointment->appointment->date}}
                <br>
                <span class="sub_title">Time: </span> {{$appointment->appointment->time}}
                <br>
                <span class="sub_title">Number of Clients for Non-Bridal Package: </span> {{ $appointment->appointment->num_of_clients_for_non_bridal_package}}
                <br>
                <span class="sub_title">Number of Clients for Bridal Package: </span> {{ $appointment->appointment->num_of_clients_for_bridal_package}}
                <br>
                <span class="sub_title">Booking Fee: </span> Tk {{$appointment->payment->total_booking_fee}}
                <br>
                <span class="sub_title">Service Charge: </span> Tk {{ $appointment->payment->total_service_charge }}
                <br>
            </p>
            <br> 
        </div>

        <div class="heading_box">
            <p class="title"> How was your experience? </p>
            <br>
        </div>
        <div class="stars_container">
            <input id="one" class="star"type="radio" name="ratings" value="1" >
            <input id="two" class="star"type="radio" name="ratings" value="2">
            <input id="three" class="star"type="radio" name="ratings" value="3">
            <input id="four" class="star"type="radio" name="ratings" value="4">
            <input id="five" class="star"type="radio" name="ratings" value="5">

            <label id="star_one" for="one" class="fa-solid fa-star"> </label>
            <label id="star_two" for="two" class="fa-solid fa-star"> </label>   
            <label id="star_three" for="three" class="fa-solid fa-star"> </label>    
            <label id="star_four" for="four" class="fa-solid fa-star"> </label>         
            <label id="star_five" for="five" class="fa-solid fa-star"> </label>

            <p class="sub_title" id="awful">Awful </p>
            <p class="sub_title"id="bad">Bad </p>
            <p class="sub_title" id="alright">Alright </p>
            <p class="sub_title" id="good">Good </p>
            <p class="sub_title" id="great">Great! </p>
        </div>
        <div class="errorMsg">
            @error('ratings')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <textarea class="comment" name="comment" value="{{old('comment')}}"
        placeholder="Tell others about your experience with {{$appointment->artist->name}}"></textarea>

        <input class="button" type="submit" value="Submit">
        
	</form>
</body>
</html>
