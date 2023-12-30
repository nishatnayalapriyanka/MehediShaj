<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/Customer/customer_bill_export.css">
</head>
<body>  
    <div class="header_container">
        <table class="header">
            <tr>
                <td class="header_left">
                    <p class="contact"><img class="icon" src="Project Image/mail.png"> priyanka.programming@gmail.com</p>
                    <p class="contact"><img class="icon" src="Project Image/phone.png"> +8801641496294</p>
                </td>
                <td class="header_right">
                    <img class="logo" src="Project Image/MehediShaj_logo.png">
                </td>
            </tr>
        </table>
    </div>

    <div class="appointment_customer_container">
        <table class="appointment_customer">
            <tr>
                <td class="appointment_header">
                    Appiontment Details
                </td>
                <td class="gap">
                    
                </td>
                <td class="customer_header">
                    Customer Details
                </td>
            </tr>
            <tr>
                <td class="appointment" >
                    <p><span class="sub_title">Appointment ID: </span>{{ $appointment->appointment->appointment_id }}</p>
                    <p><span class="sub_title">Date: </span>{{ $appointment->appointment->date }}</p>
                    <p><span class="sub_title">Time: </span>{{ $appointment->appointment->time }}</p>
                    <p><span class="sub_title">Status: </span>{{ $appointment->appointment->status }}</p>
                    <p><span class="sub_title">Artist: </span>{{ $appointment->artist->name }}</p>
                </td>
                <td class="gap">
                    
                </td>
                <td class="customer" rowspan="3">
                    <p><span class="sub_title">Name: </span>{{ session('customer_name') }}</p>
                    <p><span class="sub_title">Phone: </span>{{ session('customer_phone') }}</p>
                    <p><span class="sub_title">Address: </span>{{ $appointment->appointment->delivery_area }}</p>
                </td>
            </tr>
            <tr> 
                <td class="customer_header">
                    Payment Details
                </td>
                <td class="gap">
                    
                </td>
            </tr>
            <tr>        
                <td class="payment">
                    @php
                        $payment = explode('-', $appointment->payment->payment_transaction_id);
                    @endphp
                    <p><span class="sub_title">Payment Method: </span>{{$payment[0]}}</p>
                    <p><span class="sub_title">Transaction Id: </span>{{$payment[1]}}</p>
                    <p><span class="sub_title">Refund Status: </span>{{ $appointment->payment->refund_status }}</p>                    
                </td>
                <td class="gap">
                    
                </td>
            </tr>
        </table>
    </div>

    <div class="service_container">
        <table class="service">
            <tr>
                <td class="service_header" colspan="4">
                        Service
                </td>
            </tr>

            <tr>
                <td class="service_headers" >
                        Package
                </td>
                <td class="service_headers" >
                        Quantity
                </td>
                <td class="service_headers">
                        Booking Fee
                </td>
                <td class="service_headers">
                        Service Charge
                </td>
            </tr>

            <tr>
                <td class="service_data" >
                        Non-Bridal
                </td>
                <td class="service_data" >
                        {{ $appointment->appointment->num_of_clients_for_non_bridal_package }}
                </td>
                <td class="service_data" rowspan="2">
                    Tk {{ $appointment->payment->total_booking_fee }}
                </td>
                <td class="service_data" rowspan="2">
                    @if(strpos($appointment->payment->total_service_charge, 'Tk') !== false)
                        {{ $appointment->payment->total_service_charge }} 
                    @else
                        Tk {{ $appointment->payment->total_service_charge }}
                    @endif
                </td>
            </tr>

            <tr>
                <td class="service_data" >
                        Bridal
                </td>
                <td class="service_data" >
                        {{ $appointment->appointment->num_of_clients_for_bridal_package }}
                </td>   
            </tr>

            <tr>
                <td class="payment_calculation" colspan="3">
                    Total Bill:
                </td>
                <td class="payment_calculation_value" >
                    @if(strpos($appointment->payment->total_service_charge, 'Tk') !== false)
                        {{ $appointment->payment->total_service_charge }} 
                    @else
                        Tk {{ $appointment->payment->total_service_charge }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
