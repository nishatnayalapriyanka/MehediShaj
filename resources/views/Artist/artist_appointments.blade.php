<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_sidebar.css">
    <link rel="stylesheet" href="CSS/Artist/artist_appointments.css">
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

            <a href="/artist_gallery" class="option">
        	    <div >
        		    <i class="las la-image"></i>
           		    <span class="sidebar_text">Gallery</span>
        	    </div>			
            </a>

            <a href="" class="selected_option">
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
            <input name="appointments_menu" type="radio" id="upcoming_appointments">
            <input name="appointments_menu" type="radio" id="all_appointments">

            <div class="appointments_menu" >
                <label class="appointments_menu_upcoming_appointments title" for="upcoming_appointments">
                Upcoming Appointments
                </label>
                <label class="appointments_menu_all_appointments title" for="all_appointments">
                All Appointments
                </label>
            </div>
            <br>

            <div class="upcoming_appointments">
                @if($upcoming_appointments->isEmpty())
                    <p class="text" style = "margin-left: 65px;">No Appiontments</p>
                    <br><br>
                @else
                    @foreach($upcoming_appointments as $upcoming_appointment)
                        <div class="appointments">
                            <table class="appointments_table" >
                                <tr>
                                    <td class="appointments_header">
                                         <p>Appointment- {{ $upcoming_appointment->appointment->appointment_id }}({{ $upcoming_appointment->appointment->status }})</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="appointments_details">
                                        <p class="text"><span class="sub_title">Customer- </span>
                                            {{ $upcoming_appointment->customer->name }}
                                            <a class="call" href="tel:{{ $upcoming_appointment->customer->phone }}">
                                                ( <i class="fa-solid fa-phone"></i>
                                                {{ $upcoming_appointment->customer->phone }} )
					                        </a>
                                        </p>
                                         <p class="text"><span class="sub_title"><i class="fa-solid fa-calendar-days"></i> </span>
                                            {{ $upcoming_appointment->appointment->date }} 
                                         </p>
                                         <p class="text"><span class="sub_title"><i class="fa-solid fa-clock"></i> </span>
                                            {{ $upcoming_appointment->appointment->time }} 
                                         </p>
                                         <p class="text"><span class="sub_title"><i class="fa-solid fa-location-dot"></i> </span>
                                            {{ $upcoming_appointment->appointment->delivery_area }} 
                                         </p>
                                    </td>
                                    <td class="payment_details">
                                        <p class="text"><span class="sub_title">Payment: </span>
                                            After service completion
                                        </p>
                                        <p class="text"><span class="sub_title">Compensation Status: </span>
                                            {{ $upcoming_appointment->payment->artist_compensation_status }}
                                        </p>
                                    </td>
                                </tr>
                            </table >

                            <table class="package_payment_table" >
                                <tr class="package_payment_row">
                                    <td class="package_payment_headers">
                                         Package
                                    </td>
                                    <td class="package_payment_headers">
                                         Quantity
                                    </td>
                                    <td class="package_payment_headers">
                                         Booking Fee
                                    </td>
                                    <td class="package_payment_headers">
                                         Service Charge
                                    </td>
                                </tr>

                                <tr class="package_payment_row">
                                    <td class="package_payment_data">
                                         <p class="text">
                                            Non-Bridal 
                                         </p>
                                    </td>
                                    <td class="package_payment_data">
                                         <p class="text">
                                            {{ $upcoming_appointment->appointment->num_of_clients_for_non_bridal_package }} 
                                         </p>
                                    </td>
                                    <td class="package_payment_data" rowspan="2" >
                                         <p class="text">
                                            Tk {{ $upcoming_appointment->payment->total_booking_fee }}
                                         </p>
                                    </td>
                                    <td class="package_payment_data" rowspan="2" >
                                        <p class="text">
                                            {{ $upcoming_appointment->payment->total_service_charge }}
                                        </p>
                                    </td>  
                                </tr>

                                <tr class="package_payment_row">
                                    <td class="package_payment_data">
                                         <p class="text">
                                            Bridal 
                                         </p>
                                    </td>
                                    <td class="package_payment_data">
                                         <p class="text">
                                            {{ $upcoming_appointment->appointment->num_of_clients_for_bridal_package }} 
                                         </p>
                                    </td> 
                                </tr>   

                                <tr>
                                    <td class="package_payment_data payment_calculation" colspan="3">
                                         <span class="sub_title">Total Bill: </span>
                                    </td>
                               
                                    <td class="package_payment_data">
                                         <p class="text">
                                            {{ $upcoming_appointment->payment->total_service_charge }}   
                                         </p>
                                    </td>
                                </tr>
                            </table >
                        
                            <form method="post" action="/artist_cancel_appointment" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                @csrf
                                <input type="hidden" name="cancel_appointment_id" value="{{$upcoming_appointment->appointment->appointment_id}}">
                                <input class="button" type="submit" value="Cancel Appointment">
                            </form> 
                        </div>
                        <br><br>
                    @endforeach            
                @endif
            </div>

            <div class="all_appointments">
                @if($appointments->isEmpty())
                    <p class="text" style = "margin-left: 65px;">No Appiontments</p>
                    <br><br>
                @else
                    @foreach($appointments as $appointment)
                        <div class="appointments">
                            <table class="appointments_table" >
                                <tr>
                                    <td class="appointments_header">
                                         <p>Appointment- {{ $appointment->appointment->appointment_id }}({{ $appointment->appointment->status }})</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="appointments_details">
                                        <p class="text"><span class="sub_title">Customer- </span>
                                            {{ $appointment->customer->name }}
                                            <a class="call" href="tel:{{ $appointment->customer->phone }}">
                                                ( <i class="fa-solid fa-phone"></i>
                                                {{ $appointment->customer->phone }} )
					                        </a>
                                        </p>
                                         <p class="text"><span class="sub_title"><i class="fa-solid fa-calendar-days"></i> </span>
                                            {{ $appointment->appointment->date }} 
                                         </p>
                                         <p class="text"><span class="sub_title"><i class="fa-solid fa-clock"></i> </span>
                                            {{ $appointment->appointment->time }} 
                                         </p>
                                         <p class="text"><span class="sub_title"><i class="fa-solid fa-location-dot"></i> </span>
                                            {{ $appointment->appointment->delivery_area }} 
                                         </p>
                                    </td>
                                    <td class="payment_details">
                                        <p class="text"><span class="sub_title">Payment: </span>
                                            After service completion
                                        </p>
                                        <p class="text"><span class="sub_title">Compensation Status: </span>
                                            {{ $appointment->payment->artist_compensation_status }}
                                        </p>
                                    </td>
                                </tr>
                            </table >

                            <table class="package_payment_table" >
                                <tr class="package_payment_row">
                                    <td class="package_payment_headers">
                                         Package
                                    </td>
                                    <td class="package_payment_headers">
                                         Quantity
                                    </td>
                                    <td class="package_payment_headers">
                                         Booking Fee
                                    </td>
                                    <td class="package_payment_headers">
                                         Service Charge
                                    </td>
                                </tr>

                                <tr class="package_payment_row">
                                    <td class="package_payment_data">
                                         <p class="text">
                                            Non-Bridal 
                                         </p>
                                    </td>
                                    <td class="package_payment_data">
                                         <p class="text">
                                            {{ $appointment->appointment->num_of_clients_for_non_bridal_package }} 
                                         </p>
                                    </td>
                                    <td class="package_payment_data" rowspan="2" >
                                         <p class="text">
                                            Tk {{ $appointment->payment->total_booking_fee }}
                                         </p>
                                    </td>
                                    <td class="package_payment_data" rowspan="2" >
                                         <p class="text">
                                            @if(strpos($appointment->payment->total_service_charge, 'Tk') !== false)
                                                {{ $appointment->payment->total_service_charge }} 
                                            @else
                                                Tk {{ $appointment->payment->total_service_charge }}
                                            @endif  
                                         </p>
                                    </td>  
                                </tr>

                                <tr class="package_payment_row">
                                    <td class="package_payment_data">
                                         <p class="text">
                                            Bridal 
                                         </p>
                                    </td>
                                    <td class="package_payment_data">
                                         <p class="text">
                                            {{ $appointment->appointment->num_of_clients_for_bridal_package }} 
                                         </p>
                                    </td> 
                                </tr>   

                                <tr>
                                    <td class="package_payment_data payment_calculation" colspan="3">
                                         <span class="sub_title">Total Bill: </span>
                                    </td>
                               
                                    <td class="package_payment_data">
                                         <p class="text">
                                            @if(strpos($appointment->payment->total_service_charge, 'Tk') !== false)
                                                {{ $appointment->payment->total_service_charge }} 
                                            @else
                                                Tk {{ $appointment->payment->total_service_charge }}
                                            @endif     
                                         </p>
                                    </td>
                                </tr>
                            </table >
                        </div>
                        <br><br>
                    @endforeach            
                @endif
            </div>
        </div>
    </main>

</body>
</html>



