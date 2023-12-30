<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArtistCompletedAppointmentsTable;


use App\Models\CustomerModel;
use App\Models\ArtistModel;
use App\Models\PackageModel;
use App\Models\GalleryModel;
use App\Models\AppointArtCusModel;
use App\Models\AppointmentModel;
use App\Models\PaymentModel;
use App\Models\FeedbackModel;

class ArtistController extends Controller
{
    public function admin_phone()
    {
        return "01641496294";
    }

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

    //sign up
    public function artist_signup_phone_number_verify(Request $request){
        $request->validate(
            [
                'artist_signup_phone' => 'required|numeric|digits:11|regex:/^01/'
            ]
        );

        $artist = ArtistModel :: where ('phone',$request->input('artist_signup_phone'))->first();

        if($artist){
            return Redirect::back()->withErrors(['error' => 'Account already exists...']);
        }else{
            $artist_signup_otp = rand(1000,9999);
       
            //send sms start
            $message = "Your sign-up OTP is: ".$artist_signup_otp."\n@MehediShaj";
            $this->sendSMS($request->input('artist_signup_phone'), $message);
            //send sms close

            Session :: put('artist_signup_phone',$request->input('artist_signup_phone'));
            Session :: put('artist_signup_otp',$artist_signup_otp);

            return redirect('/artist_signup_otp_verify');
        }    
    }
    
    public function artist_signup_otp_verify(Request $request){
        $request->validate(
            [
                'artist_signup_otp' => 'required|numeric|digits:4'
            ]
        );

        if($request->input('artist_signup_otp')==Session::get('artist_signup_otp')){
            Session :: put('artist_signup_verified_phone',Session::get('artist_signup_phone'));
            Session :: put('artist_signup_verified_otp',Session::get('artist_signup_otp'));

            Session::forget('artist_signup_phone');
            Session::forget('artist_signup_otp');
                      
            return redirect('/artist_signup'); 
        }else{
            return Redirect::back()->withErrors(['error' => 'Wrong OTP, try again...']);
        }         
    }

    public function artist_signup(Request $request){
        $request->validate(
        [
            'artist_signup_profile_pic' => 'required|image',
            'artist_signup_name'=>'required',
            'artist_signup_verified_phone' => [
                'required',
                'numeric',
                'digits:11',
                'regex:/^01/',
                function ($attribute, $value, $fail) {
                    if ($value != Session::get('artist_signup_verified_phone')) {
                        $fail('Verified phone number can not be changed.');
                    }
                },
            ],
            'artist_signup_password'=>'required',
            'artist_signup_address'=>'required',
            'artist_signup_city'=>'required',         
            'artist_signup_non_bridal_starting_price'=>'required|numeric',
            'artist_signup_non_bridal_max_price'=>'required|numeric',
            'artist_signup_bridal_starting_price'=>'required|numeric',
            'artist_signup_bridal_max_price'=>'required|numeric',
            'artist_signup_home_service_charge'=>'required|numeric',
            'artist_signup_termsNconditions'=>'required'
        ]
        );       
     
        $artist = new  ArtistModel();
        $artist->name = $request->input('artist_signup_name');
        $artist->phone = Session::get('artist_signup_verified_phone');
        $artist->password = password_hash($request->input('artist_signup_password'), PASSWORD_BCRYPT);
        $artist->address = $request->input('artist_signup_address');
        $artist->city = $request->input('artist_signup_city');
        if($request->hasfile('artist_signup_profile_pic')){
            $img = $request->file('artist_signup_profile_pic');
            $extension = $img->getClientOriginalExtension();
            $img_name = $request->input('artist_signup_verified_phone').time().'.'.$extension;
            $img->move('Artist Profile Picture/',$img_name);
            $artist->profile_pic = $img_name;
        }
        else{
            $artist->profile_pic = null;
        }
        $artist->save();

        $package = new  PackageModel();
        $package->artist_phone = Session::get('artist_signup_verified_phone');
        $package->category = "Non-Bridal";
        $package->starting_price = $request->input('artist_signup_non_bridal_starting_price');
        $package->maximum_price= $request->input('artist_signup_non_bridal_max_price');
        $package->save();

        $package = new  PackageModel();
        $package->artist_phone = Session::get('artist_signup_verified_phone');
        $package->category = "Bridal";
        $package->starting_price = $request->input('artist_signup_bridal_starting_price');
        $package->maximum_price = $request->input('artist_signup_bridal_max_price');
        $package->save();

        $package = new  PackageModel();
        $package->artist_phone = Session::get('artist_signup_verified_phone');
        $package->category = "Home Service";
        $package->starting_price = $request->input('artist_signup_home_service_charge');
        $package->maximum_price = 0 ;
        $package->save();

        //send sms start
        $message = "Hello!!! " . $request->input('artist_signup_name') .
        ",\nThank you for signing up with us!We're excited to have you.\n\nBest regards,\n@MehediShaj";
        $this->sendSMS(Session::get('artist_signup_verified_phone'), $message);
        //send sms close

        Session::forget('artist_signup_verified_phone');
        Session::forget('artist_signup_verified_otp');

        return redirect('/artist_login');      
    }

    //login
    public function artist_login(Request $request){
        $request->validate(
        [
            //'artist_login_phone'=>'required|numeric|digits:11|regex:/^01/',
			'artist_login_phone'=>'required',
            'artist_login_password'=>'required'
        ]
        );

        $artist = ArtistModel :: where ('phone',$request->input('artist_login_phone'))->first();

        if ( $artist && password_verify( $request->input('artist_login_password'), $artist->password ) ) {
            // Password matches
            Session::put('artist_name', $artist->name);
            Session::put('artist_password', $artist->password);
            Session::put('artist_phone', $artist->phone);
            Session::put('artist_profile_pic', $artist->profile_pic);
            Session::put('artist_address', $artist->address);
            Session::put('artist_city', $artist->city);

            $package =  PackageModel :: where ('artist_phone',$request->input('artist_login_phone'))->get();
             
            foreach($package as $package){
                if($package->category == "Non-Bridal"){
                    Session::put('artist_non_bridal_starting_price', $package->starting_price);
                    Session::put('artist_non_bridal_max_price', $package->maximum_price);
                }elseif($package->category == "Bridal"){
                    Session::put('artist_bridal_starting_price', $package->starting_price);
                    Session::put('artist_bridal_max_price', $package->maximum_price);
                }
                else{
                    Session::put('artist_home_service_charge', $package->starting_price);
                }
            }

            return redirect('/artist_dashboard');
        } else {
            // Password doesn't match or customer not found
            return Redirect::back()->withErrors(['error' => 'Invalid Log In, please try again...']);
        }
    }

	public function artist_forget_password_phone_number_verify(Request $request){
        $request->validate(
        [
            'artist_forget_password_phone'=>'required|numeric|digits:11|regex:/^01/'
        ]
        );

        $artist= ArtistModel :: where ('phone',$request->input('artist_forget_password_phone'))->first();

        if($artist){
            $artist_forget_password_otp = rand(1000,9999);
       
            //send sms start
            $message = "Your OTP for change password is: ".$artist_forget_password_otp."\n@MehediShaj";
            $this->sendSMS($request->input('artist_forget_password_phone'), $message);
            //send sms close

            Session :: put('artist_forget_password_phone',$request->input('artist_forget_password_phone'));
            Session :: put('artist_forget_password_otp',$artist_forget_password_otp);

            return redirect('/artist_forget_password_otp_verify');
             
        }else{
            return Redirect::back()->withErrors(['error' => 'Account does not exists...']);
        }
    }

	public function artist_forget_password_otp_verify(Request $request){
        $request->validate(
        [
            'artist_forget_password_otp'=>'required|numeric|digits:4'
        ]
        );   

        if(Session::get('artist_forget_password_otp') == $request->input('artist_forget_password_otp')){
            
            Session :: put('artist_forget_password_verified_phone',Session::get('artist_forget_password_phone'));
            Session :: put('artist_forget_password_verified_otp',Session::get('artist_forget_password_otp'));

            Session::forget('artist_forget_password_phone');
            Session::forget('artist_forget_password_otp');
                      
            return redirect('/artist_forget_password'); 

        }else{
            return Redirect::back()->withErrors(['error' => 'Wrong OTP, try again...']);
        }       
    }

	public function artist_forget_password(Request $request){
        $request->validate(
        [
            'artist_forget_password_new_password'=>'required'
        ]
        );

        $artist = ArtistModel :: where ('phone',Session::get('artist_forget_password_verified_phone'))->first();

        $artist->password = password_hash($request->input('artist_forget_password_new_password'), PASSWORD_BCRYPT);
        $artist->save();

        Session::forget('artist_forget_password_verified_phone');
        Session::forget('artist_forget_password_verified_otp');

        return redirect('/artist_login');
    }

    //dashboard
    public function artist_dashboard(){
        if (Session::has('artist_phone')&&Session::has('artist_password')) {
            $completed_appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->where('appoint_art_cus.artist_phone', Session::get('artist_phone'))
                ->where('appointment.status', 'completed')
                ->get();

            $today_appointment = AppointArtCusModel::with(['appointment', 'payment', 'customer'])
            ->whereHas('appointment', function ($query) {
                $query->where('status', "confirmed")
                      ->whereDate('date', '=', now());
            })
            ->where('artist_phone', Session::get('artist_phone'))
            ->first();
            
            $current_year_monthly_income_array = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->where('appoint_art_cus.artist_phone', Session::get('artist_phone'))
                ->where('appointment.status', 'completed')
                ->whereYear('appointment.date', date('Y'))
                ->selectRaw('MONTH(appointment.date) as month, SUM(payment.total_service_charge) as monthly_income')
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
    
            
            return view('Artist.artist_dashboard', compact('completed_appointments', 'today_appointment', 'current_year_monthly_income'));
        } else {
            return redirect('/artist_login');
        }    
    }

    public function artist_complete_session(Request $request){
        $artist_complete_session_otp = rand(1000,9999);
       
        //send sms start
        $message = "Your OTP for complete session is: ".$artist_complete_session_otp."\n@MehediShaj";
        $this->sendSMS($request->input('complete_session_customer_phone'), $message);
        //send sms close

        Session :: put('artist_complete_session_appointment_id',$request->input('complete_session_appointment_id'));
        Session :: put('artist_complete_session_otp',$artist_complete_session_otp);

        return redirect('/artist_complete_session_otp_verify');
    }

    public function artist_complete_session_otp_verify(Request $request){
        $request->validate(
        [
            'artist_complete_session_otp'=>'required|numeric|digits:4'
        ]
        );
       
        if(Session::get('artist_complete_session_otp') == $request->input('artist_complete_session_otp')){

            Session :: put('artist_complete_session_verified_otp',Session::get('artist_complete_session_otp'));
            Session::forget('artist_complete_session_otp');
                      
            return redirect('/artist_complete_session_with_payment'); 

        }else{
            return Redirect::back()->withErrors(['error' => 'Wrong OTP, try again...']);
        }
    }

    public function artist_complete_session_with_payment(Request $request){
        $payment = PaymentModel::where('appointment_id', Session::get('artist_complete_session_appointment_id'))->first();
        $payment = explode('to', $payment->total_service_charge);

        $request->validate(
        [
            'artist_complete_session_payment' => 'required|numeric|min:'.trim($payment[0],"Tk ").'|max:'.trim($payment[1]," Tk ")    
        ]
        );

        $appointment = AppointArtCusModel::with(['appointment', 'payment'])
            ->where('appointment_id', Session::get('artist_complete_session_appointment_id'))
            ->first();

        $appointment->appointment->status = "completed";
        $appointment->appointment->save();

        $appointment->payment->total_service_charge = $request->input('artist_complete_session_payment') ;
        $appointment->payment->save();

        //send sms start
        $message = "Your have completed session (Appointment ID:".Session::get('artist_complete_session_appointment_id').
        "\nThank you for choosing us!\n\nBest regards,\n@MehediShaj";
        $this->sendSMS(Session::get('artist_phone'), $message);
        //send sms close

        Session::forget('artist_complete_session_appointment_id');
        Session::forget('artist_complete_session_verified_otp');

        return redirect('/artist_dashboard');
    }

    public function artist_completed_appointments_download_excel(){
        if (Session::has('artist_phone')&&Session::has('artist_password')) {
            return Excel::download(new ArtistCompletedAppointmentsTable, 'Completed Appointments.xlsx');   
        } else {
            return redirect('/artist_login');
        }    
    }

    //update profile
    public function artist_profile_update(Request $request){
        $request->validate(
        [
            'artist_profile_pic' => 'image',
            'artist_name'=>'required',
            'artist_address'=>'required',
            'artist_city'=>'required',
        ]
        );

        $artist = ArtistModel :: where ('phone',Session::get('artist_phone'))->first();
        $artist->name = $request->input('artist_name');
        $artist->address = $request->input('artist_address');
        $artist->city = $request->input('artist_city');
        if($request->hasfile('artist_profile_pic')){
            $destination = 'Artist Profile Picture/'.$artist->profile_pic;
            if(File::exists($destination) && $artist->profile_pic != null){
                File::delete($destination);
            }
            $img = $request->file('artist_profile_pic');
            $extension = $img->getClientOriginalExtension();
            $img_name = Session::get('artist_phone').time().'.'.$extension;
            $img->move('Artist Profile Picture/',$img_name);
            $artist->profile_pic = $img_name;
        }
        $artist->save();

        Session::put('artist_name', $artist->name);
        Session::put('artist_profile_pic', $artist->profile_pic);
        Session::put('artist_address', $artist->address);
        Session::put('artist_city', $artist->city);

        return redirect('/artist_profile');
    }

    public function artist_phone_update_phone_number_verify(Request $request){
        $request->validate(
        [
            'artist_phone_update_phone'=>'required|numeric|digits:11|regex:/^01/'
        ]
        );

        $artist = ArtistModel :: where ('phone',$request->input('artist_phone_update_phone'))->first();

        if($artist){
            return Redirect::back()->withErrors(['error' => 'Account already exists...']);            
        }else{
            $artist_phone_update_otp = rand(1000,9999);
       
            //send sms start
            $message = "Your OTP for change phone number is: ".$artist_phone_update_otp."\n@MehediShaj";
            $this->sendSMS($request->input('artist_phone_update_phone'), $message);
            //send sms close

            Session :: put('artist_phone_update_phone',$request->input('artist_phone_update_phone'));
            Session :: put('artist_phone_update_otp',$artist_phone_update_otp);

            return redirect('/artist_phone_update_otp_verify');     
        }
    }

    public function artist_phone_update_otp_verify(Request $request){
        $request->validate(
            [
                'artist_phone_update_otp' => 'required|numeric|digits:4'
            ]
        );

        if($request->input('artist_phone_update_otp')==Session::get('artist_phone_update_otp')){

            $artist = ArtistModel :: where ('phone',Session::get('artist_phone'))->first();
            $artist->phone = Session::get('artist_phone_update_phone');
            $artist->save();

            PackageModel::where('artist_phone', Session::get('artist_phone'))->update(['artist_phone' => Session::get('artist_phone_update_phone')]);
            GalleryModel::where('artist_phone', Session::get('artist_phone'))->update(['artist_phone' => Session::get('artist_phone_update_phone')]);
            AppointArtCusModel::where('artist_phone', Session::get('artist_phone'))->update(['artist_phone' =>  Session::get('artist_phone_update_phone')]);
            
            
            Session::put('artist_phone', Session::get('artist_phone_update_phone'));

            Session::forget('artist_phone_update_phone');
            Session::forget('artist_phone_update_otp');
            
            return redirect('/artist_profile');
        }else{
            return Redirect::back()->withErrors(['error' => 'Wrong OTP, try again...']);
        }         
    }

    public function artist_password_update(Request $request){
        $request->validate(
        [
            'artist_update_password_current'=>'required',
            'artist_update_password_new'=>'required'
        ]
        );

        $artist = ArtistModel :: where ('phone',Session::get('artist_phone'))->first();

        if (password_verify($request->input('artist_update_password_current'), $artist->password)) {
            $artist->password = password_hash($request->input('artist_update_password_new'), PASSWORD_BCRYPT);
            $artist->save();
            
            Session::put('artist_password', $request->input('artist_update_password_new'));

            return redirect('/artist_profile');
        } else {
            return Redirect::back()->withErrors(['error' => 'Worng password, please try again...']);
        }
    }

    public function artist_non_bridal_package_update(Request $request){
        $request->validate(
        [
            'artist_non_bridal_starting_price' => 'required|numeric',
            'artist_non_bridal_max_price'=>'required|numeric',
        ]
        );

        if($request->input('artist_non_bridal_starting_price') != Session::get('artist_non_bridal_starting_price') ||
        $request->input('artist_non_bridal_max_price') != Session::get('artist_non_bridal_max_price') ){

            PackageModel::where('artist_phone', Session::get('artist_phone'))
            ->where('category', "Non-Bridal")
            ->update([
                'starting_price' => $request->input('artist_non_bridal_starting_price'),
                'maximum_price' => $request->input('artist_non_bridal_max_price'),
            ]);

            Session::put('artist_non_bridal_starting_price', $request->input('artist_non_bridal_starting_price'));
            Session::put('artist_non_bridal_max_price', $request->input('artist_non_bridal_max_price'));

            //send sms start
            $message = "Dear " . Session::get('artist_name') .
            ",\nYou have changed your pricing, but your previous appointment's pricing will remain as before. Please check appointment details before you charge the customer.\n\nBest regards,\n@MehediShaj";
            $this->sendSMS(Session::get('artist_phone'), $message);
            //send sms close
        }

        return redirect('/artist_profile');
    }

    public function artist_bridal_package_update(Request $request){
        $request->validate(
        [
            'artist_bridal_starting_price' => 'required|numeric',
            'artist_bridal_max_price'=>'required|numeric',
        ]
        );

        if($request->input('artist_bridal_starting_price') != Session::get('artist_bridal_starting_price') ||
        $request->input('artist_bridal_max_price') != Session::get('artist_bridal_max_price') ){

            PackageModel::where('artist_phone', Session::get('artist_phone'))
            ->where('category', "Bridal")
            ->update([
                'starting_price' => $request->input('artist_bridal_starting_price'),
                'maximum_price' => $request->input('artist_bridal_max_price'),
            ]);

            Session::put('artist_bridal_starting_price', $request->input('artist_bridal_starting_price'));
            Session::put('artist_bridal_max_price', $request->input('artist_bridal_max_price'));

            //send sms start
            $message = "Dear " . Session::get('artist_name') .
            ",\nYou have changed your pricing, but your previous appointment's pricing will remain as before. Please check appointment details before you charge the customer.\n\nBest regards,\n@MehediShaj";
            $this->sendSMS(Session::get('artist_phone'), $message);
            //send sms close
        }

        return redirect('/artist_profile');
    }

    public function artist_home_service_charge_update(Request $request){
        $request->validate(
        [
            'artist_home_service_charge' => 'required|numeric',
        ]
        );

        if($request->input('artist_home_service_charge') != Session::get('artist_home_service_charge') ){

            PackageModel::where('artist_phone', Session::get('artist_phone'))
            ->where('category', "Home Service")
            ->update([
                'starting_price' => $request->input('artist_home_service_charge'),
                'maximum_price' => 0 ,
            ]);

            Session::put('artist_home_service_charge', $request->input('artist_home_service_charge'));

            //send sms start
            $message = "Dear " . Session::get('artist_name') .
            ",\nYou have changed your pricing, but your previous appointment's pricing will remain as before. Please check appointment details before you charge the customer.\n\nBest regards,\n@MehediShaj";
            $this->sendSMS(Session::get('artist_phone'), $message);
            //send sms close
        }

        return redirect('/artist_profile');
    }

	//gallery
    public function artist_gallery(){
        if (Session::has('artist_phone')&&Session::has('artist_password')) {

            $gallery = GalleryModel :: where ('artist_phone',Session::get('artist_phone'))->get();

            return view( 'Artist.artist_gallery' , compact('gallery') );
        } else {
            return redirect('/artist_login');
        }    
    }

    public function artist_add_gallery(Request $request){
        $request->validate(
        [
            'artist_add_gallery' => 'required|image',
        ]
        );

        if($request->hasfile('artist_add_gallery')){
            $img = $request->file('artist_add_gallery');
            $extension = $img->getClientOriginalExtension();
            $img_name = Session::get('artist_phone').time().'.'.$extension;
            $img->move('Artist Gallery/',$img_name);

            $gallery = new  GalleryModel();
            $gallery->artist_phone = Session::get('artist_phone');
            $gallery->img_name = $img_name;
            $gallery->save();
        }

        return redirect('/artist_gallery');
    }

	public function artist_delete_gallery(Request $request){
		GalleryModel::where('img_name', $request->input('img_name'))->delete();

        $destination = 'Artist Gallery/'.$request->input('img_name');
        File::delete($destination);

		return redirect('/artist_gallery');
    }

    //appointments
    public function artist_appointments(){
        if (Session::has('artist_phone')&&Session::has('artist_password')) {
            $appointments = AppointArtCusModel::join('appointment', 'appoint_art_cus.appointment_id', '=', 'appointment.appointment_id')
                ->join('payment', 'appoint_art_cus.appointment_id', '=', 'payment.appointment_id')
                ->join('customer', 'appoint_art_cus.customer_phone', '=', 'customer.phone')
                ->where('appoint_art_cus.artist_phone', Session::get('artist_phone'))
                ->where('appointment.status', '!=', 'unconfirmed')
                ->where(function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->where('appointment.status', '!=', 'cancelled-by-customer')
                            ->orWhere('payment.artist_compensation_status', '!=', 'not-required');
                    });
                })
                ->get();

            $upcoming_appointments = AppointArtCusModel::with(['appointment', 'payment', 'customer'])
            ->whereHas('appointment', function ($query) {
                $query->where('status', "confirmed")
                      ->whereDate('date', '>', now());
            })
            ->where('artist_phone', Session::get('artist_phone'))
            ->get();

            return view('Artist.artist_appointments', compact('appointments', 'upcoming_appointments') ); 
        } else {
            return redirect('/artist_login');
        }    
    }

    public function artist_cancel_appointment(Request $request) {
        $appointment = AppointArtCusModel::with(['appointment', 'payment', 'customer'])
            ->where('appointment_id', $request->input('cancel_appointment_id'))
            ->first();

        $appointment->appointment->status = "cancelled-by-artist";
        $appointment->payment->refund_status = "required" ;
            
        //send sms start
        $customer_message = "Appointment ( Appointment ID - ".$appointment->appointment->appointment_id.
        " ) on ".$appointment->appointment->date." at ".$appointment->appointment->time.
        " has been cancelled by the artist. Soon our admin will contact you to get transaction details and refund you with the booking money, thank for your coperation.\n\nBest regards,\n@MehediShaj";
        $this->sendSMS($appointment->customer->phone , $customer_message);
        //send sms close

        //send sms start
        $admin_message = "Appointment ( Appointment ID - ".$appointment->appointment->appointment_id.
        ", Status - Confirmed) has been cancelled by the customer. Please check the details and refund the customer(Name-".$appointment->customer->name.
        ", Phone-".$appointment->customer->phone." ).\n@MehediShaj";
        $this->sendSMS($this->admin_phone(), $admin_message);
        //send sms close

        $appointment->appointment->save();
        $appointment->payment->save();

        return redirect('/artist_appointments');
    }

    public function artist_help(Request $request) {
        $request->validate(
            [
                'help_msg'=>'required'
            ]
        );

        //send sms start
        $admin_message = $request->input('help_msg')." \n from Artist- ".
        Session::get('artist_name')."(".Session::get('artist_phone').")\n@MehediShaj";
        $this->sendSMS($this->admin_phone(), $admin_message);
        //send sms close
        return redirect('/artist_help');
    }

    //logout
    public function artist_logout(){
        if (Session::has('artist_phone')&&Session::has('artist_password')) {
            //Auth::logout();
            Session::flush();
            return redirect('/artist_login');
        } else {
           return redirect('/artist_login');
        }       
    }

}
