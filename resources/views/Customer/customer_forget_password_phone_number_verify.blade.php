<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_form.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/customer_forget_password_phone_number_verify" class="form">
        @csrf 
        <div class="heading_box">
            <p class="title">What's your phone number?</p>
            <p class="sub_title">We need this to verify and secure your account</p>
        </div>

		<div class="input_box">
	        <span class="las la-phone"> </span>
	        <input class="input" type="text" name="customer_forget_password_phone"
            placeholder="Enter Phone Number" value="{{old('customer_forget_password_phone')}}">
		</div>

        <div class="errorMsg">
            @error('customer_forget_password_phone')
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

		<input class="button" type="submit" value="Verify">
	</form>

</body>
</html>
