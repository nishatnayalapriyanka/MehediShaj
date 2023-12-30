<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/artist_complete_session_with_payment" class="form">
        @csrf 
        <div class="heading_box">
            <p class="title">Complete Session with Payment</p>
            <p class="sub_title">Enter the amount you have taken from customer</p>
        </div>

		<div class="input_box">
	        <span class="las la-money-bill"> </span>  
	        <input class="input" type="text"
            name="artist_complete_session_payment"
            value="{{old('artist_complete_session_payment')}}"
            placeholder="Enter Payment Amount" >
		</div>
        <div class="errorMsg">
            @error('artist_complete_session_payment')
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

		<input class="button" type="submit" value="Complete Session">
	</form>

</body>
</html>
