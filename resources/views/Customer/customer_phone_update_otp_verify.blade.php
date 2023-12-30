<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/customer_phone_update_otp_verify" class="form">
        @csrf 
        <div class="heading_box">
            <p class="title">Verify your phone number</p>
            <p class="sub_title">Enter 4-digit code sent to your phone {{session('customer_phone_update_phone')}}</p>
        </div>

		<div class="input_box">
	        <span class="las la-key"> </span>
	        <input class="input" type="text" name="customer_phone_update_otp"
            placeholder="Enter OTP" value="{{old('customer_phone_update_otp')}}">
		</div>
        <div class="errorMsg">           
            @error('customer_phone_update_otp')
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
