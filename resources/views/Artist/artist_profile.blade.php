<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_sidebar.css">
    <link rel="stylesheet" href="CSS/Artist/artist_profile_update.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    
    <nav>
        <div class="menu">
            <label for="menu" class="las la-bars"></label>
            <img class="logo" src="Project Image/MehediShaj_logo.png">		    
	    </div>
        
	    <div class="profile">		    
            <img src="Artist Profile Picture/{{session('artist_profile_pic')}}">
		    <span>{{session('artist_name')}}</span>
	    </div>			
    </nav>

    <main>
        <input type="checkbox" id="menu">
        <div class="sidebar">

		    <a href="/artist_dashboard" class="option">
			    <div>
				    <span class="las la-home"></span>
           		    <span class="sidebar_text" >Dashboard</span>
			    </div>
            </a>

            <a href="" class="selected_option">
        	    <div >
        		    <i class="las la-user-alt"></i>
           		    <span class="sidebar_text">Profile</span>
        	    </div>			
            </a>

            <a href="/artist_gallery" class="option">
        	    <div >
        		    <i class="las la-image"></i>
           		    <span class="sidebar_text">Gallery</span>
        	    </div>			
            </a>

            <a href="/artist_appointments" class="option">
        	    <div>
        		    <span class="las la-calendar-day"></span>
            	    <span class="sidebar_text">My Appointments</span>
        	    </div>			
            </a>

            <a href="artist_help" class="option">
        	    <div>
        		    <i class="las la-question-circle"></i>
            	    <span class="sidebar_text">Help</span>
        	    </div>			
            </a>

            <a href="/artist_logout" class="option">
        	    <div>
        		    <span class="las la-sign-out-alt"></span>
            	    <span class="sidebar_text">Log Out</span>
        	    </div>			
            </a>
	    </div>

        <div class="main_section">
            <form method="post" action="/artist_profile_update" enctype="multipart/form-data">
                @csrf
                <div class="profile_pic">	               
	                <label for="profile_pic">
	                    <img src="Artist Profile Picture/{{session('artist_profile_pic')}}" id="preview">
	                    <img width="26" height="26" class="preview"
                        src="https://img.icons8.com/ios-filled/26/008000/camera--v1.png">
	                </label>
                     <input id="profile_pic" type="file" name="artist_profile_pic"
                    onchange="previewImage(this)" accept="image/*">
	            </div>        
                <div class="errorMsg">
                    @error('artist_profile_pic')
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
                    <input autocomplete="off" class="input" type="text" id="name" name="artist_name" value="{{session('artist_name')}}">                   
                </div>
                <div class="errorMsg">
                    @error('artist_name')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <div class="inputbox">
                    <a href="/artist_phone_update_phone_number_verify" class="input_title">
                    <span class="las la-pen"></span>
                        Phone
                    </a>                        
                    <p class="input">{{session('artist_phone')}}</p>
                </div>
                <br>

                <div class="inputbox">
                    <a href="/artist_password_update" class="input_title">
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
                        <input autocomplete="off" class="input" type="text" id="address" name="artist_address" value="{{session('artist_address')}}">
                    </div>
                    <div class="autocomplete-items" id="autocomplete-items"></div>
                </div>
                <div class="errorMsg">
                    @error('artist_address')
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
                    <select id="city" name="artist_city"
                    onfocus='this.size=8;' onblur='this.size=0;'
                    onchange='this.size=1; this.blur();'>
                        @php
                        $cities = ["Dhaka", "Chittagong", "Barisal", "Khulna", "Mymensingh", "Rajshahi", "Rangpur", "Sylhet"];
                        @endphp

                        <option value="{{ session('artist_city') }}" selected>
                            {{ session('artist_city') }}
                        </option>

                        @foreach($cities as $city)
                            @if( $city != session('artist_city'))
                                <option value="{{ $city }}" >{{ $city }}</option>
                            @endif
                        @endforeach
                    </select>   
                </div>
                <br>

                <input class="button" type="submit" name="submit" value="Save">
                <br><br><br>
            </form>





            <form method="post" action="/artist_non_bridal_package_update" enctype="multipart/form-data">
                @csrf
                <p class="title_text" >Non-Bridal Package</p>
                <p class="title_subtext" >One handside/foot per person(simple to gorgeous)</p>
                <br>
                <div class="inputbox">
                    <label class="input_title" for="artist_non_bridal_starting_price">
                    <span class="las la-pen"></span>
                        Starting Price(TK)
                    </label>                        
                    <input autocomplete="off" class="input" type="text" id="artist_non_bridal_starting_price" name="artist_non_bridal_starting_price" value="{{session('artist_non_bridal_starting_price')}}">                   
                </div>
                <div class="errorMsg">
                    @error('artist_non_bridal_starting_price')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <div class="inputbox">
                    <label class="input_title" for="artist_non_bridal_max_price">
                    <span class="las la-pen"></span>
                        Maximum Price(TK)
                    </label>                        
                    <input autocomplete="off" class="input" type="text" id="artist_non_bridal_max_price" name="artist_non_bridal_max_price" value="{{session('artist_non_bridal_max_price')}}">                   
                </div>
                <div class="errorMsg">
                    @error('artist_non_bridal_max_price')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <input class="button" type="submit" value="Save">
                <br><br><br>
            </form>

            <form method="post" action="/artist_bridal_package_update" enctype="multipart/form-data">
                @csrf
                <p class="title_text" >Bridal Package</p>
                <p class="title_subtext" >Only hand/hand with foot per person(simple to gorgeous)</p>
                <br>
                <div class="inputbox">
                    <label class="input_title" for="artist_bridal_starting_price">
                    <span class="las la-pen"></span>
                        Starting Price(TK)
                    </label>                        
                    <input autocomplete="off" class="input" type="text" id="artist_bridal_starting_price" name="artist_bridal_starting_price" value="{{session('artist_bridal_starting_price')}}">                   
                </div>
                <div class="errorMsg">
                    @error('artist_bridal_starting_price')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <div class="inputbox">
                    <label class="input_title" for="artist_bridal_max_price">
                    <span class="las la-pen"></span>
                        Maximum Price(TK)
                    </label>                        
                    <input autocomplete="off" class="input" type="text" id="artist_bridal_max_price" name="artist_bridal_max_price" value="{{session('artist_bridal_max_price')}}">                   
                </div>
                <div class="errorMsg">
                    @error('artist_bridal_max_price')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <input class="button" type="submit" value="Save">
                <br><br><br>
            </form>

            <form method="post" action="/artist_home_service_charge_update" enctype="multipart/form-data">
                @csrf
                <p class="title_text" >Home Service Charge</p>
                <p class="title_subtext" >If you provide home service</p>
                <br>
                <div class="inputbox">
                    <label class="input_title" for="artist_home_service_charge">
                    <span class="las la-pen"></span>
                        Price(TK)
                    </label>                        
                    <input autocomplete="off" class="input" type="text" id="artist_home_service_charge" name="artist_home_service_charge" value="{{session('artist_home_service_charge')}}">                   
                </div>
                <div class="errorMsg">
                    @error('artist_home_service_charge')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <input class="button" type="submit" value="Save">
                <br><br><br>
            </form>



            <!-- from template -->
	        <script src="JS/Artist/artist_image_upload.js"> </script>

            <script src="JS/Artist/artist_autocomplete_address.js"></script>
	        <!-- from template -->
        </div>
    </main>

</body>
</html>



