<table>
    <tr>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Appointment ID
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Date
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Status
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Customer
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Artist
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Payment Status
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Customer Refund Status
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Artist Compensation Status
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Service Charge
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Booking Fee
        </td>
    </tr>
    @foreach($appointments as $key => $appointment)
        <tr>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->appointment_id}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->appointment->date}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->customer->name}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->artist->name}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->appointment->status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->payment->status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->payment->refund_status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$appointment->payment->artist_compensation_status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                @if(strpos($appointment->payment->total_service_charge, 'Tk') !== false)
                    {{ $appointment->payment->total_service_charge }} 
                @else
                    Tk {{ $appointment->payment->total_service_charge }}
                @endif 
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                Tk {{$appointment->payment->total_booking_fee}}
            </td>
        </tr> 
    @endforeach
</table>
