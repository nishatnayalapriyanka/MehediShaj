<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


use App\Models\CustomerModel;
use App\Models\ArtistModel;
use App\Models\PackageModel;
use App\Models\GalleryModel;
use App\Models\AppointArtCusModel;
use App\Models\AppointmentModel;
use App\Models\PaymentModel;
use App\Models\FeedbackModel;

class CustomerController extends Controller
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
    public function customer_signup_phone_number_verify(Request $request){
        $request->validate(
            [
                'customer_signup_phone' => 'required|numeric|digits:11|regex:/^01/'
            ]
        );

        $customer = CustomerModel :: where ('phone',$request->input('customer_signup_phone'))->first();

        if($customer){
            return Redirect::back()->withErrors(['error' => 'Account already exists...']);
        }else{
            $customer_signup_otp = rand(1000,9999);
       
            //send sms start
            $message = "Your sign-up OTP is: ".$customer_signup_otp."\n@MehediShaj";
            $this->sendSMS($request->input('customer_signup_phone'), $message);
            //send sms close

            Session :: put('customer_signup_phone',$request->input('customer_signup_phone'));
            Session :: put('customer_signup_otp',$customer_signup_otp);

            return redirect('/customer_signup_otp_verify');
        }    
    }

    public function customer_signup_otp_verify(Request $request){
        $request->validate(
            [
                'customer_signup_otp' => 'required|numeric|digits:4'
            ]
        );

        if($request->input('customer_signup_otp')==Session::get('customer_signup_otp')){
            Session :: put('customer_signup_verified_phone',Session::get('customer_signup_phone'));
            Session :: put('customer_signup_verified_otp',Session::get('customer_signup_otp'));

            Session::forget('customer_signup_phone');
            Session::forget('customer_signup_otp');
                      
            return redirect('/customer_signup'); 
        }else{
            return Redirect::back()->withErrors(['error' => 'Wrong OTP, try again...']);
        }         
    }

    public function customer_signup(Request $request){
        $request->validate(
        [
            'customer_signup_profile_pic' => 'nullable|image',
            'customer_signup_name'=>'required',
            'customer_signup_verified_phone' => [
                'required',
                'numeric',
                'digits:11',
                'regex:/^01/',
                function ($attribute, $value, $fail) {
                    if ($value != Session::get('customer_signup_verified_phone')) {
                        $fail('Verified phone number can not be changed.');
                    }
                },
            ],
            'customer_signup_password'=>'required',
            'customer_signup_address'=>'required',
            'customer_signup_city'=>'required',
            'customer_signup_termsNconditions'=>'required'
        ]
        );       
     
        $customer = new  CustomerModel();
        $customer->name = $request->input('customer_signup_name');
        $customer->phone = Session::get('customer_signup_verified_phone');
        $customer->password = password_hash($request->input('customer_signup_password'), PASSWORD_BCRYPT);
        $customer->address = $request->input('customer_signup_address');
        $customer->city = $request->input('customer_signup_city');
        if($request->hasfile('customer_signup_profile_pic')){
            $img = $request->file('customer_signup_profile_pic');
            $extension = $img->getClientOriginalExtension();
            $img_name = Session::get('customer_signup_verified_phone').time().'.'.$extension;
            $img->move('Customer Profile Picture/',$img_name);
            $customer->profile_pic = $img_name;
        }
        else{
            $customer->profile_pic = null;
        }
        $customer->save();

        //send sms start
        $message = "Hello!!! " . $request->input('customer_signup_name') .
        ",\nThank you for signing up with us!We're excited to have you.\n\nBest regards,\n@MehediShaj";
        $this->sendSMS(Session::get('customer_signup_verified_phone'), $message);
        //send sms close

        Session::forget('customer_signup_verified_phone');
        Session::forget('customer_signup_verified_otp');

        return redirect('/customer_login');      
    }

    //login
    public function customer_login(Request $request){
        $request->validate(
        [
            'customer_login_phone'=>'required|numeric|digits:11|regex:/^01/',
            'customer_login_password'=>'required'
        ]
        );

        $customer = CustomerModel :: where ('phone',$request->input('customer_login_phone'))->first();

        if ($customer && password_verify($request->input('customer_login_password'), $customer->password)) {
            Session::put('customer_name', $customer->name);
            Session::put('customer_password', $customer->password);
            Session::put('customer_phone', $customer->phone);
            Session::put('customer_profile_pic', $customer->profile_pic);
            Session::put('customer_address', $customer->address);
            Session::put('customer_city', $customer->city);

            return redirect('/customer_home');
        } else {
            return Redirect::back()->withErrors(['error' => 'Invalid Log In, please try again...']);
        }
    }

    public function customer_forget_password_phone_number_verify(Request $request){
        $request->validate(
        [
            'customer_forget_password_phone'=>'required|numeric|digits:11|regex:/^01/'
        ]
        );

        $customer = CustomerModel :: where ('phone',$request->input('customer_forget_password_phone'))->first();

        if($customer){
            $customer_forget_password_otp = rand(1000,9999);
       
            //send sms start
            $message = "Your OTP for change password is: ".$customer_forget_password_otp."\n@MehediShaj";
            $this->sendSMS($request->input('customer_forget_password_phone'), $message);
            //send sms close

            Session :: put('customer_forget_password_phone',$request->input('customer_forget_password_phone'));
            Session :: put('customer_forget_password_otp',$customer_forget_password_otp);

            return redirect('/customer_forget_password_otp_verify');
             
        }else{
            return Redirect::back()->withErrors(['error' => 'Account does not exists...']);
        }
    }

    public function customer_forget_password_otp_verify(Request $request){
        $request->validate(
        [
            'customer_forget_password_otp'=>'required|numeric|digits:4'
        ]
        );   

        if(Session::get('customer_forget_password_otp') == $request->input('customer_forget_password_otp')){
            
            Session :: put('customer_forget_password_verified_phone',Session::get('customer_forget_password_phone'));
            Session :: put('customer_forget_password_verified_otp',Session::get('customer_forget_password_otp'));

            Session::forget('customer_forget_password_phone');
            Session::forget('customer_forget_password_otp');
                      
            return redirect('/customer_forget_password'); 

        }else{
            return Redirect::back()->withErrors(['error' => 'Wrong OTP, try again...']);
        }       
    }

    public function customer_forget_password(Request $request){
        $request->validate(
        [
            'customer_forget_password_new_password'=>'required'
        ]
        );

        $customer = CustomerModel :: where ('phone',Session::get('customer_forget_password_verified_phone'))->first();

        $customer->password = password_hash($request->input('customer_forget_password_new_password'), PASSWORD_BCRYPT);
        $customer->save();

        Session::forget('customer_forget_password_verified_phone');
        Session::forget('customer_forget_password_verified_otp');

        return redirect('/customer_login');
    }

    //home
    public function customer_home(){
        if (Session::has('customer_phone')&&Session::has('customer_password')) {
            $artists = ArtistModel::where('city', Session::get('customer_city'))
            ->with(['appointments_for_feedback.feedback'])
            ->get();

            return view('Customer.customer_home' ,compact('artists') );
        } else {
            return redirect('/customer_login');
        }  
    }


    //update profile
    public function customer_profile_update(Request $request){
        $request->validate(
        [
            'customer_profile_pic' => 'image',
            'customer_name'=>'required',
            'customer_address'=>'required',
            'customer_city'=>'required',
        ]
        );

        $customer = CustomerModel :: where ('phone',Session::get('customer_phone'))->first();
        $customer->name = $request->input('customer_name');
        $customer->address = $request->input('customer_address');
        $customer->city = $request->input('customer_city');
        if($request->hasfile('customer_profile_pic')){
            $destination = 'Customer Profile Picture/'.$customer->profile_pic;
            if(File::exists($destination) && $customer->profile_pic != null){
                File::delete($destination);
            }
            $img = $request->file('customer_profile_pic');
            $extension = $img->getClientOriginalExtension();
            $img_name = Session::get('customer_phone').time().'.'.$extension;
            $img->move('Customer Profile Picture/',$img_name);
            $customer->profile_pic = $img_name;
        }
        $customer->save();

        Session::put('customer_name', $customer->name);
        Session::put('customer_profile_pic', $customer->profile_pic);
        Session::put('customer_address', $customer->address);
        Session::put('customer_city', $customer->city);

        return redirect('/customer_profile');
    }

    public function customer_phone_update_phone_number_verify(Request $request){
        $request->validate(
        [
            'customer_phone_update_phone'=>'required|numeric|digits:11|regex:/^01/'
        ]
        );

        $customer = CustomerModel :: where ('phone',$request->input('customer_phone_update_phone'))->first();

        if($customer){
            return Redirect::back()->withErrors(['error' => 'Account already exists...']);            
        }else{
            $customer_phone_update_otp = rand(1000,9999);
       
            //send sms start
            $message = "Your OTP for change phone number is: ".$customer_phone_update_otp."\n@MehediShaj";
            $this->sendSMS($request->input('customer_phone_update_phone'), $message);
            //send sms close

            Session :: put('customer_phone_update_phone',$request->input('customer_phone_update_phone'));
            Session :: put('customer_phone_update_otp',$customer_phone_update_otp);

            return redirect('/customer_phone_update_otp_verify');     
        }
    }

    public function customer_phone_update_otp_verify(Request $request){
        $request->validate(
            [
                'customer_phone_update_otp' => 'required|numeric|digits:4'
            ]
        );

        if($request->input('customer_phone_update_otp')==Session::get('customer_phone_update_otp')){
            CustomerModel::where('phone', Session::get('customer_phone'))->update(['phone' =>  Session::get('customer_phone_update_phone')]);
            AppointArtCusModel::where('customer_phone', Session::get('customer_phone'))->update(['customer_phone' =>  Session::get('customer_phone_update_phone')]);
            
            Session::put('customer_phone', Session::get('customer_phone_update_phone'));

            Session::forget('customer_phone_update_phone');
            Session::forget('customer_phone_update_otp');
            
            return redirect('/customer_profile');
        }else{
            return Redirect::back()->withErrors(['error' => 'Wrong OTP, try again...']);
        }         
    }

    public function customer_password_update(Request $request){
        $request->validate(
        [
            'customer_update_password_current'=>'required',
            'customer_update_password_new'=>'required'
        ]
        );

        $customer = CustomerModel :: where ('phone',Session::get('customer_phone'))->first();

        if (password_verify($request->input('customer_update_password_current'), $customer->password)) {
            $customer->password = password_hash($request->input('customer_update_password_new'), PASSWORD_BCRYPT);
            $customer->save();
            
            Session::put('customer_password', $request->input('customer_update_password_new'));

            return redirect('/customer_profile');
        } else {
            return Redirect::back()->withErrors(['error' => 'Worng password, please try again...']);
        }
    }

    //booking
    public function customer_book_now(Request $request){
        Session :: put('booking_artist_phone',$request->input('booking_artist_phone'));
        return redirect('/customer_booking');  
    }

    public function get_customer_booking(){
        if (Session::has('booking_artist_phone')) {
            $artist = ArtistModel :: where ('phone',Session::get('booking_artist_phone'))->first();
            Session :: put('booking_artist',$artist->name);
            $package =  PackageModel :: where ('artist_phone',Session::get('booking_artist_phone'))->get();
            $gallery =  GalleryModel :: where ('artist_phone',Session::get('booking_artist_phone'))->get();
            $appoint_art_cus = AppointArtCusModel::where('artist_phone', Session::get('booking_artist_phone'))->get();
            if ($appoint_art_cus) {
                $appointment_id = $appoint_art_cus->pluck('appointment_id')->toArray();
                $feedback = FeedbackModel::whereIn('appointment_id', $appointment_id)
                ->get();
            }
            else{
                $feedback = null;
            }

            return view('Customer.customer_booking' ,compact('artist','package','gallery','feedback') );
        } else {
            return redirect('/customer_home');
        }  
    }

    public function customer_booking_artist_view_gallery(){
        if (Session::has('booking_artist_phone')&&Session::has('booking_artist')) {
            $gallery =  GalleryModel :: where ('artist_phone',Session::get('booking_artist_phone'))->get();
            return view('Customer.customer_booking_artist_view_gallery' ,compact('gallery') );
        } else {
            return redirect('/customer_home');
        }  
    }

    public function customer_booking_artist_view_ratings(){
        if (Session::has('booking_artist_phone')&&Session::has('booking_artist')) {
            $appoint_art_cus = AppointArtCusModel::where('artist_phone', Session::get('booking_artist_phone'))->get();
            $appointment_id = $appoint_art_cus->pluck('appointment_id')->toArray();
                $feedback = FeedbackModel::whereIn('appointment_id', $appointment_id)
                ->get();
            return view('Customer.customer_booking_artist_view_feedback' ,compact('feedback') );
        } else {
            return redirect('/customer_home');
        }  
    }

    public function post_customer_booking(Request $request){
        $appoint_art_cus = AppointArtCusModel::where('artist_phone', Session::get('booking_artist_phone'))->get();
        if ($appoint_art_cus) {
            $appointment_id = $appoint_art_cus->pluck('appointment_id')->toArray();
            $appointment = AppointmentModel::whereIn('appointment_id', $appointment_id)
            ->whereIn('status', ['confirmed', 'unconfirmed'])
            ->get();
        }

        $request->validate(
            [
                'booking_date' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($appointment) {
                        if ($appointment) {
                            foreach ($appointment as $appointment) {
                                if ($appointment->date == $value) {
                                    $fail('The selected date is already booked');
                                }
                            }
                        }
                    },
                ],
                'booking_time'=>'required',
                'num_of_customer_for_non_bridal_package' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:10',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value == 0 && $request->input('num_of_customer_for_bridal_package') == 0) {
                            $fail('Select at least one package');
                        }
                    },
                ],
                'num_of_customer_for_bridal_package' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:10',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value == 0 && $request->input('num_of_customer_for_non_bridal_package') == 0) {
                            $fail('Select at least one package');
                        }
                    },
                ],
                'delivery_area'=>'required'
            ]
        );

        Session :: put('booking_date',$request->input('booking_date'));
        Session :: put('booking_time',$request->input('booking_time'));
        Session :: put('num_of_customer_for_non_bridal_package',$request->input('num_of_customer_for_non_bridal_package'));
        Session :: put('num_of_customer_for_bridal_package',$request->input('num_of_customer_for_bridal_package'));
        Session :: put('delivery_area',$request->input('delivery_area'));

        $package =  PackageModel :: where ('artist_phone',Session::get('booking_artist_phone'))->get();   
        foreach($package as $package){
            if($package->category == "Non-Bridal"){
                $non_bridal_starting_price = (double) $package->starting_price;
                $non_bridal_max_price = (double) $package->maximum_price;
            }elseif($package->category == "Bridal"){
                $bridal_starting_price = (double) $package->starting_price;
                $bridal_max_price = (double) $package->maximum_price;
            }
            else{
                $home_service_charge = (double) $package->starting_price;
            }
        }

        $total_starting_price = ( $non_bridal_starting_price * $request->input('num_of_customer_for_non_bridal_package') )
        + ( $bridal_starting_price * $request->input('num_of_customer_for_bridal_package') )
        + $home_service_charge ;

        $total_max_price = ( $non_bridal_max_price * $request->input('num_of_customer_for_non_bridal_package') )
        + ( $bridal_max_price * $request->input('num_of_customer_for_bridal_package') )
        + $home_service_charge ;

        $booking_fee = 0.25 * $total_starting_price;

        $service_starting_charge = $total_starting_price - $booking_fee;
        $service_max_charge = $total_max_price - $booking_fee;

        $service_charge = "Tk " . $service_starting_charge . " to Tk " . $service_max_charge;


        Session :: put('booking_fee', $booking_fee);
        Session :: put('service_charge', $service_charge);

        return redirect('/customer_confirm_booking');
    }

    public function customer_confirm_booking(Request $request){
        $request->validate(
            [
                'booking_payment_method'=>'required',
                'booking_payment_transaction_id'=>'required'
            ]
        );

        do {
            $primary_key = Str::random(10);
            $existing_primary_key  = AppointArtCusModel::where('appointment_id', $primary_key)->exists();
        } while ($existing_primary_key);

        $appoint_art_cus = new  AppointArtCusModel();
        $appoint_art_cus->appointment_id = $primary_key;
        $appoint_art_cus->artist_phone = Session::get('booking_artist_phone');
        $appoint_art_cus->customer_phone = Session::get('customer_phone');
        $appoint_art_cus->save();

        $appointment = new  AppointmentModel();
        $appointment->appointment_id = $primary_key;
        $appointment->date = Session::get('booking_date');
        $appointment->time = Session::get('booking_time');
        $appointment->status = "unconfirmed";
        $appointment->num_of_clients_for_bridal_package = Session::get('num_of_customer_for_bridal_package');
        $appointment->num_of_clients_for_non_bridal_package = Session::get('num_of_customer_for_non_bridal_package');
        $appointment->delivery_area = Session::get('delivery_area');
        $appointment->save();

        $payment = new  PaymentModel();
        $payment->appointment_id = $primary_key;
        $payment->payment_transaction_id = $request->input('booking_payment_method')."-".$request->input('booking_payment_transaction_id');
        $payment->total_booking_fee = Session::get('booking_fee');
        $payment->total_service_charge = Session::get('service_charge');
        $payment->status = "not-checked";
        $payment->artist_compensation_status ="not-required";
        $payment->refund_status = "not-required";     
        $payment->save();

        Session::forget('booking_artist_phone');
        Session::forget('booking_artist');
        Session::forget('booking_date');
        Session::forget('booking_time');
        Session::forget('num_of_customer_for_non_bridal_package');
        Session::forget('num_of_customer_for_bridal_package');
        Session::forget('booking_fee');
        Session::forget('service_charge');
        Session::forget('delivery_area');

        //send sms start
        $admin_message = "You have a new appointment request(Appointment ID - ".$primary_key.
        ") Please check the details then confirm or cancel.\n@MehediShaj";
        $this->sendSMS($this->admin_phone(), $admin_message);
        //send sms close

        //send sms start
        $customer_message = "Dear " . Session::get('customer_name') . "," .
            "\nThank you for your booking request! Our admin team will now review the details provided. We'll get back to you shortly to confirm your booking." .
            "\n\nBest regards,\n@MehediShaj";
        $this->sendSMS(Session::get('customer_phone'), $customer_message);
        //send sms close

        return redirect('/customer_home'); 
    }

    //appointments
    public function customer_appointments(){
        if (Session::has('customer_phone')&&Session::has('customer_password')) {
            $appointments = AppointArtCusModel::with(['appointment', 'payment', 'artist','feedback'])
            ->where('customer_phone', Session::get('customer_phone'))
            ->get();

            $upcoming_appointments = AppointArtCusModel::with(['appointment', 'payment', 'artist'])
            ->whereHas('appointment', function ($query) {
                $query->whereIn('status', ['confirmed', 'unconfirmed'])
                      ->whereDate('date', '>=', now());
            })
            ->where('customer_phone', Session::get('customer_phone'))
            ->get();

            return view('Customer.customer_appointments', compact('appointments', 'upcoming_appointments') ); 
        } else {
            return redirect('/customer_login');
        }    
    }

    public function customer_cancel_appointment(Request $request) {
        $appointment = AppointArtCusModel::with(['appointment', 'payment', 'artist'])
            ->where('appointment_id', $request->input('cancel_appointment_id'))
            ->first();
        if($appointment->appointment->status == "confirmed"){
            $appointment->appointment->status = "cancelled-by-customer";
            $appointment->payment->artist_compensation_status = "required" ;
            
            //send sms start
            $artist_message = "Appointment ( Appointment ID - ".$appointment->appointment->appointment_id.
            " ) on ".$appointment->appointment->date." at ".$appointment->appointment->time.
            " has been cancelled by the customer. Soon our admin will contact you to get transaction details and compensate you with the booking money, thank for your coperation.\n\nBest regards,\n@MehediShaj";
            $this->sendSMS($appointment->artist->phone , $artist_message);
            //send sms close

            //send sms start
            $admin_message = "Appointment ( Appointment ID - ".$appointment->appointment->appointment_id.
            ", Status - Confirmed) has been cancelled by the customer. Please check the details and compensent the artist(Name-".$appointment->artist->name.
            ", Phone-".$appointment->artist->phone." ).\n@MehediShaj";
            $this->sendSMS($this->admin_phone(), $admin_message);
            //send sms close

            $appointment->appointment->save();
            $appointment->payment->save();

        }
        elseif($appointment->appointment->status == "unconfirmed"){
            $appointment->appointment->status = "cancelled-by-customer";

            //send sms start
            $admin_message = "Appointment ( Appointment ID - ".$appointment->appointment->appointment_id.
            ", Status - Unconfirmed) has been cancelled by the customer. Please check the details and update the payment status.\n@MehediShaj";
            $this->sendSMS($this->admin_phone(), $admin_message);
            //send sms close

            $appointment->appointment->save();
        }
        return redirect('/customer_appointments');
    }

    public function customer_upcoming_bill_export(Request $request) {
        $appointment = AppointArtCusModel::with(['appointment', 'payment', 'artist'])
            ->where('appointment_id', $request->input('export_bill_appointment_id'))
            ->first();

        //return view('Customer.customer_bill_export',compact('appointment'));
        $pdf = PDF::loadView('Customer.customer_bill_export', compact('appointment'));
        return $pdf->download('Bill.pdf');
    }

    public function customer_bill_export(Request $request) {
        $appointment = AppointArtCusModel::with(['appointment', 'payment', 'artist'])
            ->where('appointment_id', $request->input('export_bill_appointment_id'))
            ->first();

        $pdf = PDF::loadView('Customer.customer_bill_export', compact('appointment'));
        return $pdf->download('Bill.pdf');
    }

    //Feedback
    public function get_customer_feedback() {
        if (Session::has('feedback_appointment_id')) {
            $appointment = AppointArtCusModel::with(['appointment', 'payment', 'artist'])
            ->where('appointment_id', Session::get('feedback_appointment_id'))
            ->first();

            return view('Customer.customer_feedback',compact('appointment'));
        } else {
            return redirect('/customer_appointments');
        }   
    }

    public function post_customer_feedback(Request $request) {
        Session :: put('feedback_appointment_id', $request->input('feedback_appointment_id'));

        $appointment = AppointArtCusModel::with(['appointment', 'payment', 'artist'])
            ->where('appointment_id', Session::get('feedback_appointment_id'))
            ->first();

        return view('Customer.customer_feedback',compact('appointment')); 
    }

    public function customer_submit_feedback(Request $request) {
        $request->validate(
            [
                'ratings'=>'required'
            ]
        );

        $feedback = new  FeedbackModel();
        $feedback->appointment_id = Session::get('feedback_appointment_id');
        $feedback->ratings = $request->input('ratings');
        if($request->input('comment')){
            $feedback->comment = $request->input('comment');
        }
        else{
            $feedback->comment = null;
        }
        $feedback->save();

        Session::forget('feedback_appointment_id');
        return redirect('/customer_appointments');
    }

    //help
    public function customer_help(Request $request) {
        $request->validate(
            [
                'help_msg'=>'required'
            ]
        );

        //send sms start
        $admin_message = $request->input('help_msg')." \n from Customer- ".
        Session::get('customer_name')."(".Session::get('customer_phone').")\n@MehediShaj";
        $this->sendSMS($this->admin_phone(), $admin_message);
        //send sms close
        return redirect('/customer_help');
    }

    //logout
    public function customer_logout(){
        if (Session::has('customer_phone')&&Session::has('customer_password')) {
            //Auth::logout();
            Session::flush();
            return redirect('/customer_login');
        } else {
           return redirect('/customer_login');
        }       
    }

}
