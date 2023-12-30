<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Admin/admin_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/admin_login" class="form">
        @csrf
        <div class="heading_bos">
            <p class="title">Admin Panel</p>
        </div>
        
        <div class="input_box">
	        <span class="las la-lock"> </span>
	        <input class="input" type="password" name="admin_login_password"
            placeholder="Enter Password" value="{{old('admin_login_password')}}">
		</div>
        <div class="errorMsg">
            @error('admin_login_password')
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
	</form>

</body>
</html>
