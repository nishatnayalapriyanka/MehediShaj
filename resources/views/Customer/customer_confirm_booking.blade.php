<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/customer_confirm_booking" enctype="multipart/form-data" class="form">
        @csrf 

        <div class="text_box">
            <p class="title"> Appointment Summary </p>
            <br>
            <p class="text">
                <span class="sub_title">Artist: </span> {{Session::get('booking_artist')}}
                <br>
                <span class="sub_title">Date: </span> {{Session::get('booking_date')}}
                <br>
                <span class="sub_title">Time: </span> {{Session::get('booking_time')}}
                <br>
                <span class="sub_title">Number of Clients for Non-Bridal Package: </span> {{Session::get('num_of_customer_for_non_bridal_package')}}
                <br>
                <span class="sub_title">Number of Clients for Bridal Package: </span> {{Session::get('num_of_customer_for_bridal_package')}}
                <br>
                <span class="sub_title">Booking Fee: </span> Tk {{Session::get('booking_fee')}}
                <br>
                <span class="sub_title">Service Charge: </span> {{Session::get('service_charge')}}
                <br>
                <span class="sub_title">Address: </span> {{Session::get('delivery_area')}} 
            </p>
            <br> 
            <p class="text" style="text-align: center;">
                 Pay the booking fee by  send money to <span class="sub_title">"01641496294"</span> & fill the payment details to confirm booking          
            </p>
        </div>

        <div class="input_box">
            <span class="las la-money-bill"> </span>         
            <select class="input" name="booking_payment_method" >
                <option value="">Choose Payment Method</option>
                <option value="Bkash">Bkash(Send Money)</option>
                <option value="Nagad">Nagad(Send Money)</option>
                <option value="Rocket">Rocket(Send Money)</option>
            </select>
        </div>
        <div class="errorMsg">
            @error('booking_payment_method')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-money-bill"> </span> 
	        <input class="input" type="text" name="booking_payment_transaction_id"
            placeholder="Enter Transaction ID" value="{{old('booking_payment_transaction_id')}}">
		</div>
        <div class="errorMsg">
            @error('booking_payment_transaction_id')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <input class="button" type="submit" value="Confirm">
        
	</form>

     <!-- Initialize Datepicker -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="JS/Customer/customer_select_input.js"></script>

    
    


</body>
</html>
