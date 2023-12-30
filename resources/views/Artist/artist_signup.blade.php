<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/artist_signup" enctype="multipart/form-data" class="form big_form">
        @csrf 

        <div class="profile_pic">
	        <input id="profile_pic" type="file" name="artist_signup_profile_pic"
            onchange="previewImage(this)" accept="image/*">
	        <label for="profile_pic">
	            <img id="preview"
                src="https://img.icons8.com/ios-glyphs/100/9acd32/user-female--v1.png" >
	            <img width="26" height="26" class="preview"
                src="https://img.icons8.com/ios-filled/26/008000/camera--v1.png">
	        </label>
	    </div>        
        <div class="errorMsg">    
            @error('artist_signup_profile_pic')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

		<div class="input_box">
	        <span class="las la-user"> </span>
	        <input class="input" type="text" name="artist_signup_name"
            placeholder="Enter Name" value="{{old('artist_signup_name')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_name')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-phone"> </span>
	        <input class="input" type="text"
            name="artist_signup_verified_phone" placeholder="Enter phone"
            value="{{session('artist_signup_verified_phone')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_verified_phone')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-lock"> </span>
	        <input class="input" type="password" name="artist_signup_password"
            placeholder="Enter Password" value="{{old('artist_signup_password')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_password')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="autocomplete-container" id="autocomplete-container">
            <div class="input_box">
                <span class="las la-map-marker"></span>
                <input class="input" type="text" name="artist_signup_address"
                placeholder="Enter Address" autocomplete="off" value="{{old('artist_signup_address')}}">
            </div>
            <div class="autocomplete-items" id="autocomplete-items"></div>
        </div>
        <div class="errorMsg">
            @error('artist_signup_address')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
            <span class="las la-city"></span>           
            <select id="city"
            name="artist_signup_city" onfocus='this.size=8;' onblur='this.size=0;'
            onchange='this.size=1; this.blur();'>
                <option value="">Select City</option>
                <option value="Dhaka">Dhaka</option>
                <option value="Chittagong">Chittagong</option>
                <option value="Barisal">Barisal</option>
                <option value="Khulna">Khulna</option>
                <option value="Mymensingh">Mymensingh</option>
                <option value="Rajshahi">Rajshahi</option>
                <option value="Rangpur">Sylhet</option>
            </select>           
        </div>
        <div class="errorMsg">
            @error('artist_signup_city')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>







        <div class="heading_box">
            <p class="title">Non-Bridal Package </p>
            <p class="sub_title">One handside/foot per person(simple to gorgeous)</p>
        </div>

        <div class="input_box">
	        <span class="las la-money-bill"> </span>
	        <input class="input" type="text" name="artist_signup_non_bridal_starting_price"
            placeholder="Starting Price" value="{{old('artist_signup_non_bridal_starting_price')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_non_bridal_starting_price')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-money-bill"> </span>
	        <input class="input" type="text" name="artist_signup_non_bridal_max_price"
            placeholder="Maximum Price" value="{{old('artist_signup_non_bridal_max_price')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_non_bridal_max_price')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="heading_box">
            <p class="title">Bridal Package </p>
            <p class="sub_title">Only hand/hand with foot per person(simple to gorgeous)</p>
        </div>

        <div class="input_box">
	        <span class="las la-money-bill"> </span>
	        <input class="input" type="text" name="artist_signup_bridal_starting_price"
            placeholder="Starting Price" value="{{old('artist_signup_bridal_starting_price')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_bridal_starting_price')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-money-bill"> </span>
	        <input class="input" type="text" name="artist_signup_bridal_max_price"
            placeholder="Maximum Price" value="{{old('artist_signup_bridal_max_price')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_bridal_max_price')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="heading_box">
            <p class="title">Home Service Charge </p>
            <p class="sub_title">AS you will provide home service</p>
        </div>

        <div class="input_box">
	        <span class="las la-money-bill"> </span>
	        <input class="input" type="text" name="artist_signup_home_service_charge"
            placeholder="Enter Price" value="{{old('artist_signup_home_service_charge')}}">
		</div>
        <div class="errorMsg">
            @error('artist_signup_home_service_charge')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>






        <div class="input_box">
            <p class="text">
	            <input type="checkbox" name="artist_signup_termsNconditions">
                I agree to the
                <a href="/artist_signup_termsNconditions" target="_blank">terms & conditions</a>
            </p>
        </div>
        <div class="errorMsg">
            @error('artist_signup_termsNconditions')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>        

		<input class="button" type="submit" name="signup" value="Sign Up">

	</form>

	<!-- from template -->
	<script src="JS/Artist/artist_image_upload.js"> </script>

    <script src="JS/Artist/artist_autocomplete_address.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="JS/Artist/artist_select_input.js"></script>
	<!-- from template -->


</body>
</html>
