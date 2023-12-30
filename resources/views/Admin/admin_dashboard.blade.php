<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Admin/admin_sidebar.css">
    <link rel="stylesheet" href="CSS/Admin/admin_dashboard.css">
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
		    <img src="https://img.icons8.com/bubbles/30/system-administrator-female.png" >
		    <span>Admin</span>
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

            <a href="/admin_logout" class="option">
        	    <div>
        		    <span class="las la-sign-out-alt"></span>
            	    <span class="sidebar_text">Log Out</span>
        	    </div>			
            </a>
	    </div>

        <div class="main_section">
            <br>
            <form method="post" action="/admin_search_appointments" class="search_box">
                @csrf
	            <input class="input" type="text" name="admin_appointment_id"
                placeholder="Search Appointment by ID" value="{{old('admin_appointment_id')}}">
                <input type="image" src="https://img.icons8.com/ios-filled/30/008000/search.png" class="button">

                <div class="errorMsg">
                    @error('admin_appointment_id')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div> 
	        </form>
            <br><br>

            <div class="header_contatiner">
                <div class="total_completed_appointment">
                    <p class="total_completed_appointment_value"> {{$completed_appointments->count()}}</p>
                    <p class="total_completed_appointment_title"> Total Completed <br>Appointments </p>
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="total_income">
                    <p class="total_income_value">Tk {{$completed_appointments->sum('payment.total_booking_fee')}}</p>
                    <p class="total_income_title">Total Income</p>
                    <i class="fa-solid fa-money-bill"></i>
                </div>
            </div>
            <br><br>

            <p class="title"><i class="lar la-chart-bar"></i>Monthly Income {{date('Y')}}</p>
            <div class="bar_container">      
                <canvas id="current_year_monthly_income_bar"></canvas>
            </div>
            <br><br>

            <p class="title">
                @if(!$confirmed_appointments->isEmpty())
                    <a href="" class="download_excel">
                        <i class="fa-solid fa-download"></i>Confirmed Appointments
                    </a>
                @else
                    Confirmed Appointments
                @endif
            </p>
            @if($confirmed_appointments->isEmpty())
                <p class="text" style = "margin-left: 65px;">No Appiontments</p>
            @else
                <br>
                <table class="appointments" >
                    <tr class= "appointments_headers">
                        <td class= "appoinments_data">
                            Appointment ID
                        </td>
                        <td class= "appoinments_data">
                            Date
                        </td>
                        <td class= "appoinments_data">
                            Customer
                        </td>
                        <td class= "appoinments_data">
                            Artist
                        </td>
                        <td class= "appoinments_data">
                            Payment Status
                        </td>
                        <td class= "appoinments_data">
                            Customer Refund Status
                        </td>
                        <td class= "appoinments_data">
                            Artist Compensation Status
                        </td>
                        <td class= "appoinments_data">
                            Service Charge
                        </td>
                        <td class= "appoinments_data">
                            Booking Fee
                        </td>
                    </tr>
                    @foreach($confirmed_appointments as $confirmed_appointment)
                        <tr class= "appoinments_rows">
                            <td class= "appoinments_data">
                                <form method="post" action="/admin_search_appointments_by_click" class="hidden_form">
                                    @csrf
	                                <input type="hidden" name="admin_appointment_id"
                                    value="{{$confirmed_appointment->appointment_id}}">
                                    <input type="submit" id ="{{$confirmed_appointment->appointment_id}}">
                                    
	                            </form>
                                <label for="{{$confirmed_appointment->appointment_id}}">
                                    {{$confirmed_appointment->appointment_id}}
                                </label>
                            </td>
                            <td class= "appoinments_data">
                                {{$confirmed_appointment->date}}
                            </td>
                            <td class= "appoinments_data">
                                {{$confirmed_appointment->customer->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$confirmed_appointment->artist->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$confirmed_appointment->payment->status}}
                            </td>
                            <td class= "appoinments_data">
                                {{$confirmed_appointment->payment->refund_status}}
                            </td>
                            <td class= "appoinments_data">
                               {{$confirmed_appointment->payment->artist_compensation_status}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$confirmed_appointment->payment->total_service_charge}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$confirmed_appointment->payment->total_booking_fee}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            <br><br>

            <p class="title">
                @if(!$unconfirmed_appointments->isEmpty())
                    <a href="" class="download_excel">
                        <i class="fa-solid fa-download"></i>Unconfirmed Appointments
                    </a>
                @else
                    Unconfirmed Appointments
                @endif
            </p>
            @if($unconfirmed_appointments->isEmpty())
                <p class="text" style = "margin-left: 65px;">No Appiontments</p>
            @else
                <br>
                <table class="appointments" >
                    <tr class= "appointments_headers">
                        <td class= "appoinments_data">
                            Appointment ID
                        </td>
                        <td class= "appoinments_data">
                            Date
                        </td>
                        <td class= "appoinments_data">
                            Customer
                        </td>
                        <td class= "appoinments_data">
                            Artist
                        </td>
                        <td class= "appoinments_data">
                            Payment Status
                        </td>
                        <td class= "appoinments_data">
                            Customer Refund Status
                        </td>
                        <td class= "appoinments_data">
                            Artist Compensation Status
                        </td>
                        <td class= "appoinments_data">
                            Service Charge
                        </td>
                        <td class= "appoinments_data">
                            Booking Fee
                        </td>
                    </tr>
                    @foreach($unconfirmed_appointments as $unconfirmed_appointment)
                        <tr class= "appoinments_rows">
                            <td class= "appoinments_data">
                                <form method="post" action="/admin_search_appointments_by_click" class="hidden_form">
                                    @csrf
	                                <input type="hidden" name="admin_appointment_id"
                                    value="{{$unconfirmed_appointment->appointment_id}}">
                                    <input type="submit" id ="{{$unconfirmed_appointment->appointment_id}}">
                                    
	                            </form>
                                <label for="{{$unconfirmed_appointment->appointment_id}}">
                                    {{$unconfirmed_appointment->appointment_id}}
                                </label>   
                            </td>
                            <td class= "appoinments_data">
                                {{$unconfirmed_appointment->date}}
                            </td>
                            <td class= "appoinments_data">
                                {{$unconfirmed_appointment->customer->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$unconfirmed_appointment->artist->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$unconfirmed_appointment->payment->status}}
                            </td>
                            <td class= "appoinments_data">
                                {{$unconfirmed_appointment->payment->refund_status}}
                            </td>
                            <td class= "appoinments_data">
                               {{$unconfirmed_appointment->payment->artist_compensation_status}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$unconfirmed_appointment->payment->total_service_charge}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$unconfirmed_appointment->payment->total_booking_fee}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            <br><br>

            <p class="title">
                @if(!$cancelled_appointments->isEmpty())
                    <a href="" class="download_excel">
                        <i class="fa-solid fa-download"></i>Cancelled Appointments
                    </a>
                @else
                    Cancelled Appointments
                @endif
            </p>
            @if($cancelled_appointments->isEmpty())
                <p class="text" style = "margin-left: 65px;">No Appiontments</p>
            @else
                <br>
                <table class="appointments" >
                    <tr class= "appointments_headers">
                        <td class= "appoinments_data">
                            Appointment ID
                        </td>
                        <td class= "appoinments_data">
                            Date
                        </td>
                        <td class= "appoinments_data">
                            Customer
                        </td>
                        <td class= "appoinments_data">
                            Artist
                        </td>
                        <td class= "appoinments_data">
                            Status
                        </td>
                        <td class= "appoinments_data">
                            Payment Status
                        </td>
                        <td class= "appoinments_data">
                            Customer Refund Status
                        </td>
                        <td class= "appoinments_data">
                            Artist Compensation Status
                        </td>
                        <td class= "appoinments_data">
                            Service Charge
                        </td>
                        <td class= "appoinments_data">
                            Booking Fee
                        </td>
                    </tr>
                    @foreach($cancelled_appointments as $cancelled_appointment)
                        <tr class= "appoinments_rows">
                            <td class= "appoinments_data">
                                <form method="post" action="/admin_search_appointments_by_click" class="hidden_form">
                                    @csrf
	                                <input type="hidden" name="admin_appointment_id"
                                    value="{{$cancelled_appointment->appointment_id}}">
                                    <input type="submit" id ="{{$cancelled_appointment->appointment_id}}">
                                    
	                            </form>
                                <label for="{{$cancelled_appointment->appointment_id}}">
                                    {{$cancelled_appointment->appointment_id}}
                                </label> 
                            </td>
                            <td class= "appoinments_data">
                                {{$cancelled_appointment->date}}
                            </td>
                            <td class= "appoinments_data">
                                {{$cancelled_appointment->customer->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$cancelled_appointment->artist->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$cancelled_appointment->appointment->status}}
                            </td>
                            <td class= "appoinments_data">
                                {{$cancelled_appointment->payment->status}}
                            </td>
                            <td class= "appoinments_data">
                                {{$cancelled_appointment->payment->refund_status}}
                            </td>
                            <td class= "appoinments_data">
                               {{$cancelled_appointment->payment->artist_compensation_status}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$cancelled_appointment->payment->total_service_charge}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$cancelled_appointment->payment->total_booking_fee}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            <br><br>

            <p class="title">
                @if(!$completed_appointments->isEmpty())
                    <a href="" class="download_excel">
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
                <table class="appointments" >
                    <tr class= "appointments_headers">
                        <td class= "appoinments_data">
                            Appointment ID
                        </td>
                        <td class= "appoinments_data">
                            Date
                        </td>
                        <td class= "appoinments_data">
                            Customer
                        </td>
                        <td class= "appoinments_data">
                            Artist
                        </td>
                        <td class= "appoinments_data">
                            Payment Status
                        </td>
                        <td class= "appoinments_data">
                            Customer Refund Status
                        </td>
                        <td class= "appoinments_data">
                            Artist Compensation Status
                        </td>
                        <td class= "appoinments_data">
                            Service Charge
                        </td>
                        <td class= "appoinments_data">
                            Booking Fee
                        </td>
                    </tr>
                    @foreach($completed_appointments as $completed_appointment)
                        <tr class= "appoinments_rows">
                            <td class= "appoinments_data">
                                <form method="post" action="/admin_search_appointments_by_click" class="hidden_form">
                                    @csrf
	                                <input type="hidden" name="admin_appointment_id"
                                    value="{{$completed_appointment->appointment_id}}">
                                    <input type="submit" id ="{{$completed_appointment->appointment_id}}">
                                    
	                            </form>
                                <label for="{{$completed_appointment->appointment_id}}">
                                    {{$completed_appointment->appointment_id}}
                                </label>         
                            </td>
                            <td class= "appoinments_data">
                                {{$completed_appointment->date}}
                            </td>
                            <td class= "appoinments_data">
                                {{$completed_appointment->customer->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$completed_appointment->artist->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$completed_appointment->payment->status}}
                            </td>
                            <td class= "appoinments_data">
                                {{$completed_appointment->payment->refund_status}}
                            </td>
                            <td class= "appoinments_data">
                               {{$completed_appointment->payment->artist_compensation_status}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$completed_appointment->payment->total_service_charge}}
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$completed_appointment->payment->total_booking_fee}}
                            </td>
                        </tr>
                    @endforeach
                    <tr >
                        <td class= "total" colspan="8">
                            Total:
                        </td>
                        <td class= "total_service_charge">
                            Tk {{$completed_appointments->sum('payment.total_booking_fee')}}
                        </td>
                    </tr>
                </table>
            @endif
            <br> 

            <p class="title">
                @if(!$appointments->isEmpty())
                    <a href="" class="download_excel">
                        <i class="fa-solid fa-download"></i>Appointments
                    </a>
                @else
                    Appointments
                @endif
            </p>
            @if($appointments->isEmpty())
                <p class="text" style = "margin-left: 65px;">No Appiontments</p>
            @else
                <br>
                <table class="appointments" >
                    <tr class= "appointments_headers">
                        <td class= "appoinments_data">
                            Appointment ID
                        </td>
                        <td class= "appoinments_data">
                            Date
                        </td>
                        <td class= "appoinments_data">
                            Customer
                        </td>
                        <td class= "appoinments_data">
                            Artist
                        </td>
                        <td class= "appoinments_data">
                            Status
                        </td>
                        <td class= "appoinments_data">
                            Payment Status
                        </td>
                        <td class= "appoinments_data">
                            Customer Refund Status
                        </td>
                        <td class= "appoinments_data">
                            Artist Compensation Status
                        </td>
                        <td class= "appoinments_data">
                            Service Charge
                        </td>
                        <td class= "appoinments_data">
                            Booking Fee
                        </td>
                    </tr>
                    @foreach($appointments as $appointment)
                        <tr class= "appoinments_rows">
                            <td class= "appoinments_data">
                                <form method="post" action="/admin_search_appointments_by_click" class="hidden_form">
                                    @csrf
	                                <input type="hidden" name="admin_appointment_id"
                                    value="{{$appointment->appointment_id}}">
                                    <input type="submit" id ="{{$appointment->appointment_id}}">
                                    
	                            </form>
                                <label for="{{$appointment->appointment_id}}">
                                    {{$appointment->appointment_id}}
                                </label>
                            </td>
                            <td class= "appoinments_data">
                                {{$appointment->date}}
                            </td>
                            <td class= "appoinments_data">
                                {{$appointment->customer->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$appointment->artist->name}}
                            </td>
                            <td class= "appoinments_data">
                                {{$appointment->appointment->status}}
                            </td>
                            <td class= "appoinments_data">
                                {{$appointment->payment->status}}
                            </td>
                            <td class= "appoinments_data">
                                {{$appointment->payment->refund_status}}
                            </td>
                            <td class= "appoinments_data">
                               {{$appointment->payment->artist_compensation_status}}
                            </td>
                            <td class= "appoinments_data">
                                @if(strpos($appointment->payment->total_service_charge, 'Tk') !== false)
                                    {{ $appointment->payment->total_service_charge }} 
                                @else
                                    Tk {{ $appointment->payment->total_service_charge }}
                                @endif 
                            </td>
                            <td class= "appoinments_data">
                                Tk {{$appointment->payment->total_booking_fee}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            <br><br><br><br><br><br><br><br><br>

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
    <script src="JS/Admin/admin_bar.js"></script>

</body>
</html>



