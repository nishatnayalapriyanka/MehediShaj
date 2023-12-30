<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArtistCompletedAppointmentsTable;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\CustomerModel;
use App\Models\ArtistModel;
use App\Models\PackageModel;
use App\Models\GalleryModel;
use App\Models\AppointArtCusModel;
use App\Models\AppointmentModel;
use App\Models\PaymentModel;
use App\Models\FeedbackModel;

class AdminController extends Controller
{

    //send SMS
    private function sendSMS($phone, $message) {
        $to = $phone;
        $token = "936221561516978173758f3cdd4b1c45ff685bd1d76d51e11d42";
        $message = $message;

        $url = "http://api.greenweb.com.bd/api.php?json";


        $data= array(
        'to'=>"$to",
        'message'=>"$message",
        'token'=>"$token"
        ); 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
    }

    //login
    public function admin_login(Request $request){
        $request->validate(
        [
            'admin_login_password'=>'required',
        ]
        );

        if ($request->input('admin_login_password') == "1234") {
            Session :: put('admin_login_password',$request->input('admin_login_password'));
            return redirect('/admin_dashboard');
        } else {
            return Redirect::back()->withErrors(['error' => 'Invalid Log In, please try again...']);
        }
    }

    //dashboard
    public function admin_dashboard(){
        if (Session::has('admin_login_password')) {
            $completed_appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->where('appointment.status', 'completed')
                ->get();

            $confirmed_appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->where('appointment.status', 'confirmed')
                ->get();

            $unconfirmed_appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->where('appointment.status', 'unconfirmed')
                ->get();

            $cancelled_appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->whereIn('appointment.status', ['cancelled-by-artist', 'cancelled-by-customer'])
                ->get();

            $appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->get();
            
            $current_year_monthly_income_array = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->where('appointment.status', 'completed')
                ->whereYear('appointment.date', date('Y'))
                ->selectRaw('MONTH(appointment.date) as month, SUM(payment.total_booking_fee) as monthly_income')
                ->groupByRaw('MONTH(appointment.date)')
                ->get()
                ->pluck('monthly_income', 'month')
                ->toArray();
            for($i = 1; $i <= 12; $i++){
                if (!array_key_exists($i, $current_year_monthly_income_array)) {
                    $current_year_monthly_income_array[$i] = 0; 
                }
            }
            ksort($current_year_monthly_income_array);
            $monthNames = array('January','February','March','April','May','June','July','August','September','October','November','December');
            $current_year_monthly_income = array_combine(
                $monthNames,
                array_values($current_year_monthly_income_array)
            );
            
            return view('Admin.admin_dashboard', compact('completed_appointments', 'appointments', 'current_year_monthly_income', 'confirmed_appointments', 'unconfirmed_appointments', 'cancelled_appointments'));
        } else {
            return redirect('/admin_login');
        }    
    }

    //search appointment
    public function admin_search_appointments(Request $request){
        $request->validate(
        [
            'admin_appointment_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $appoint_art_cus = AppointArtCusModel::where('appointment_id', $value)->first();
                    if (!$appoint_art_cus) {
                        $fail('There is no appointment under this ID');
                    }
                },
            ],
        ]
        );

        Session::put('admin_appointment_id',$request->input('admin_appointment_id'));
        return redirect('/admin_manage_appointment');
    }

    public function admin_search_appointments_by_click(Request $request){
        Session::put('admin_appointment_id',$request->input('admin_appointment_id'));
        return redirect('/admin_manage_appointment');
    }

    //manage appointment
    public function get_admin_manage_appointment(Request $request){
        if (Session::has('admin_appointment_id')) {
        $appointment = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->where('appoint_art_cus.appointment_id', Session::get('admin_appointment_id'))
                ->first();

        return view('Admin.admin_manage_appointment', compact('appointment'));
        }else{
            return redirect('/admin_dashboard');
        }

    }

    public function post_admin_manage_appointment(Request $request){
        if ($request->input('form') == "confirm_cancel") {   
            if($request->input('admin_appointment_status') == "confirmed"){
                $appointment = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->where('appoint_art_cus.appointment_id', Session::get('admin_appointment_id'))
                ->first();

                $appointment->appointment->status = "confirmed";
                $appointment->payment->status = "paid";

                //send sms start
                $customer_message = "Dear ".$appointment->customer->name.
                ",\n Your appointment (Appointment ID: ".$appointment->appointment->appointment_id.
                ") on ".$appointment->appointment->date." at ".$appointment->appointment->time.
                " with ".$appointment->artist->name." has been successfully confirmed.Thank you for choosing our services, we look forward to serving you.\n\nBest regards,\n@MehediShaj";
                $this->sendSMS($appointment->customer->phone , $customer_message);
                //send sms close

                // Send notification to the henna artist about the appointment
                $artist_message = "Hello ".$appointment->artist->name.
                ",\nYou have a new appointment scheduled.Appointment Details,\nAppointment ID: ".$appointment->appointment->appointment_id.
                "\nDate: ".$appointment->appointment->date."\nTime: ".$appointment->appointment->time.
                "\nNumber of Clients for Non-Bridal Package: ".$appointment->appointment->num_of_clients_for_non_bridal_package.
                "\nNumber of Clients for Bridal Package: ".$appointment->appointment->num_of_clients_for_bridal_package.
                "\nCustomer: ".$appointment->customer->name."\nCustomer Phone: ".$appointment->customer->phone.
                "\nAddress: ".$appointment->appointment->delivery_area.
                "\nBooking Fee: ".$appointment->payment->total_booking_fee.
                "\nService Charge: ".$appointment->payment->total_service_charge.
                "\n\nPlease be prepared and available for the appointment.\n\nBest regards,\n@MehediShaj";
                $this->sendSMS($appointment->artist->phone , $artist_message);
                // Sending SMS notification to the henna artist

                $appointment->appointment->save();
                $appointment->payment->save() ;

                return redirect('/admin_dashboard');

            }elseif($request->input('admin_appointment_status') == "cancel"){
                $appointment = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                ->where('appoint_art_cus.appointment_id', Session::get('admin_appointment_id'))
                ->first();

                //send sms start
                $customer_message = "Dear ".$appointment->customer->name.
                ",\nWe regret to inform you that your appointment (Appointment ID: ".$appointment->appointment->appointment_id.
                ") scheduled for ".$appointment->appointment->date." at ".$appointment->appointment->time.
                " with ".$appointment->artist->name." has been cancelled by the admin due to payment issues. We apologize for any inconvenience caused.\n\nBest regards,\n@MehediShaj";
                $this->sendSMS($appointment->customer->phone , $customer_message);
                //send sms close

                $appointment->delete();
                $appointment->appointment->delete();
                $appointment->payment->delete() ;
                return redirect('/admin_dashboard');
            }else{
                return Redirect::back()->withErrors(['error' => 'Confirm or cancel the appointment...']);
            }
        }
        elseif ($request->input('form') == "refund") {
            if ($request->input('admin_refund_status') == "paid") {  
                $appointment = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                    ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                    ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                    ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                    ->where('appoint_art_cus.appointment_id', Session::get('admin_appointment_id'))
                    ->first();

                $appointment->payment->refund_status = "paid";
                $appointment->payment->save() ;

                return redirect('/admin_dashboard');
            }
            else{
                return Redirect::back()->withErrors(['error' => 'Refund the customer...']);
            }
        }
        elseif ($request->input('form') == "compensate") {
            if ($request->input('admin_artist_compensation_status') == "paid") {  
                $appointment = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                    ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                    ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                    ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                    ->where('appoint_art_cus.appointment_id', Session::get('admin_appointment_id'))
                    ->first();

                $appointment->payment->artist_compensation_status = "paid";
                $appointment->payment->save() ;

                return redirect('/admin_dashboard');
            }
            else{
                return Redirect::back()->withErrors(['error' => 'Compensate the artist...']);
            }
        }
        elseif ($request->input('form') == "refund_compensate") {
            if ($request->input('admin_artist_compensation_status') == "paid" && $request->input('admin_refund_status') == "paid") {  
                return Redirect::back()->withErrors(['error' => 'Refund or Compensate...']);
            }elseif ($request->input('admin_refund_status') == "paid") {  
                $appointment = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                    ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                    ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                    ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                    ->where('appoint_art_cus.appointment_id', Session::get('admin_appointment_id'))
                    ->first();

                $appointment->appointment->status = "cancelled-by-artist";
                $appointment->appointment->save() ;

                $appointment->payment->refund_status = "paid";
                $appointment->payment->save() ;

                return redirect('/admin_dashboard');
            }elseif ($request->input('admin_artist_compensation_status') == "paid") {  
                $appointment = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                    ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                    ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                    ->join('artist', 'appoint_art_cus.artist_phone', '=', 'artist.phone')
                    ->where('appoint_art_cus.appointment_id', Session::get('admin_appointment_id'))
                    ->first();

                $appointment->appointment->status = "cancelled-by-customer";
                $appointment->appointment->save() ;

                $appointment->payment->artist_compensation_status = "paid";
                $appointment->payment->save() ;

                return redirect('/admin_dashboard');
            }else{
                return Redirect::back()->withErrors(['error' => 'Refund or Compensate...']);
            }
       
        }
        elseif ($request->input('form') == "view") {
            return redirect('/admin_dashboard');
       
        }
    }

    //logout
    public function admin_logout(){
        if (Session::has('admin_login_password')) {
            //Auth::logout();
            Session::flush();
            return redirect('/admin_login');
        } else {
           return redirect('/admin_login');
        }       
    }
}
