<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    @foreach($package as $package)
        @if($package->category == "Non-Bridal")
            @php
                $non_bridal_starting_price = $package->starting_price;
                $non_bridal_maximum_price = $package->maximum_price;
            @endphp
        @elseif($package->category == "Bridal")
            @php
                $bridal_starting_price = $package->starting_price;
                $bridal_maximum_price = $package->maximum_price;
            @endphp
        @else
            @php
                $home_service_charge = $package->starting_price;
            @endphp
        @endif
    @endforeach
	<form method="post" action="/customer_booking" enctype="multipart/form-data" class="form">
        @csrf 

        <img class="artist_pic" src="Artist Profile Picture/{{$artist->profile_pic}}">
        <div class="heading_box">
            <p class="title">{{Session::get('booking_artist')}} </p>
            <p class="text">
                @if($feedback->isNotEmpty())
                    <i class="fa-solid fa-star"></i> {{ number_format( $feedback->avg('ratings') ,1) }}({{$feedback->count()}})
                    <a href="/customer_booking_artist_view_ratings" target="_blank">
                         View Ratings <i class="fa-solid fa-angle-right"></i>
                    </a>
                @endif
            </p>
            <p class="text">
                @if($gallery->isNotEmpty())
                    <a href="/customer_booking_artist_view_gallery" target="_blank">
                        View Gallery <i class="fa-solid fa-angle-right"></i>
                    </a>
                @endif
            </p>
        </div>

        <div class="input_box">
            <i class="las la-calendar-day"></i>
            <input class="input" type="text" id="datepicker" name="booking_date"
            autocomplete="off" value="{{old('booking_date')}}" placeholder="Choose Date" readonly>
            <i class="far fa-calendar-alt calendar_icon"></i>
        </div>
        <div class="errorMsg">
            @error('booking_date')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
            <i class="las la-clock"></i>          
            <select class="input" name="booking_time" >
                <option id="first_option" value="">Choose Time</option>
                <option value="10 AM">10 AM</option>
                <option value="11 AM">11 AM</option>
                <option value="12 PM">12 PM</option>
                <option value="3 PM">3 PM</option>
                <option value="4 PM">4 PM</option>
                <option value="5 PM">5 PM</option>
                <option value="6 PM">6 PM</option>
                <option value="7 PM">7 PM</option>
                <option value="8 PM">8 PM</option>
                <option value="9 PM">9 PM</option>
            </select>
        </div>
        <div class="errorMsg">
            @error('booking_time')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="heading_box">
            <p class="title">Non-Bridal Package </p>
            <p class="sub_title">One handside/foot per person(simple to gorgeous)</p>
            <p class="sub_title">Number of Clients(Min: 0, Max:10)</p>
            <p class="text"><span class="sub_title">Starting Price:</span> Tk {{$non_bridal_starting_price }}</p>
            <p class="text"><span class="sub_title"> Maximum Price:</span> Tk {{$non_bridal_maximum_price }}</p>
        </div>
        <div class="input_box">
            <i class="las la-female"></i> 
            <input class="input cart" type="number"
            name="num_of_customer_for_non_bridal_package"
            min="0" max="10" value="0" readonly>
            <i class="las la-minus" onclick="decrementValue('num_of_customer_for_non_bridal_package')"></i>
            <i class="las la-plus" onclick="incrementValue('num_of_customer_for_non_bridal_package')"></i>
        </div>
        <div class="errorMsg">
            @error('num_of_customer_for_non_bridal_package')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="heading_box">
            <p class="title">Bridal Package </p>
            <p class="sub_title">Only hand/hand with foot per person(simple to gorgeous)</p>
            <p class="sub_title">Number of Clients(Min: 0, Max:10)</p>
            <p class="text"><span class="sub_title">Starting Price:</span> Tk {{$bridal_starting_price }}</p>
            <p class="text"><span class="sub_title"> Maximum Price:</span> Tk {{$bridal_maximum_price }}</p>
        </div>
        <div class="input_box">
            <i class="las la-female"></i> 
            <input class="input cart" type="number"
            name="num_of_customer_for_bridal_package"
            min="0" max="10" value="0" readonly>
            <i class="las la-minus" onclick="decrementValue('num_of_customer_for_bridal_package')"></i>
            <i class="las la-plus" onclick="incrementValue('num_of_customer_for_bridal_package')"></i>
        </div>
        <div class="errorMsg">
            @error('num_of_customer_for_bridal_package')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="heading_box">
            <p class="title">Home Service Charge </p>
            <p class="sub_title">Will be add with the total cost</p>
            <p class="text"><span class="sub_title"> Price:</span> Tk {{$home_service_charge }}</p>
        </div>

        <div class="autocomplete-container" id="autocomplete-container">
            <div class="input_box">
                <span class="las la-map-marker"></span>
                <input class="input" type="text" name="delivery_area"
                placeholder="Enter Address" autocomplete="off" value="{{old('delivery_area')}}">
            </div>
            <div class="autocomplete-items" id="autocomplete-items"></div>
        </div>
        <div class="errorMsg">
            @error('delivery_area')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <input class="button" type="submit" value="Book Now">
        
	</form>

    <!-- from template -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="JS/Customer/customer_date_picker.js"></script>
    <script src="JS/Customer/customer_select_input.js"></script>

    <script src="JS/Customer/customer_autocomplete_address.js"></script>
    <script src="JS/Customer/customer_cart_input.js"></script>
    <!-- from template -->    


</body>
</html>
