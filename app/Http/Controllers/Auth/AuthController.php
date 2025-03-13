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
use Illuminate\Validation\ValidationException;

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

    public function registerSave(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
                'mobileno' => 'required|regex:/^[6-9][0-9]{9}$/',
                'name' => 'required|string|max:255',
            ], [
                'email.unique' => 'The email ID already exists.',
                'email.required' => 'The email field is required.',
                'mobileno.regex' => 'The mobile number must start with 6, 7, 8, or 9 and contain 10 digits.',
                'name.required' => 'The name field is required.',
            ]);

            // Generate OTP and expiry time
            $otp = rand(100000, 999999);
            $expiry = Carbon::now()->addMinutes(10)->timestamp;

            // Create and save new user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobileno = $request->mobileno;
            $user->role = 'user';
            $user->otp = $otp;
            $user->otp_expiry = $expiry;
            $user->save();

            // Store user ID in session
            Session::put('user_id', $user->id);

            // Send OTP email
            try {
                Mail::to($request->email)->send(new OtpEmail($otp));
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to send OTP email. Please try again.'], 500);
            }

            return response()->json(['success' => true, 'message' => 'Registration successful. OTP sent.']);

        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }

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

    //     public function verifyOtp(Request $request)
//     {

    //         $request->validate([
//             'otp' => 'required|numeric',
//         ], [
//             'otp.required' => 'The OTP field is required.',
//             'otp.numeric' => 'The OTP must be a number.',
//         ]);

    //         $otp = $request->otp;
//         $user_id = Session::get('user_id');

    //         $user = User::find($user_id);
//         //         DB::enableQueryLog();

    //         // DB::table('users')
// //     ->where('id', $user_id)
// //     ->update(['is_otp_verified' => '1']);

    //         // print_r(DB::getQueryLog());
// //         die();
//         if ($user && $user->otp == $otp && Carbon::now()->timestamp < $user->otp_expiry) {

    //             $user->is_otp_verified = 1;
//             $user->update();
//             //         DB::table('users')
//             // ->where('id', $user_id)
//             // ->update(['is_otp_verified' => 1]);

    //             // print_r($user_id);
//             // print_r($user->id);
//             // print_r($user->is_otp_verified);die();
//             Session::forget('user_id');

    //             //         return redirect()->route('login')->with('success', 'Your account has been activated.');
//             return response()->json(['message' => 'Your account has been activated.']);
//         } else {
//             return redirect()->back()->with('error', 'Invalid OTP or OTP expired.');
//         }
//     }
    public function verifyOtp(Request $request)
    {
        // Validate OTP input
        $request->validate([
            'otp' => 'required|numeric|digits:6',  // Ensure OTP is exactly 6 digits
        ]);

        // Get user ID from session
        $userId = Session::get('user_id');

        // If no user ID in session, return error
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        // Find the user from the database
        $user = User::find($userId);

        if (!$user) {
            return back()->with('error', 'User not found.');
        }
        $otp = $request->otp;
        // Check if OTP matches and is within expiry time
        if ($user && $user->otp == $otp && Carbon::now()->timestamp < $user->otp_expiry) {
            // OTP is valid, mark user as verified
            $user->is_otp_verified = 1;
            $user->save();

            // Clear the session
            Session::forget('user_id');

            // Proceed with login or redirect based on role
            Auth::login($user);

            if ($user->role == 'business') {
                return redirect()->route('business.dashboard')->with('success', 'Login successful!');
            } elseif ($user->role == 'super_admin') {
                // return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
                return redirect()->route('dashboard')->with('success', 'Login successful!');
            }

            return redirect()->route('user.home')->with('success', 'Login successful!');
        } else {
            // Invalid OTP or OTP expired
            return back()->with('error', 'Invalid OTP or OTP expired.');
        }
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    // public function login(Request $request)
    // {
    //     // Validate the email field
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     // Check if user exists
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return back()->with('error', 'User not found.');
    //     }

    //     $otp = rand(100000, 999999); // Generate a 6-digit OTP
    //     $expiry = Carbon::now()->addMinutes(10)->timestamp; // OTP expires in 10 minutes
    //     $user->otp = $otp;
    //     $user->otp_expiry = $expiry;
    //     $user->save();

    //     // Send OTP via email (make sure your OtpEmail mailable is correctly configured)
    //     Mail::to($request->email)->send(new OtpEmail($otp));  // Assuming OtpEmail is a Mailable class
    //     // Send OTP via SMS if the phone number exists
    //     if (!empty($user->phone)) {
    //         $smsMessage = "Your OTP is {$otp}. It will expire in 10 minutes.";
    //         $this->sendSmsViaEmail($user->phone, $smsMessage); // Use the email-to-SMS method
    //     }

    //     // Store the user ID in session for verification
    //     Session::put('user_id', $user->id);

    //     return response()->json(['message' => 'OTP sent to your email.']);
    // }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found please sign in .'], 404);
            }

            $otp = rand(100000, 999999);
            $expiry = Carbon::now()->addMinutes(10)->timestamp;
            $user->otp = $otp;
            $user->otp_expiry = $expiry;
            $user->save();
            try {
                Mail::to($request->email)->send(new OtpEmail($otp));
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to send OTP email. Please try again.'], 500);
            }

            // Send OTP via SMS (if phone exists)
            // if (!empty($user->phone)) {
            //     try {
            //         $smsMessage = "Your OTP is {$otp}. It will expire in 10 minutes.";
            //         $this->sendSmsViaEmail($user->phone, $smsMessage);
            //     } catch (\Exception $e) {
            //         return response()->json(['success' => false, 'message' => 'Failed to send OTP via SMS.'], 500);
            //     }
            // }

            // Store user ID in session
            Session::put('user_id', $user->id);

            return response()->json(['success' => true, 'message' => 'OTP sent to your email.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Invalid email format.'], 422);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }


    public function home()
    {
        $phoneNumber = '7990837846'; // User's phone number
        $message = 'Your OTP is 123456.';
        $response = $this->sendSmsViaEmail($phoneNumber, $message);
        return view('home'); // Home view file
    }
    public function sendSmsViaEmail($phoneNumber, $message)
    {
        // Replace with the carrier's email-to-SMS gateway domain
        $to = $phoneNumber . '@vtext.com'; // For Verizon. Replace for other carriers.

        Mail::raw($message, function ($mail) use ($to) {
            $mail->to($to)
                ->subject('SMS Notification');
            \Log::info("Email sent to: $to");
        });

        return 'SMS Sent!';
    }
    public function logout()
    {
        Auth::logout();
        Session::flush(); // Clears all session data
        return redirect()->route('user.home')->with('success', 'Logged out successfully');
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
