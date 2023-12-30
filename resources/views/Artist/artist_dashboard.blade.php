<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_sidebar.css">
    <link rel="stylesheet" href="CSS/Artist/artist_dashboard.css">
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

		    <a href="" class="selected_option">
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
            <div class="header_contatiner">
                <div class="total_completed_appointment">
                    <p class="total_completed_appointment_value"> {{$completed_appointments->count()}}</p>
                    <p class="total_completed_appointment_title"> Total Completed <br>Appointments </p>
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="total_income">
                    <p class="total_income_value">Tk {{$completed_appointments->sum('payment.total_service_charge')}}</p>
                    <p class="total_income_title">Total Income</p>
                    <i class="fa-solid fa-money-bill"></i>
                </div>
            </div>
            <br><br>

            <p class="heading"><i class="lar la-chart-bar"></i>Monthly Income {{date('Y')}}</p>
            <div class="bar_container">      
                <canvas id="current_year_monthly_income_bar"></canvas>
            </div>
            <br><br>

            <p class="heading">Today's Appointment</p>
            <br>
            @if($today_appointment == null)
                <p class="text" style = "margin-left: 65px;">No Appiontment</p>
            @else
                <div class="appointments">
                    <table class="appointments_table" >
                        <tr>
                            <td class="appointments_header">
                                    <p>Appointment- {{ $today_appointment->appointment->appointment_id }}({{ $today_appointment->appointment->status }})</p>
                            </td>
                        </tr>

                        <tr>
                            <td class="appointments_details">
                                <p class="text"><span class="sub_title">Customer- </span>
                                    {{ $today_appointment->customer->name }}
                                    <a class="call" href="tel:{{ $today_appointment->customer->phone }}">
                                        ( <i class="fa-solid fa-phone"></i>
                                        {{ $today_appointment->customer->phone }} )
					                </a>
                                </p>
                                    <p class="text"><span class="sub_title"><i class="fa-solid fa-calendar-days"></i> </span>
                                    {{ $today_appointment->appointment->date }} 
                                    </p>
                                    <p class="text"><span class="sub_title"><i class="fa-solid fa-clock"></i> </span>
                                    {{ $today_appointment->appointment->time }} 
                                    </p>
                                    <p class="text"><span class="sub_title"><i class="fa-solid fa-location-dot"></i> </span>
                                    {{ $today_appointment->appointment->delivery_area }} 
                                    </p>
                            </td>
                            <td class="payment_details">
                                <p class="text"><span class="sub_title">Payment: </span>
                                    After service completion
                                </p>
                                <p class="text"><span class="sub_title">Compensation Status: </span>
                                    {{ $today_appointment->payment->artist_compensation_status }}
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
                                    {{ $today_appointment->appointment->num_of_clients_for_non_bridal_package }} 
                                    </p>
                            </td>
                            <td class="package_payment_data" rowspan="2" >
                                    <p class="text">
                                    Tk {{ $today_appointment->payment->total_booking_fee }}
                                    </p>
                            </td>
                            <td class="package_payment_data" rowspan="2" >
                                    <p class="text">
                                    {{ $today_appointment->payment->total_service_charge }}
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
                                    {{ $today_appointment->appointment->num_of_clients_for_bridal_package }} 
                                    </p>
                            </td> 
                        </tr>   

                        <tr>
                            <td class="package_payment_data payment_calculation" colspan="3">
                                    <span class="sub_title">Total Bill: </span>
                            </td>
                               
                            <td class="package_payment_data">
                                    <p class="text">
                                    {{ $today_appointment->payment->total_service_charge }}   
                                    </p>
                            </td>
                        </tr>
                    </table >
                        
                    <form method="post" action="/artist_complete_session">
                        @csrf
                        <input type="hidden" name="complete_session_customer_phone" value="{{$today_appointment->customer->phone}}">
                        <input type="hidden" name="complete_session_appointment_id" value="{{$today_appointment->appointment->appointment_id}}">
                        <input class="button" type="submit" value="Complete Session">
                    </form> 
                </div>           
            @endif
            <br><br>

            <p class="heading">
                @if(!$completed_appointments->isEmpty())
                    <a href="/artist_completed_appointments_download_excel" class="download_excel">
                        <i class="fa-solid fa-download"></i>Completed Appointments
                    </a>
                @else
                    Completed Appointments
                @endif
            </p>
            @if($completed_appointments->isEmpty())
                <p class="text" style = "margin-left: 65px;">No Appiontments</p>
            @else
            <br>
            <table id="completed_appoinments" >
                <tr class= "completed_appoinments_headers">
                    <td class= "completed_appoinments_data">
                        Appointment ID
                    </td>
                    <td class= "completed_appoinments_data">
                        Date
                    </td>
                    <td class= "completed_appoinments_data">
                       Time
                    </td>
                    <td class= "completed_appoinments_data">
                        Non-Bridal Package
                    </td>
                    <td class= "completed_appoinments_data">
                        Bridal Package
                    </td>
                    <td class= "completed_appoinments_data">
                        Customer
                    </td>
                    <td class= "completed_appoinments_data">
                        Location
                    </td>
                    <td class= "completed_appoinments_data">
                        Service Charge
                    </td class= "completed_appoinments_data">
                </tr>
                @foreach($completed_appointments as $completed_appointment)
                    <tr class= "completed_appoinments_rows">
                        <td class= "completed_appoinments_data">
                            {{$completed_appointment->appointment_id}}
                        </td>
                        <td class= "completed_appoinments_data">
                            {{$completed_appointment->appointment->date}}
                        </td>
                        <td class= "completed_appoinments_data">
                            {{$completed_appointment->appointment->time}}
                        </td>
                        <td class= "completed_appoinments_data">
                            {{$completed_appointment->appointment->num_of_clients_for_non_bridal_package}}
                        </td>
                        <td class= "completed_appoinments_data">
                            {{$completed_appointment->appointment->num_of_clients_for_bridal_package}}
                        </td>
                        <td class= "completed_appoinments_data">
                            {{$completed_appointment->customer->name}}
                        </td>
                        <td class= "completed_appoinments_data">
                            {{$completed_appointment->appointment->delivery_area}}
                        </td>
                        <td class= "completed_appoinments_data">
                            Tk {{$completed_appointment->payment->total_service_charge}}
                        </td>
                    </tr>
                @endforeach
                <tr >
                    <td class= "total" colspan="7">
                        Total:
                    </td>
                    <td class= "total_service_charge">
                        Tk {{$completed_appointments->sum('payment.total_service_charge')}}
                    </td>

                </tr>
            </table>
            @endif
            <br<br><br><br><br><br><br><br>
                        

        </div>
    </main>
    
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var $current_year_monthly_income = @json($current_year_monthly_income);

        // Pass data to external JS file
        window.onload = function () {
            drawBarChart($current_year_monthly_income);
        };

    </script>
    <script src="JS/Artist/artist_bar.js"></script>

</body>
</html>



