<?php

namespace App\Exports;

use App\Models\AppointArtCusModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class AdminUnconfirmedAppointmentsTable implements FromView
{
    public function view(): View
    {
        $unconfirmed_appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
            ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
            ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
            ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
            ->where('appointment.status', 'unconfirmed')
            ->get();

        return view('Admin.admin_unconfirmed_appointments_download_excel', [
            'unconfirmed_appointments' => $unconfirmed_appointments,
        ]);
    }
}
