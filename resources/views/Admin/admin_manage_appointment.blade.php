<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Admin/admin_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form method="post" action="/admin_manage_appointment" class="form">
        @csrf 

        <div class="heading_box">
            <p class="title"> Appointment Summary </p>
        </div>
        @if($appointment->appointment->status == "unconfirmed" && $appointment->appointment->date >  date('Y-m-d'))
            <div class="heading_box">
                <p class="text" style = "text-align: center;">
                    It's a unconfirmed upcoming appointment, check the payment details and confirm/cancel
                </p>
            </div>
            @php
                $form = "confirm_cancel";
            @endphp
        @elseif($appointment->payment->refund_status == "required")
            <div class="heading_box">
                <p class="text" style = "text-align: center;">
                    This appointment is cancelled by artist, refund the customer
                </p>
            </div>
            @php
                $form = "refund";
            @endphp
        @elseif($appointment->payment->artist_compensation_status == "required")
            <div class="heading_box">
                <p class="text" style = "text-align: center;">
                    This appointment is cancelled by customer, compensate the artist
                </p>
            </div>
            @php
                $form = "compensate";
            @endphp
        @elseif($appointment->payment->refund_status == "paid")
            @php
                $form = "view";
            @endphp
        @elseif($appointment->payment->artist_compensation_status == "paid")
            @php
                $form = "view";
            @endphp
        @elseif($appointment->appointment->status == "confirmed" && $appointment->appointment->date < date('Y-m-d'))
            <div class="heading_box">
                <p class="text" style = "text-align: center;">
                    It's a confirmed previous appointment, check who cancelled the appointment, if the appointment was cancelled by the customer, compensate the artist; if it was cancelled by the artist, then compensate the customer
                </p>
            </div>
            @php
                $form = "refund_compensate";
            @endphp
            @else
                @php
                    $form = "view";
                @endphp
            @endif

        <div class="text_box">
            <p class="text"><span class="sub_title">Appointment ID:</span> {{$appointment->appointment_id}}</p>
        </div>
        <div class="text_box">
            <p class="text"><span class="sub_title">Date:</span> {{$appointment->appointment->date}}</p>
        </div>
        <div class="text_box">
            <span class="sub_title">Appointment Status: </span>
                @if($appointment->appointment->status == "unconfirmed" && $appointment->appointment->date > date('Y-m-d'))
                    <select name="admin_appointment_status">
                        <option value="">{{$appointment->appointment->status}}</option>
                        <option value="confirmed">Confirm</option>
                        <option value="cancel">Cancel</option>
                    </select>
                @else
                    <p class="text" style = "margin-left: 5px;">  {{$appointment->appointment->status}}</p>
                @endif
        </div>
        <div class="text_box">
            <p class="text"><span class="sub_title">Artist:</span> {{$appointment->artist->name}}
                <a href="tel:{{ $appointment->artist->phone }}">
                    ( <i class="fa-solid fa-phone"></i>
                    {{ $appointment->artist->phone }} )
			    </a>
            </p>
        </div>
        <div class="text_box">
            <p class="text"><span class="sub_title">Customer:</span> {{$appointment->customer->name}}
                <a href="tel:{{ $appointment->customer->phone }}">
                    ( <i class="fa-solid fa-phone"></i>
                    {{ $appointment->customer->phone }} )
			    </a>
            </p>
        </div>
        <br>

        <div class="heading_box">
            <p class="title"> Payment Details </p>
        </div>
        <div class="text_box">
            <p class="text"><span class="sub_title">Booking Fee:</span> Tk {{$appointment->payment->total_booking_fee}}</p>
        </div>
        <div class="text_box">
            <p class="text"><span class="sub_title">Service Charge:</span>
                @if(strpos($appointment->payment->total_service_charge, 'Tk') !== false)
                    {{ $appointment->payment->total_service_charge }} 
                @else
                    Tk {{ $appointment->payment->total_service_charge }}
                @endif 
            </p>
        </div>
        @php
            $payment = explode('-', $appointment->payment->payment_transaction_id);
        @endphp
        <div class="text_box">
            <p class="text"><span class="sub_title">Payment Method:</span> {{$payment[0]}}</p>
        </div>
        <div class="text_box">
            <p class="text"><span class="sub_title">Payment Transaction ID:</span> {{$payment[1]}}</p>
        </div>
        <div class="text_box">
            <p class="text"><span class="sub_title">Payment Status:</span> {{$appointment->payment->status}}</p>
        </div>
        @if($appointment->payment->refund_status == "required")
            <div class="text_box">
                <span class="sub_title">Customer Refund Status:</span>
                <select name="admin_refund_status" >
                    <option value="">{{$appointment->payment->refund_status}}</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="text_box">
                <p class="text"><span class="sub_title">Artist Compensation Status:</span> {{$appointment->payment->artist_compensation_status}}</p>
            </div>
        @elseif($appointment->payment->artist_compensation_status == "required")
            <div class="text_box">
                <p class="text"><span class="sub_title">Customer Refund Status:</span> {{$appointment->payment->refund_status}}</p>
            </div>
            <div class="text_box">
                <span class="sub_title">Artist Compensation Status:</span>
                <select name="admin_artist_compensation_status" >
                    <option value="">{{$appointment->payment->artist_compensation_status}}</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
        @elseif($appointment->payment->refund_status == "paid")
            <div class="text_box">
                <p class="text"><span class="sub_title">Customer Refund Status:</span> {{$appointment->payment->refund_status}}</p>
            </div>
            <div class="text_box">
                <p class="text"><span class="sub_title">Artist Compensation Status:</span> {{$appointment->payment->artist_compensation_status}}</p>
            </div>
        @elseif($appointment->payment->artist_compensation_status == "paid")
            <div class="text_box">
                <p class="text"><span class="sub_title">Customer Refund Status:</span> {{$appointment->payment->refund_status}}</p>
            </div>
            <div class="text_box">
                <p class="text"><span class="sub_title">Artist Compensation Status:</span> {{$appointment->payment->artist_compensation_status}}</p>
            </div>
        @elseif($appointment->appointment->status == "confirmed" && $appointment->appointment->date < date('Y-m-d'))
            <div class="text_box">
                <span class="sub_title">Customer Refund Status:</span>
                <select name="admin_refund_status" >
                    <option value="">{{$appointment->payment->refund_status}}</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="text_box">
                <span class="sub_title">Artist Compensation Status:</span>
                <select name="admin_artist_compensation_status" >
                    <option value="">{{$appointment->payment->artist_compensation_status}}</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
        @else
            <div class="text_box">
                <p class="text"><span class="sub_title">Customer Refund Status:</span> {{$appointment->payment->refund_status}}</p>
            </div>
            <div class="text_box">
                <p class="text"><span class="sub_title">Artist Compensation Status:</span> {{$appointment->payment->artist_compensation_status}}</p>
            </div>
        @endif
        <div class="errorMsg" >
            @if ($errors->has('error'))
                 <i class="fa-solid fa-circle-exclamation"></i>
                 {{ $errors->first('error') }}
            @endif
        </div>
        <br>

        <input type="hidden" name="form" value="{{$form}}">        
        <input class="button" type="submit" name="Save" value="Save">
	</form>

     <!-- Initialize Datepicker -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="JS/Admin/admin_select_input.js"></script>

    
    


</body>
</html>

