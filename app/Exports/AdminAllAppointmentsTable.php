<?php

namespace App\Exports;

use App\Models\AppointArtCusModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class AdminAllAppointmentsTable implements FromView
{
    public function view(): View
    {
        $appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
            ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
            ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
            ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
            ->get();

        return view('Admin.admin_all_appointments_download_excel', [
            'appointments' => $appointments,
        ]);
    }
}
