<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_sidebar.css">
    <link rel="stylesheet" href="CSS/Artist/artist_help.css">
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

            <a href="/artist_profile" class="option">
        	    <div >
        		    <i class="las la-user-alt"></i>
           		    <span class="sidebar_text">Profile</span>
        	    </div>			
            </a>

            <a href="artist_gallery" class="option">
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

            <a href="" class="selected_option">
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
            <br>
            <div class="container">
                <a class="call" href="tel:+8801641496294">
			        <p class="title"><i class="fa-solid fa-phone"></i> Let's Call(+8801641496294)<i class="fa-solid fa-angle-right"></i></p>		        
                    <p class="call_msg">You can call our admin for any assistance or support!</p>
                </a>
            </div>
            <br><br>
            <div class="container">
                <input id="message_box" type="checkbox" >
                <p class="title"><i class="fa-solid fa-message"></i> Let's Message
                    <label for="message_box"><i class="fa-solid fa-angle-down"></i> </label>
                </p>
                <p class="call_msg">You can message our admin for any assistance or support!</p>

                <form class="message_box" method="post" action="/artist_help">
                    @csrf
                    <br>
                    <textarea class="help_msg" name="help_msg" value="{{old('help_msg')}}"
                    placeholder="Type here......"></textarea>
                    <div class="errorMsg">
                        @error('help_msg')
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{$message}}
                        @enderror
                    </div>
                    <input class="button" type="image" src="https://img.icons8.com/fluency-systems-filled/50/FFFFFF/sent.png" >
	            </form>
            </div>
        </div>
    </main>

</body>
</html>



