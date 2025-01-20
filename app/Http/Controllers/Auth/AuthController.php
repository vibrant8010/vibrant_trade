<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Mail\OtpEmail;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;// Import the User model
use Illuminate\Support\Facades\Mail;  // Import the Mail Facade

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return view('Auth.register');
    }
    public function businessregister(Request $request)
    {
        return view('Auth.register');
    }
    // public function registerSave(Request $request)
    // {
    //      $request->validate([
    //         'email' => 'required|email|unique:users,email',
    //         'mobileno' => 'required|regex:/^[6-9][0-9]{9}$/',
    //         'name' => 'required|string|max:255',
    //         'password' => 'required|min:6',
    //     ], [
    //         'email.unique' => 'The email ID already exists.',
    //         'email.required' => 'The email field is required.',
    //         'mobileno.regex' => 'The mobile number must start with 6, 7, 8, or 9 and contain 10 digits.',
    //         'name.required' => 'The name field is required.',
    //         'password.required' => 'The password field is required.',
    //         'password.min' => 'The password must be at least 6 characters.',
    //     ]);


    //     $otp =rand(1000000,9999999);
    //     $expiry=time()+10*60;
    //        $user = new User();
    //        $user->name=$request->name;
    //        $user->email=$request->email;
    //       $user->mobileno=$request->mobileno;
    //       $user->otp=$otp;
    //       $user->otp_expiry=$expiry;
    //       $user->password=bcrypt($request->password);
    //        $user->save();
    //      Session::put('user_id',$user->id);
    //       Mail::to($request->email)->send(new OtpEmail($otp));
    //     //   return redirect()->route('user.email.validate')->with('success','Otp Has be sent on email');
    //        return response()->json('', 200, $headers);
    // }
    // public function otpValidate()
    // {
    //     if(!Session::has('user_id')){
    //         return abort(404);
    //     }
    //     return view('otp');
    // }

    // public function verifyOtp(Request $request)
    // {
    //     $otp=$request->otp;
    //     $user_id=Session::get('user_id');
    //     $user=User::find($user_id);
    //     if($user->otp==$otp && $user->otp_expiry>time() )
    //     {
    //         $user->is_otp_verified='1';
    //         $user->update();
    //         Session::forget('user_id');
    //         return redirect()->route('login')->with('success','Your account has been activated');
    //     }
    //         else
    //         {
    //             return redirect()->back()->with('error','Invalid otp');
    //         }
    // }

    //updated
    public function businessregisterSave(Request $request)
    {
        // print_r($request->all());die();
        $request->validate(
            [
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|regex:/^[6-9][0-9]{9}$/',
                'name' => 'required|string|max:255',
                'password' => 'required|min:6',
            ],
            // [
            //     'email.unique' => 'The email ID already exists.',
            //     'email.required' => 'The email field is required.',
            //     'mobileno.regex' => 'The mobile number must start with 6, 7, 8, or 9 and contain 10 digits.',
            //     'name.required' => 'The name field is required.',
            //     'password.required' => 'The password field is required.',
            //     'password.min' => 'The password must be at least 6 characters.',
            //     'password.confirmed' => 'The password confirmation does not match.',
            // ]
        );
        //
        // print_r($request->all());die();
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $expiry = Carbon::now()->addMinutes(10)->timestamp; // OTP expires in 10 minutes

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobileno = $request->phone;
        $user->role = 'business';
        $user->otp = $otp;
        $user->otp_expiry = $expiry;
        $user->password = Hash::make($request->password);
        $user->save();

        Session::put('user_id', $user->id);

        // Send OTP email as a queued job
        Mail::to($request->email)->send(new OtpEmail($otp));

        return response()->json(['message' => 'Registration successful. OTP sent.']);
    }

    public function otpValidate()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        return view('otp');
    }

    public function verifyOtp(Request $request)
    {

        $request->validate([
            'otp' => 'required|numeric',
        ], [
            'otp.required' => 'The OTP field is required.',
            'otp.numeric' => 'The OTP must be a number.',
        ]);

        $otp = $request->otp;
        $user_id = Session::get('user_id');

        $user = User::find($user_id);
//         DB::enableQueryLog();

// DB::table('users')
//     ->where('id', $user_id)
//     ->update(['is_otp_verified' => '1']);

// print_r(DB::getQueryLog());
//         die();
        if ($user && $user->otp == $otp && Carbon::now()->timestamp < $user->otp_expiry) {

            $user->is_otp_verified = 1;
            $user->update();
    //         DB::table('users')
    // ->where('id', $user_id)
    // ->update(['is_otp_verified' => 1]);

            // print_r($user_id);
            // print_r($user->id);
            // print_r($user->is_otp_verified);die();
              Session::forget('user_id');

    //         return redirect()->route('login')->with('success', 'Your account has been activated.');
            return response()->json(['message' => 'Your account has been activated.']);
        } else {
            return redirect()->back()->with('error', 'Invalid OTP or OTP expired.');
        }
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Get credentials from the request
        $credentials = $request->only('email', 'password');

        // Check if the user exists and is verified
        $user = User::where('email', $request->email)->first();

        if ($user && $user->is_otp_verified != 1) {
            // OTP not verified, prevent login
            return back()->with('error', 'Your OTP is not verified. Please verify your account to log in.');
        }

        // Attempt to log in
        if (Auth::attempt($credentials)) {
            // Authentication successful

            if (Auth::user()->role == 'business') {
                return redirect()->route('business.dashboard')->with('success', 'Login successful!');
            } elseif (Auth::user()->role == 'super_admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
            }
            return redirect()->route('user.home')->with('success', 'Login successful!');
        }

        // Authentication failed
        return back()->with('error', 'Invalid  password');
    }
    public function home()
    {
        return view('home'); // Home view file
    }

    public function logout()
    {
        Auth::logout();
        Session::flush(); // Clears all session data
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
    public function otpblade()
    {
        return view('otp');
    }
    public function resendOtp()
    {
        // Check if the user session exists
        if (!Session::has('user_id')) {
            return abort(404);
        }

        // Fetch the user from the session
        $user_id = Session::get('user_id');
        $user = User::find($user_id);

        // Generate a new OTP and set its expiry time
        $otp = rand(1000000, 9999999);
        $expiry = time() + 10 * 60;

        // Update the user's OTP and expiry time
        $user->otp = $otp;
        $user->otp_expiry = $expiry;
        $user->save();

        // Send the OTP to the user's email
        Mail::to($user->email)->send(new OtpEmail($otp));

        // Redirect back with a success message
        return back()->with('success', 'OTP has been resent to your email');
    }

    public function showForgotPasswordForm()
    {
        return view('Auth.forgot-password');
    }


    public function sendResetLink(Request $request)
    {
        // Validate email
        $request->validate(['email' => 'required|email']);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // If user exists
        if ($user && $user->is_otp_verified == 1) {
            // Generate a token for the password reset link
            $token = bin2hex(random_bytes(30));

            // Save token and expiry
            $user->password_reset_token = $token;
            $user->password_reset_expiry = time() + 60 * 30; // Store Unix timestamp (expires in 30 minutes)
            $user->save();

            // Send the reset link
            $resetLink = route('password.reset', ['token' => $token]);

            // Send the reset email
            Mail::to($user->email)->send(new PasswordResetMail($resetLink));

            // Return a success message
            return redirect()->route('password.success')->with('status', 'We have emailed you a password reset link!');
        }

        // If no user was found, return with an error
        return back()->withErrors(['email' => 'We could not find a user with that email address OR Your email is not verified right now.']);
    }


    public function showResetForm(Request $request, $token = null)
    {
        return view('Auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }





    public function resetPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        // Find the user by the reset token and verify it
        $user = User::where('email', $request->email)
            ->where('password_reset_token', $request->token)
            ->where('password_reset_expiry', '>', Carbon::now()) // Check if token is not expired
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This password reset link is invalid or expired.']);
        }

        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->password_reset_token = null; // Clear the token after resetting password
        $user->password_reset_expiry = null; // Clear the expiry
        $user->save();

        return redirect()->route('login')->with('status', 'Your password has been successfully reset.');
    }







}
