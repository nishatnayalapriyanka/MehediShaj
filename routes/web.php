<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AdminController;

use App\Models\GalleryModel;
use App\Models\FeedbackModel;

//homepage
Route::get('/', function () {
    if (Session::has('customer_phone')&&Session::has('customer_password')) {
        return redirect('/customer_home');
    } elseif (Session::has('artist_phone')&&Session::has('artist_password')) {
        return redirect('/artist_dashboard');
    } else {
        $gallery = GalleryModel::take(10)->get();
        $feedback = FeedbackModel::take(10)->get();
        return view('homepage', compact('gallery', 'feedback'));
    }
});






//Customer
//customer sign up
Route::get('/customer_signup_termsNconditions', function () {
    return view('Customer.customer_signup_termsNconditions');
});

Route::get('/customer_signup_phone_number_verify', function () {
    return view('Customer.customer_signup_phone_number_verify');   
});
Route::post('/customer_signup_phone_number_verify', [CustomerController::class,'customer_signup_phone_number_verify']);


Route::get('/customer_signup_otp_verify', function () {
    if (Session::has('customer_signup_phone')&&Session::has('customer_signup_otp')) {
        return view('Customer.customer_signup_otp_verify');
    } else {
        return redirect('/customer_signup_phone_number_verify');
    }
});
Route::post('/customer_signup_otp_verify', [CustomerController::class,'customer_signup_otp_verify']);

Route::get('/customer_signup', function () {
    if (Session::has('customer_signup_verified_phone')&&Session::has('customer_signup_verified_otp')) {
        return view('Customer.customer_signup');
    } else {
        return redirect('/customer_signup_otp_verify');
    }
});
Route::post('/customer_signup', [CustomerController::class,'customer_signup']);

//customer login
Route::get('/customer_login', function () {
    return view('Customer.customer_login');
});
Route::post('/customer_login', [CustomerController::class,'customer_login']);


Route::get('/customer_forget_password_phone_number_verify', function () {
    return view('Customer.customer_forget_password_phone_number_verify');
});
Route::post('/customer_forget_password_phone_number_verify', [CustomerController::class,'customer_forget_password_phone_number_verify']);


Route::get('/customer_forget_password_otp_verify', function () {
    if (Session::has('customer_forget_password_phone')&&Session::has('customer_forget_password_otp')) {
        return view('Customer.customer_forget_password_otp_verify');
    } else {
       return redirect('/customer_forget_password_phone_number_verify');
    }
});
Route::post('/customer_forget_password_otp_verify', [CustomerController::class,'customer_forget_password_otp_verify']);


Route::get('/customer_forget_password', function () {
    if (Session::has('customer_forget_password_verified_phone')&&Session::has('customer_forget_password_verified_otp')) {
        return view('Customer.customer_forget_password');
    } else {
       return redirect('/customer_forget_password_otp_verify');
    }
});
Route::post('/customer_forget_password', [CustomerController::class,'customer_forget_password']);


//customer home
Route::get('/customer_home', [CustomerController::class,'customer_home']);


//customer update profile
Route::get('/customer_profile', function () {
    if (Session::has('customer_phone') && Session::has('customer_password')) {
        return view('Customer.customer_profile');
    } else {
        return redirect('/customer_login');
    }
});


Route::get('/customer_profile_update', function () {
    return redirect('/customer_profile');
});
Route::post('/customer_profile_update', [CustomerController::class,'customer_profile_update']);


Route::get('/customer_phone_update_phone_number_verify', function () {
    if (Session::has('customer_phone') && Session::has('customer_password')) {
        return view('Customer.customer_phone_update_phone_number_verify');
    } else {
        return redirect('/customer_login');
    }
});
Route::post('/customer_phone_update_phone_number_verify', [CustomerController::class,'customer_phone_update_phone_number_verify']);


Route::get('/customer_phone_update_otp_verify', function () {
    if (Session::has('customer_phone_update_phone')&&Session::has('customer_phone_update_otp')) {
        return view('Customer.customer_phone_update_otp_verify');
    } else {
        return redirect('/customer_phone_update_phone_number_verify');
    }
});
Route::post('/customer_phone_update_otp_verify', [CustomerController::class,'customer_phone_update_otp_verify']);


Route::get('/customer_password_update', function () {
    if (Session::has('customer_phone') && Session::has('customer_password')) {
        return view('Customer.customer_password_update');
    } else {
        return redirect('/customer_login');
    }
});
Route::post('/customer_password_update', [CustomerController::class,'customer_password_update']);


//customer booking
Route::get('/customer_book_now', function () {
    return redirect('/customer_home');
});
Route::post('/customer_book_now', [CustomerController::class,'customer_book_now']);


Route::get('/customer_booking', [CustomerController::class,'get_customer_booking']);
Route::post('/customer_booking', [CustomerController::class,'post_customer_booking']);


Route::get('/customer_booking_artist_view_gallery', [CustomerController::class,'customer_booking_artist_view_gallery']);

Route::get('/customer_booking_artist_view_ratings', [CustomerController::class,'customer_booking_artist_view_ratings']);


Route::get('/customer_confirm_booking', function () {
    if (Session::has('booking_date')&&Session::has('booking_time')
    &&Session::has('num_of_customer_for_non_bridal_package')&&Session::has('num_of_customer_for_bridal_package')
    &&Session::has('booking_fee')&&Session::has('service_charge')) {
        return view('Customer.customer_confirm_booking');
    } else {
       return redirect('/customer_home');
    }
});
Route::post('/customer_confirm_booking', [CustomerController::class,'customer_confirm_booking']);


//customer appointments
Route::get('/customer_appointments', [CustomerController::class,'customer_appointments']);


Route::get('/customer_cancel_appointment', function () {
    return redirect('/customer_appointments');
});
Route::post('/customer_cancel_appointment', [CustomerController::class,'customer_cancel_appointment']);


Route::get('/customer_upcoming_bill_export', function () {
    return redirect('/customer_appointments');
});
Route::post('/customer_upcoming_bill_export', [CustomerController::class,'customer_upcoming_bill_export']);


Route::get('/customer_bill_export', function () {
    return redirect('/customer_appointments');
});
Route::post('/customer_bill_export', [CustomerController::class,'customer_bill_export']);

//feedback
Route::get('/customer_feedback', [CustomerController::class,'get_customer_feedback']);
Route::post('/customer_feedback', [CustomerController::class,'post_customer_feedback']);


Route::get('/customer_submit_feedback', function () {
    return redirect('/customer_feedback');
});
Route::post('/customer_submit_feedback', [CustomerController::class,'customer_submit_feedback']);


//customer help
Route::get('/customer_help', function () {
    if (Session::has('customer_phone')&&Session::has('customer_password')) {
        return view('Customer.customer_help');
    } else {
       return redirect('/customer_login');
    }
});
Route::post('/customer_help', [CustomerController::class,'customer_help']);

//customer logout
Route::get('/customer_logout', [CustomerController::class,'customer_logout']);










//Artist
//artist sign up
Route::get('/artist_signup_termsNconditions', function () {
    return view('Artist.artist_signup_termsNconditions');
});


Route::get('/artist_signup_phone_number_verify', function () {
    return view('Artist.artist_signup_phone_number_verify');   
});
Route::post('/artist_signup_phone_number_verify', [ArtistController::class,'artist_signup_phone_number_verify']);


Route::get('/artist_signup_otp_verify', function () {
    if (Session::has('artist_signup_phone')&&Session::has('artist_signup_otp')) {
        return view('Artist.artist_signup_otp_verify');
    } else {
        return redirect('/artist_signup_phone_number_verify');
    }
});
Route::post('/artist_signup_otp_verify', [ArtistController::class,'artist_signup_otp_verify']);


Route::get('/artist_signup', function () {
    if (Session::has('artist_signup_verified_phone')&&Session::has('artist_signup_verified_otp')) {
        return view('Artist.artist_signup');
    } else {
        return redirect('/artist_signup_otp_verify');
    }
});
Route::post('/artist_signup', [ArtistController::class,'artist_signup']);


//artist login
Route::get('/artist_login', function () {
    return view('Artist.artist_login');
});
Route::post('/artist_login', [ArtistController::class,'artist_login']);


Route::get('/artist_forget_password_phone_number_verify', function () {
    return view('Artist.artist_forget_password_phone_number_verify');
});
Route::post('/artist_forget_password_phone_number_verify', [ArtistController::class,'artist_forget_password_phone_number_verify']);


Route::get('/artist_forget_password_otp_verify', function () {
    if (Session::has('artist_forget_password_phone')&&Session::has('artist_forget_password_otp')) {
        return view('Artist.artist_forget_password_otp_verify');
    } else {
       return redirect('/artist_forget_password_phone_number_verify');
    }
});
Route::post('/artist_forget_password_otp_verify', [ArtistController::class,'artist_forget_password_otp_verify']);


Route::get('/artist_forget_password', function () {
    if (Session::has('artist_forget_password_verified_phone')&&Session::has('artist_forget_password_verified_otp')) {
        return view('Artist.artist_forget_password');
    } else {
       return redirect('/artist_forget_password_otp_verify');
    }
});
Route::post('/artist_forget_password', [ArtistController::class,'artist_forget_password']);


//artist dashboard
Route::get('/artist_dashboard', [ArtistController::class,'artist_dashboard']);


Route::get('/artist_complete_session', function () {
    return redirect('/artist_dashboard');
});
Route::post('/artist_complete_session', [ArtistController::class,'artist_complete_session']);


Route::get('/artist_complete_session_otp_verify', function () {
    if (Session::has('artist_complete_session_appointment_id') && Session::has('artist_complete_session_otp')) {
        return view('Artist.artist_complete_session_otp_verify');
    } else {
        return redirect('/artist_dashboard');
    }
});
Route::post('/artist_complete_session_otp_verify', [ArtistController::class,'artist_complete_session_otp_verify']);


Route::get('/artist_complete_session_with_payment', function () {
    if (Session::has('artist_complete_session_appointment_id') && Session::has('artist_complete_session_verified_otp')) {
        return view('Artist.artist_complete_session_with_payment');
    } else {
        return redirect('/artist_complete_session_otp_verify');
    }
});
Route::post('/artist_complete_session_with_payment', [ArtistController::class,'artist_complete_session_with_payment']);


Route::get('/artist_completed_appointments_download_excel', [ArtistController::class,'artist_completed_appointments_download_excel']);


//artist update profile
Route::get('/artist_profile', function () {
    if (Session::has('artist_phone') && Session::has('artist_password')) {
        return view('Artist.artist_profile');
    } else {
        return redirect('/artist_login');
    }
});


Route::get('/artist_profile_update', function () {
    return redirect('/artist_profile');
});
Route::post('/artist_profile_update', [ArtistController::class,'artist_profile_update']);


Route::get('/artist_phone_update_phone_number_verify', function () {
    if (Session::has('artist_phone') && Session::has('artist_password')) {
        return view('Artist.artist_phone_update_phone_number_verify');
    } else {
        return redirect('/artist_login');
    }
});
Route::post('/artist_phone_update_phone_number_verify', [ArtistController::class,'artist_phone_update_phone_number_verify']);


Route::get('/artist_phone_update_otp_verify', function () {
    if (Session::has('artist_phone_update_phone')&&Session::has('artist_phone_update_otp')) {
        return view('Artist.artist_phone_update_otp_verify');
    } else {
        return redirect('/artist_phone_update_phone_number_verify');
    }
});
Route::post('/artist_phone_update_otp_verify', [ArtistController::class,'artist_phone_update_otp_verify']);


Route::get('/artist_password_update', function () {
    if (Session::has('artist_phone') && Session::has('artist_password')) {
        return view('Artist.artist_password_update');
    } else {
        return redirect('/artist_login');
    }
});
Route::post('/artist_password_update', [ArtistController::class,'artist_password_update']);


Route::get('/artist_non_bridal_package_update', function () {
    return redirect('/artist_profile');
});
Route::post('/artist_non_bridal_package_update', [ArtistController::class,'artist_non_bridal_package_update']);


Route::get('/artist_bridal_package_update', function () {
    return redirect('/artist_profile');
});
Route::post('/artist_bridal_package_update', [ArtistController::class,'artist_bridal_package_update']);


Route::get('/artist_home_service_charge_update', function () {
    return redirect('/artist_profile');
});
Route::post('/artist_home_service_charge_update', [ArtistController::class,'artist_home_service_charge_update']);


//artist gallery
Route::get('/artist_gallery', [ArtistController::class,'artist_gallery']);


Route::get('/artist_add_gallery', function () {
    return redirect('/artist_gallery');
});
Route::post('/artist_add_gallery', [ArtistController::class,'artist_add_gallery']);


Route::get('/artist_delete_gallery', function () {
    return redirect('/artist_gallery');
});
Route::post('/artist_delete_gallery', [ArtistController::class,'artist_delete_gallery']);


//artist appointments
Route::get('/artist_appointments', [ArtistController::class,'artist_appointments']);


Route::get('/artist_cancel_appointment', function () {
    return redirect('/artist_appointments');
});
Route::post('/artist_cancel_appointment', [ArtistController::class,'artist_cancel_appointment']);


//artist help
Route::get('/artist_help', function () {
    if (Session::has('artist_phone')&&Session::has('artist_password')) {
        return view('Artist.artist_help');
    } else {
       return redirect('/artist_login');
    }
});
Route::post('/artist_help', [ArtistController::class,'artist_help']);

//artist logout
Route::get('/artist_logout', [ArtistController::class,'artist_logout']);










//admin login
Route::get('/admin_login', function () {
    return view('Admin.admin_login');
});
Route::post('/admin_login', [AdminController::class,'admin_login']);


//admin dashboard
Route::get('/admin_dashboard', [AdminController::class,'admin_dashboard']);

Route::get('/admin_confirmed_appointments_download_excel', [AdminController::class,'admin_confirmed_appointments_download_excel']);


Route::get('/admin_unconfirmed_appointments_download_excel', [AdminController::class,'admin_unconfirmed_appointments_download_excel']);


Route::get('/admin_cancelled_appointments_download_excel', [AdminController::class,'admin_cancelled_appointments_download_excel']);


Route::get('/admin_completed_appointments_download_excel', [AdminController::class,'admin_completed_appointments_download_excel']);


Route::get('/admin_all_appointments_download_excel', [AdminController::class,'admin_all_appointments_download_excel']);
//admin manage appointments
Route::get('/admin_search_appointments', function () {
    return redirect('/admin_dashboard');
});
Route::post('/admin_search_appointments', [AdminController::class,'admin_search_appointments']);


Route::get('/admin_search_appointments_by_click', function () {
    return redirect('/admin_dashboard');
});
Route::post('/admin_search_appointments_by_click', [AdminController::class,'admin_search_appointments_by_click']);


Route::get('/admin_manage_appointment', [AdminController::class,'get_admin_manage_appointment']);Route::get('/admin_manage_appointment', [AdminController::class,'get_admin_manage_appointment']);
Route::post('/admin_manage_appointment', [AdminController::class,'post_admin_manage_appointment']);Route::get('/admin_manage_appointment', [AdminController::class,'get_admin_manage_appointment']);

//admin logout
Route::get('/admin_logout', [AdminController::class,'admin_logout']);
