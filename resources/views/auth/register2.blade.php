<!DOCTYPE html>
<html lang="en">
<head>

    <x-head/>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <style>
        /* Styling for the toggle password icon */
.toggle-password {


    cursor: pointer;
    color: #6c757d;
}

.toggle-password:hover {
    color: #2f6b34;
}

        </style>
</head>
<body>
    <div class="form-outer">
        <section class="form-container">
            <div class="container mt-5">
                <div class="main-box">
                    <div class="row g-0 m-0">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="register-box1">
                                <h1 class="register-header">Registration Form</h1>
                                <form action="{{ route('register.save') }}" method="POST">
                                    @csrf
                                    @method('post')

                                    <!-- Name Field -->
                                    <div class="input-field">
                                        <span><i class="fa-solid fa-user input-field-icon"></i></span>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="input-type-box"
                                            placeholder="Enter your name"
                                            value="{{ old('name') }}"
                                            required>
                                              <br>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <br>

                                    <!-- Mobile Number Field -->
                                    <div class="input-field">
                                        <span><i class="fa-solid fa-phone input-field-icon"></i></span>
                                        <input
                                            type="text"
                                            id="mobile"
                                            name="mobileno"
                                            class="input-type-box"
                                            placeholder="Enter your mobile number"
                                            pattern="[6-9][0-9]{9}"
                                            value="{{ old('mobileno') }}"
                                            required>
                                              <br>
                                        @error('mobileno')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <br>

                                    <!-- Email Field -->
                                    <div class="input-field">
                                        <span><i class="fa-solid fa-envelope input-field-icon"></i></span>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="input-type-box"
                                            placeholder="Enter your email"
                                            value="{{ old('email') }}"
                                            required>
                                            <br>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <br>

                                  <!-- Password Field -->
                                        <div class="input-field">

                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                class="input-type-box"
                                                placeholder="Enter your password"
                                                minlength="6"
                                                required>
                                                  <br>
                                                <span id="toggle-password" class="toggle-password">
                                                    <i class="fa-solid fa-eye input-field-icon"></i> <!-- Default eye icon -->
                                                </span>
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <br>

                                        <div id="recaptcha-container"></div>
                                    <!-- Submit Button -->
                                    <div class="input-field mt-3">
                                        <button type="submit" value="submit" class="secondary-btn">Submit</button>
                                        <button type="button" id="send-otp" class="secondary-btn">Send OTP</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Welcome Section -->
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="register-box2">
                                <div class="register-site-image">
                                    <h1>Hello, Welcome!</h1>
                                    <p class="ac-txt">Already have an account?</p>
                                    <a class="login-link" href="{{ route('login') }}"> Login </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth.js"></script> --}}
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const togglePassword = document.getElementById("toggle-password");
            const passwordField = document.getElementById("password");

            togglePassword.addEventListener("click", function () {
                // Toggle password visibility
                const type = passwordField.type === "password" ? "text" : "password";
                passwordField.type = type;

                // Toggle eye icon
                const icon = togglePassword.querySelector("i");
                if (type === "text") {
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash"); // Eye closed (blinking) icon
                } else {
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye"); // Eye open icon
                }
            });
        });
        // const firebaseConfig = {
        //     apiKey: "AIzaSyBaNtFlNv2V_AqCKxlHnZhtSX4OnLWsVXA",
        //     authDomain: "vibrant-india-trade.firebaseapp.com",
        //     projectId: "vibrant-india-trade",
        //     storageBucket: "vibrant-india-trade.firebasestorage.app",
        //     messagingSenderId: "913157608147",
        //     appId: "1:913157608147:web:d8dd23b5632b93a13cba26",
        // };

        // firebase.initializeApp(firebaseConfig);
        // const auth = firebase.auth();

        // const recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        //     size: 'normal',
        // });
        // recaptchaVerifier.render();

        // document.getElementById('send-otp').addEventListener('click', () => {
        //     const phoneNumber = document.getElementById('mobile').value;
        //     auth.signInWithPhoneNumber(phoneNumber, recaptchaVerifier)
        //         .then((confirmationResult) => {
        //             window.confirmationResult = confirmationResult;
        //             document.getElementById('otp-form').style.display = 'none';
        //             document.getElementById('verify-otp-form').style.display = 'block';
        //         })
        //         .catch((error) => {
        //             console.error('SMS not sent:', error);
        //         });
        // });

        // document.getElementById('verify-otp').addEventListener('click', () => {
        //     const otp = document.getElementById('otp').value;
        //     confirmationResult.confirm(otp).then((result) => {
        //         const user = result.user;
        //         user.getIdToken().then((token) => {
        //             fetch('/verify-phone-otp', {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': "{{ csrf_token() }}",
        //                 },
        //                 body: JSON.stringify({ firebase_token: token }),
        //             })
        //                 .then((response) => response.json())
        //                 .then((data) => {
        //                     alert(data.message);
        //                     window.location.href = '/login';
        //                 })
        //                 .catch((error) => console.error(error));
        //         });
        //     }).catch((error) => {
        //         console.error('Invalid OTP:', error);
        //     });
        // });
    </script>
     <script>
        // Firebase Configuration
        const firebaseConfig = {
            apiKey: "AIzaSyBaNtFlNv2V_AqCKxlHnZhtSX4OnLWsVXA",
            authDomain: "vibrant-india-trade.firebaseapp.com",
            projectId: "vibrant-india-trade",
            storageBucket: "vibrant-india-trade.appspot.com",
            messagingSenderId: "913157608147",
            appId: "1:913157608147:web:d8dd23b5632b93a13cba26",
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        // Initialize Firebase Authentication
        const auth = firebase.auth();

        // Configure Invisible reCAPTCHA
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('send-otp', {
            size: 'invisible', // Invisible reCAPTCHA
            callback: function(response) {
                // Automatically executed after reCAPTCHA is solved
                console.log("reCAPTCHA solved:", response);
            },
            'expired-callback': function() {
                console.log("reCAPTCHA expired.");
            },
        });

        // Send OTP
        document.getElementById('send-otp').addEventListener('click', function () {
            const phoneNumber = document.getElementById('mobile').value;

            if (!phoneNumber) {
                alert("Please enter your mobile number.");
                return;
            }

            const appVerifier = window.recaptchaVerifier;

            auth.signInWithPhoneNumber(phoneNumber, appVerifier)
                .then((confirmationResult) => {
                    // OTP sent
                    window.confirmationResult = confirmationResult;
                    alert("OTP sent to your phone!");
                })
                .catch((error) => {
                    console.error("Error during OTP sending:", error);
                    alert("Failed to send OTP: " + error.message);
                });
        });

        // Verify OTP
        // document.getElementById('verify-otp').addEventListener('click', function () {
        //     const otp = document.getElementById('otp').value;

        //     if (!otp) {
        //         alert("Please enter the OTP.");
        //         return;
        //     }

        //     window.confirmationResult
        //         .confirm(otp)
        //         .then((result) => {
        //             const user = result.user;
        //             console.log("User signed in successfully:", user);
        //             alert("OTP verified successfully!");

        //             // Redirect to server for further processing
        //             document.getElementById('registration-form').submit();
        //         })
        //         .catch((error) => {
        //             console.error("Invalid OTP:", error);
        //             alert("Invalid OTP: " + error.message);
        //         });
        // });
    </script>

</body>
</html>
