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
    @foreach($cancelled_appointments as $key => $cancelled_appointment)
        <tr>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->appointment_id}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->appointment->date}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->customer->name}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->artist->name}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->appointment->status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->payment->status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->payment->refund_status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->payment->artist_compensation_status}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$cancelled_appointment->payment->total_service_charge}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                Tk {{$cancelled_appointment->payment->total_booking_fee}}
            </td>
        </tr>
    @endforeach
</table>
