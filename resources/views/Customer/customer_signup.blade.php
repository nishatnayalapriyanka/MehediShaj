<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/customer_signup" enctype="multipart/form-data" class="form">
        @csrf 

        <div class="profile_pic">
	        <input id="profile_pic" type="file" name="customer_signup_profile_pic"
            onchange="previewImage(this)" accept="image/*">
	        <label for="profile_pic">
	            <img id="preview"
                src="https://img.icons8.com/ios-glyphs/100/9acd32/user-female--v1.png" >
	            <img width="26" height="26" class="preview"
                src="https://img.icons8.com/ios-filled/26/008000/camera--v1.png">
	        </label>
	    </div>        
        <div class="errorMsg">    
            @error('customer_signup_profile_pic')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

		<div class="input_box">
	        <span class="las la-user"> </span>
	        <input class="input" type="text" name="customer_signup_name"
            placeholder="Enter Name" value="{{old('customer_signup_name')}}">
		</div>
        <div class="errorMsg">
            @error('customer_signup_name')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-phone"> </span>
	        <input class="input" type="text"
            name="customer_signup_verified_phone" placeholder="Enter phone"
            value="{{session('customer_signup_verified_phone')}}">
		</div>
        <div class="errorMsg">
            @error('customer_signup_verified_phone')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-lock"> </span>
	        <input class="input" type="password" name="customer_signup_password"
            placeholder="Enter Password" value="{{old('customer_signup_password')}}">
		</div>
        <div class="errorMsg">
            @error('customer_signup_password')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="autocomplete-container" id="autocomplete-container">
            <div class="input_box">
                <span class="las la-map-marker"></span>
                <input class="input" type="text" name="customer_signup_address"
                placeholder="Enter Address" autocomplete="off" value="{{old('customer_signup_address')}}">
            </div>
            <div class="autocomplete-items" id="autocomplete-items"></div>
        </div>
        <div class="errorMsg">
            @error('customer_signup_address')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
            <span class="las la-city"></span>           
            <select class="input" name="customer_signup_city" >
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
            @error('customer_signup_city')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>
        <div class="input_box">
            <p class="text">
	            <input type="checkbox" name="customer_signup_termsNconditions">
                I agree to the
                <a href="/customer_signup_termsNconditions" target="_blank">terms & conditions</a>
            </p>
        </div>
        <div class="errorMsg">
            @error('customer_signup_termsNconditions')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>        

		<input class="button" type="submit" name="signup" value="Sign Up">

	</form>

	<!-- from template -->
	<script src="JS/Customer/customer_image_upload.js"> </script>

    <script src="JS/Customer/customer_autocomplete_address.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="JS/Customer/customer_select_input.js"></script>
	<!-- from template -->

</body>
</html>
