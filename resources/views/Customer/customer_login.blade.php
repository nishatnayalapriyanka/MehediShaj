<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/customer_login" class="form">
        @csrf
        <div class="heading_box">
            <p class="title">Log In</p>
        </div>

        <div class="input_box">
	        <span class="las la-phone"> </span>
	        <input class="input" type="text" name="customer_login_phone"
            placeholder="Enter Phone Number" value="{{old('customer_login_phone')}}">
		</div>
        <div class="errorMsg">        
            @error('customer_login_phone')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>
        
        <div class="input_box">
	        <span class="las la-lock"> </span>
	        <input class="input" type="password" name="customer_login_password"
            placeholder="Enter Password" value="{{old('customer_login_password')}}">
		</div>
        <div class="errorMsg">
            @error('customer_login_password')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>
        <div class="errorMsg" >
            @if ($errors->has('error'))
                 <i class="fa-solid fa-circle-exclamation"></i>
                 {{ $errors->first('error') }}
            @endif
        </div>
		<input class="button" type="submit" name="login" value="Log In">

		<p class="text" >Forget Password ??  <a href="/customer_forget_password_phone_number_verify">Click Here</a></p>
        <p class="text" >Don't Have An Account ??  <a href="/customer_signup_phone_number_verify">Sign Up</a></p>
	</form>

</body>
</html>
