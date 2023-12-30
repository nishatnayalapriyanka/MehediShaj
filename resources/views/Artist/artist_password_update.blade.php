<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/artist_password_update" class="form">
        @csrf 
        <div class="heading_box">
            <p class="title">Change Password</p>    
        </div>

		<div class="input_box">
	        <span class="las la-lock"> </span>
	        <input class="input" type="password"
            name="artist_update_password_current"
            value="{{old('artist_update_password_current')}}"
            placeholder="Current Password" >
		</div>
        <div class="errorMsg">
            @error('artist_update_password_current')
                <i class="fa-solid fa-circle-exclamation"></i>
                {{$message}}
            @enderror
        </div>

        <div class="input_box">
	        <span class="las la-lock"> </span>
	        <input class="input" type="password"
            name="artist_update_password_new"
            value="{{old('artist_update_password_new')}}"
            placeholder="New Password" >
		</div>
        <div class="errorMsg">
            @error('artist_update_password_new')
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

		<input class="button" type="submit" value="Save">
	</form>

</body>
</html>
