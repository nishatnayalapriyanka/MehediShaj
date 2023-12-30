<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/artist_forget_password" class="form">
        @csrf 
        <div class="heading_box">
            <p class="title">Write a new password</p> 
        </div>

		<div class="input_box">
	        <span class="las la-lock"> </span>
	        <input class="input" type="password"
            name="artist_forget_password_new_password"
            value="{{old('artist_forget_password_new_password')}}"
            placeholder="New Password" >
		</div>
        <div class="errorMsg">
            @error('artist_forget_password_new_password')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

		<input class="button" type="submit" value="Verify">
	</form>

</body>
</html>
