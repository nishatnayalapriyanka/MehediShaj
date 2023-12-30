<?php

namespace App\Exports;

use App\Models\AppointArtCusModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class ArtistCompletedAppointmentsTable implements FromView
{
    public function view(): View
    {
        $completed_appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
            ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
            ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
            ->where('appoint_art_cus.artist_phone', Session::get('artist_phone'))
            ->where('appointment.status', 'completed')
            ->get();

        return view('Artist.artist_completed_appointments_download_excel', [
            'completed_appointments' => $completed_appointments,
        ]);
    }
}
