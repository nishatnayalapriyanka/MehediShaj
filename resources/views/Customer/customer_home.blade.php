<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_sidebar.css">
    <link rel="stylesheet" href="CSS/Customer/customer_home.css">
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
		    @if(Session::has('customer_profile_pic'))
                <img src="Customer Profile Picture/{{session('customer_profile_pic')}}">
            @else
                <img src="https://img.icons8.com/ios-filled/50/9acd32/user-female-circle.png" >
            @endif
		    <span>{{session('customer_name')}}</span>
	    </div>			
    </nav>

    <main>
        <input type="checkbox" id="menu">
        <div class="sidebar">

		    <a href="" class="selected_option">
			    <div>
				    <span class="las la-home"></span>
           		    <span class="sidebar_text" >Home</span>
			    </div>
            </a>

            <a href="/customer_profile" class="option">
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
            <div class="booking">
                @foreach($artists as $artist)
                    <form class="artist" method="post" action="/customer_book_now">
                        @csrf
                        <label for="{{$artist->phone}}">
                            <img class="" src= "Artist Profile Picture/{{$artist->profile_pic}}">
                            <p>
                                {{$artist->name}}
                                <br>
                                @if($artist->appointments_for_feedback->avg('feedback.ratings') != 0)
                                    <i class="fa-solid fa-star"></i>
                                    {{ number_format( $artist->appointments_for_feedback->avg('feedback.ratings') ,1) }}                                    
                                    <!-- {{ number_format($artist->appointments_for_feedback->avg('customer_phone'), 1) }}
                                    @foreach($artist->appointments_for_feedback as $appointment)
                                        {{$appointment->customer_phone}}
                                        @if($appointment->feedback)
                                            rating-{{$appointment->feedback->ratings}}
                                        @endif
                                    @endforeach-->
                                    <span>( {{$artist->appointments_for_feedback->pluck('feedback.ratings')->whereNotNull()->count()}} )</span>
                                @else
                                    <br>
                                @endif
                            </p>
                        
                            <input type="hidden" name="booking_artist_phone" value="{{$artist->phone}}">
                            <input id="{{$artist->phone}}" class="button" type="submit" value="Book Now">
                        </label>
                    </form>
                @endforeach
            </div>
        </div>
    </main>

</body>
</html>



