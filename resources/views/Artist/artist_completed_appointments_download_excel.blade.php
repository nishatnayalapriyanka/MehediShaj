<table>
    <tr>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Appointment ID
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Date
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Time
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Non-Bridal Package
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Bridal Package
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Customer
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Location
        </td>
        <td style="background-color: #00BF63; color: white; font-family: 'Times New Roman'; font-size: 16px; font-weight: bold; text-align: center; border: 2px solid #008000;">
            Service Charge
        </td>
    </tr>
    @foreach($completed_appointments as $key => $completed_appointment)
        <tr>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$completed_appointment->appointment_id}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$completed_appointment->appointment->date}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$completed_appointment->appointment->time}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$completed_appointment->appointment->num_of_clients_for_non_bridal_package}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$completed_appointment->appointment->num_of_clients_for_bridal_package}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$completed_appointment->customer->name}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                {{$completed_appointment->appointment->delivery_area}}
            </td>
            <td style="border: 2px solid #008000;background-color: {{ $key % 2 == 0 ? 'transparent' : '#b0fad4' }}; font-family: 'Times New Roman'; font-size: 16px; text-align: center;">
                Tk {{$completed_appointment->payment->total_service_charge}}
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="7" style="font-family: 'Times New Roman'; font-size: 16px; text-align: right; color: #008000; font-weight: bold;">
            Total:
        </td>
        <td style="font-family: 'Times New Roman'; font-size: 16px; text-align: center; color: #008000; font-weight: bold;">
            Tk {{$completed_appointments->sum('payment.total_service_charge')}}
        </td>
    </tr>
</table>
