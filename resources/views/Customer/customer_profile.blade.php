<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_sidebar.css">
    <link rel="stylesheet" href="CSS/Customer/customer_profile_update.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    @php
        if (Session::has('customer_profile_pic')) {
            $customer_profile_pic_src = "Customer Profile Picture/" . session('customer_profile_pic');
        } else {
            $customer_profile_pic_src = "https://img.icons8.com/ios-filled/150/9acd32/user-female-circle.png";
        }
    @endphp
    
    <nav>
        <div class="menu">
            <label for="menu" class="las la-bars"></label>
            <img class="logo" src="Project Image/MehediShaj_logo.png">		    
	    </div>
        
	    <div class="profile">		    
            <img src="{{ $customer_profile_pic_src }}" >
		    <span>{{session('customer_name')}}</span>
	    </div>			
    </nav>

    <main>
        <input type="checkbox" id="menu">
        <div class="sidebar">

		    <a href="/customer_home" class="option">
			    <div>
				    <span class="las la-home"></span>
           		    <span class="sidebar_text" >Home</span>
			    </div>
            </a>

            <a href="" class="selected_option">
        	    <div >
        		    <i class="las la-user-alt"></i>
           		    <span class="sidebar_text">Profile</span>
        	    </div>			
            </a>

            <a href="/customer_appointments" class="option">
        	    <div>
        		    <span class="las la-calendar-day"></span>
            	    <span class="sidebar_text">My Appointment</span>
        	    </div>			
            </a>

            <a href="/customer_help" class="option">
        	    <div>
        		    <i class="las la-question-circle"></i>
            	    <span class="sidebar_text">Help</span>
        	    </div>			
            </a>

            <a href="/customer_logout" class="option">
        	    <div>
        		    <span class="las la-sign-out-alt"></span>
            	    <span class="sidebar_text">Log Out</span>
        	    </div>			
            </a>
	    </div>

        <div class="main_section">
            <form method="post" action="/customer_profile_update" enctype="multipart/form-data">
                @csrf
                <div class="profile_pic">	               
	                <label for="profile_pic">
	                    <img src="{{ $customer_profile_pic_src }}" id="preview">
	                    <img width="26" height="26" class="preview"
                        src="https://img.icons8.com/ios-filled/26/008000/camera--v1.png">
	                </label>
                     <input id="profile_pic" type="file" name="customer_profile_pic"
                    onchange="previewImage(this)" accept="image/*">
	            </div>        
                <div class="errorMsg">
                    @error('customer_profile_pic')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <div class="inputbox">
                    <label class="input_title" for="name">
                    <span class="las la-pen"></span>
                        Name
                    </label>                        
                    <input autocomplete="off" class="input" type="text" id="name" name="customer_name" value="{{session('customer_name')}}">                   
                </div>
                <div class="errorMsg">
                    @error('customer_name')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <div class="inputbox">
                    <a href="/customer_phone_update_phone_number_verify" class="input_title">
                    <span class="las la-pen"></span>
                        Phone
                    </a>                        
                    <p class="input">{{session('customer_phone')}}</p>
                </div>
                <br>

                <div class="inputbox">
                    <a href="/customer_password_update" class="input_title">
                    <span class="las la-pen"></span>
                        Password
                    </a>                       
                </div>
                <br>
                <div class="autocomplete-container" id="autocomplete-container">
                    <div class="inputbox">
                        <label class="input_title" for="address">
                        <span class="las la-pen"></span>
                            Address
                        </label>                        
                        <input autocomplete="off" class="input" type="text" id="address" name="customer_address" value="{{session('customer_address')}}">
                    </div>
                    <div class="autocomplete-items" id="autocomplete-items"></div>
                </div>
                <div class="errorMsg">
                    @error('customer_address')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>
                <div id= "select" class="inputbox">
                    <label class="input_title" for="city">
                    <span class="las la-pen"></span>
                        City
                    </label>
                    <select id="city" name="customer_city"
                    onfocus='this.size=8;' onblur='this.size=0;'
                    onchange='this.size=1; this.blur();'>
                        @php
                        $cities = ["Dhaka", "Chittagong", "Barisal", "Khulna", "Mymensingh", "Rajshahi", "Rangpur", "Sylhet"];
                        @endphp

                        <option value="{{ session('customer_city') }}" selected>
                            {{ session('customer_city') }}
                        </option>

                        @foreach($cities as $city)
                            @if( $city != session('customer_city'))
                                <option value="{{ $city }}" >{{ $city }}</option>
                            @endif
                        @endforeach
                    </select>   
                </div>
                <br>

                <input class="button" type="submit" name="submit" value="Save">
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </form>
            <!-- from template -->
	        <script src="JS/Customer/customer_image_upload.js"> </script>

            <script src="JS/Customer/customer_autocomplete_address.js"></script>
	        <!-- from template -->
        </div>
    </main>

</body>
</html>



