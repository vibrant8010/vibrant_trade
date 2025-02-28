<!DOCTYPE html>
<html lang="en">
<head>
    <x-head/>
</head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- slider -->
        <div
          class="col-lg-2 col-xl-2 col-md-3 col-sm-3 registration-step-area h-100 shadow p-0 sticky-top"
        >
          <div class="card p-0 border-0">
            <div class="card-body p-0 border-0">
              <div
                id="carouselExampleIndicators"
                class="carousel slide w-100"
                data-bs-ride="carousel"
              >
                <div class="carousel-indicators">
                  <button
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true"
                    aria-label="Slide 1"
                  ></button>
                  <button
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide-to="1"
                    aria-label="Slide 2"
                  ></button>
                  {{-- <button
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide-to="2"
                    aria-label="Slide 3"
                  ></button> --}}
                </div>
                <div class="carousel-inner">
                  <div
                    class="carousel-item active vh-100"
                    style="background-color: #141416"
                  >
                  <div class="img-main-cotainer">
                    <img
                      src="{{ asset('images/CHENNAI.png') }}"
                      class="d-block w-100 vh-100 custom_object_contain"
                      alt="..."
                    />
                  </div>
                </div>
                  <div
                    class="carousel-item vh-100"
                    style="background-color: #ae2320"
                  >
                    <img
                    src="{{ asset('images/DELHI.png') }}"
                    class="d-block w-100 vh-100 custom_object_contain"
                      alt="..."
                    />
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-10 col-lg-10 col-sm-9 col-md-9 col-xl-9 px-xl-5 px-md-2 px-sm-1 px-1">
          <div class="row m-0">
            <div class="col-xl-12 col-lg-12 col-12 py-4 d-flex justify-content-between">
                <div class="backword-login">
                       <span><i class="fa-solid fa-arrow-left" style="color:#8b8b8bc2"></i></span>
                      <a href="{{ route('user.home') }}">Back To Website</a>
                </div>
                <a class="navbar-brand" href="#">
                  <img src="
                  {{ asset('images/company-logo.png') }}" width="150px" height="auto" />
                </a>
            </div>
          </div>
          <div class="progressbar-main text-center py-2">
            <!-- progressbar -->
            <ul id="progressBar" class="progressbar">
              <li class="progress-item active"></span>Create Account</li>
              <li class="progress-item">OTP Verification</li>
              <li class="progress-item">Gst No</li>
            </ul>
          </div>
          <div class="form-section mt-2">
            <!-- form-section -->
            <div id="signupForm" class="px-5 form-btn-box">
              <form
                id="registrationForm"
                action="{{ route('business.register.save') }}"
                method="POST"
                class="form-main row mt-3 registration-form"
              >
                <div class="step active" id="step1">
                  <div class="input-type-content">
                    <span for="name" class="input-field-lable">Name</span>
                    <input
                      type="text"
                      name="name"
                      class="progress-input-box"
                      id="name"
                      placeholder="Enter your name"
                      required
                    />
                    <span><i class="fa-solid fa-user input-icon"></i></span>
                  </div>
                  <div class="input-type-content">
                    <span for="phone" class="input-field-lable"
                      >Phone Number</span
                    >
                    <input
                      type="tel"
                      class="progress-input-box"
                      id="phone"
                      placeholder="Enter your phone number"
                      name="phone"
                      required
                    />
                    <span><i class="fa-solid fa-phone input-icon"></i></span>
                  </div>
                  <div class="input-type-content">
                    <span for="email" class="input-field-lable">Email</span>
                    <input
                      type="email"
                      name="email"
                      class="progress-input-box"
                      id="email"
                      placeholder="Enter your email"
                      required
                    />
                    <span><i class="fa-solid fa-envelope input-icon"></i></span>
                  </div>
                  <div class="input-type-content">
                    <span for="password" class="input-field-lable"
                      >Password</span
                    >
                    <input
                      type="password"
                      class="progress-input-box"
                      id="password"
                      name="password"
                      placeholder="Enter your password"
                      required
                    />
                    <span><i class="fa-solid fa-lock input-icon"></i></span>
                  </div>
                  <div class="d-grid col-12">
                    {{--
                    <button type="submit" class="custom-btn" id="sendOtp">
                      Send OTP
                    </button>
                    --}}
                    <div class="form-btn-box">
                      {{-- <p>
                        Have an account?
                        <a class="sign-link-btn" href="#">Sign In </a>now.
                      </p> --}}
                      <input
                        type="button"
                        class="custom-btn"
                        id="sendOtp"
                        value="Send OTP"
                      />
                    </div>
                  </div>
                </div>
              </form>
              <!-- Step 2 -->
              <form
                id="signupForm2"
                action="{{ route('user.otp.verify') }}"
                method="POST"
                class="form-main mt-3"
              >
                @csrf
                <div class="step active" id="step2">
                  <div class="input-type-content">
                    <span for="otp" class="input-field-lable">Enter OTP</span>
                    <input
                      type="text"
                      class="progress-input-box"
                      id="otp"
                      placeholder="Enter the OTP sent to your phone"
                      name="otp"
                    /><span><i class="fa-solid fa-key input-icon"></i></span>
                  </div>
                  <div class="d-grid col-12">
                    <button type="button" id="goBack" class="custom-btn">
                      Back
                    </button>
                    <div class="form-btn-box">
                      <p>
                        Have an account?
                        <a class="sign-link-btn" href="#">Sign In </a>now.
                      </p>
                      <input
                        class="custom-btn"
                        id="verifyOtp"
                        value="Verify OTP"
                      />
                    </div>
                  </div>
                </div>
              </form>
              <!-- Step 3 -->
              {{--
              <form
                id="signupForm3"
                action="/submit-signup"
                method="POST"
                class="form-main row mt-3"
              >
                <div class="step" id="step3">
                  <div class="input-type-content">
                    <span for="gst" class="input-field-lable">GST Number</span>
                    <input
                      type="text"
                      class="progress-input-box"
                      id="gst"
                      placeholder="Enter your GST number"
                      required
                    />
                    <span
                      ><i class="fa-solid fa-file-invoice-dollar input-icon"></i
                    ></span>
                  </div>
                  <div class="d-grid col-12">
                    <!-- <button type="button" class="custom-btn" id="submitSignup">
                Complete Signup
            </button> -->
                    <div class="form-btn-box">
                      <p>
                        Have an account?
                        <a class="sign-link-btn" href="#">Sign In </a>now.
                      </p>
                      <input
                        type="button"
                        class="custom-btn"
                        id="submitSignup"
                        value="Complete Signup"
                      />
                    </div>
                  </div>
                </div>
              </form>
              --}}
              <form
                id="signupForm3"
                action="/submit-signup"
                method="POST"
                class="form-main mt-3"
              >
                <div class="step active" id="step3">
                  <div class="input-type-content">
                    <label for="gst" class="input-field-lable"
                      >GST Number</label
                    >
                    <input
                      type="text"
                      class="progress-input-box"
                      id="gst"
                      placeholder="Enter your GST number"
                      required
                    />
                    <span
                      ><i class="fa-solid fa-file-invoice-dollar input-icon"></i
                    ></span>
                  </div>

                  <div class="input-type-content">
                    <button type="button" class="custom-btn" id="verifyGstBtn">
                      Verify GST
                    </button>
                    <div
                      id="verificationStatus"
                      class="verification-status"
                    ></div>
                  </div>

                  <div id="additionalInfo" style="display: none">
                    <div class="row">
                      <div class="col-6">
                        <div class="input-type-cont                      <label class="input-field-lable" for="tradeName"
                            >Trade Name</label
                          >
                          <input
                            type="text"
                            id="tradeName"
                            class="progress-input-box"
                            readonly
                          />
                          <span
                            ><i
                              class="fa-solid fa-arrow-trend-up input-icon"
                            ></i
                          ></span>
                        </div>
                        <div class="input-type-cont">
                         <label class="input-field-lable" for="pincode">Pincode</label>
                          <input
                            type="text"
                            id="pincode"
                            class="progress-input-box"
                            readonly
                          />
                          <span
                            ><i class="fa-solid fa-map-pin input-icon"></i
                          ></span>
                        </div>
                        <div class="input-type-cont">
                              <label class="input-field-lable" for="state"
                            >State</label
                          >
                          <input
                            type="text"
                            id="state"
                            class="progress-input-box"
                            readonly
                          />
                          <span
                            ><i class="fa-solid fa-city input-icon"></i
                          ></span>
                        </div>
                      </div>

                      <div class="col-6">
                        <div class="input-type-cont                      <label class="input-field-lable" for="city"
                            >City</label
                          >
                          <input
                            type="text"
                            id="city"
                            class="progress-input-box"
                            readonly
                          />
                          <span
                            ><i class="fa-solid fa-city input-icon"></i
                          ></span>
                        </div>

                        <div class="input-type-cont                      <label class="input-field-lable" for="status"
                            >Status</label
                          >
                          <input
                            type="text"
                            id="status"
                            class="progress-input-box"
                            readonly
                          />
                          <span
                            ><i
                              class="fa-regular fa-circle-check input-icon"
                            ></i
                          ></span>
                        </div>

                        <div class="input-type-cont                      <label
                            class="input-field-lable"
                            for="registrationDate"
                            >Registration Date</label
                          >
                          <input
                            type="text"
                            id="registrationDate"
                            class="progress-input-box"
                            readonly
                          />
                          <span
                            ><i
                              class="fa-solid fa-calendar-check input-icon"
                            ></i
                          ></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- bootsrap js -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      $(document).ready(function () {
        // Step 1: Send OTP
        $("#sendOtp").click(function () {
          alert("Step 1 completed! OTP has been sent.");
          //   $("#step1").removeClass("active");
          //   $("#step2").addClass("active");
          //   $("#progressBar li").eq(1).addClass("active");
          const formData = $("#registrationForm").serialize();
          //  console.log(formData);
          $.ajax({
            url: "{{ route('business.register.save') }}",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            data: formData,
            success: function (response) {
              alert(response.message);
              $("#step1").removeClass("active");
              $("#step2").addClass("active");
              $("#progressBar li").eq(1).addClass("active");
            },
            error: function (error) {
              alert("Error: " + error.responseJSON.message);
            },
          });
        });

        // Step 2: Verify OTP
        // $("#verifyOtp").click(function() {
        //     // const otps = $("#signupForm2").serialize();
        //     const otps = $("input[name='otp']").val();
        //     console.log("OTP Value: ", otps);
        //     if (!otps) {
        //         alert("Please enter the OTP!");
        //         return;
        //     }

        //     $.ajax({
        //         url: "{{ route('user.otp.verify') }}",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // CSRF token
        //         },
        //         method: "POST", // Specify the HTTP method
        //         data: { otp: otps}, // Pass the OTP as key-value
        //         success: function(response) {
        //             alert(response.message); // Display success message
        //             $("#step2").removeClass("active");
        //             $("#step3").addClass("active");
        //             $("#progressBar li").eq(2).addClass(
        //             "active"); // Activate the third step
        //         },
        //         error: function(error) {
        //             alert("Error: " + (error.responseJSON?.message ||
        //                 "OTP verification failed"));
        //         },
        //     });
        // });
        $("#verifyOtp").click(function () {
          const otps = $("#otp").val();

          console.log("OTP Value: ", otps); // Log OTP value to the console for debugging

          // Check if OTP is entered
          if (!otps || otps.trim() === "") {
            alert("Please enter the OTP!");
            return;
          }

          // Perform AJAX request
          $.ajax({
            url: "{{ route('user.otp.verify') }}", // Ensure the route is correct
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST", // Use POST method
            data: {
              otp: otps,
            }, // Send OTP as form data
            success: function (response) {
              console.log(otps);
              console.log(response);
              alert(response.message); // Show success message
              $("#step2").removeClass("active"); // Proceed to next step
              $("#step3").addClass("active");
              $("#progressBar li").eq(2).addClass("active"); // Activate next step in progress bar
            },
            error: function (error) {
              console.log(otps);
              // Show error message if something goes wrong
              // alert("Error: " + (error.responseJSON?.message ||
              //     "OTP verification failed"));
            },
          });
        });

        // });

        // Step 3: Complete Signup
        $("#submitSignup").click(function () {
          alert("Step 3 completed! Signup completed successfully.");
          $("#signupForm").submit(); // Submit the form or redirect as needed
        });

        // Submit form when Enter key is pressed
        // $("#signupForm input").keypress(function(event) {
        //     if (event.which == 13) {
        //         // Check if Enter key (key code 13) is pressed
        //         event.preventDefault(); // Prevent default Enter key action (like form submission)

        //         // Check if we're on Step 1, Step 2, or Step 3, and trigger the respective action
        //         if ($("#step1").hasClass("active")) {
        //             $("#sendOtp").click(); // Trigger Step 1
        //         } else if ($("#step2").hasClass("active")) {
        //             $("#verifyOtp").click(); // Trigger Step 2
        //         } else if ($("#step3").hasClass("active")) {
        //             $("#submitSignup").click(); // Trigger final submission
        //         }
        //     }
        // });

        // // On form submit (to handle final submission)
        // $("#signupForm").submit(function(event) {
        //     event.preventDefault(); // Prevent the default form submission

        //     // Here, you can handle the form submission like sending data via AJAX,
        //     // or you can redirect to another page.
        //     alert("Form submitted successfully!");

        //     // Example of sending data via AJAX (use the correct URL for your backend)

        //     $.ajax({
        //         url: "your_backend_url",
        //         method: "POST",
        //         data: $("#signupForm").serialize(),
        //         success: function(response) {
        //             alert("Form submitted successfully!");
        //             // Handle success, maybe redirect or show success message
        //         },
        //         error: function(error) {
        //             alert("There was an error submitting the form.");
        //             // Handle errors
        //         },
        //     });

        //     // Redirect or handle other logic
        //     window.location.href = "thank_you_page.html"; // Example redirect to a thank you page
        // });
        $("#goBack").click(function () {
          $("#step2").removeClass("active");
          $("#step1").addClass("active");
          $("#progressBar li").eq(1).removeClass("active");
        });
        $("#verifyGstBtn").click(function () {
          const gstNumber = $("#gst").val().trim();

          if (!gstNumber) {
            alert("Please enter a GST number.");
            return;
          }

          // Replace with your API key
          const apiKey = "773d5f467578e282dac1d0c338c447cb";
          const apiUrl = `http://sheet.gstincheck.co.in/check/${apiKey}/${gstNumber}`;

          $.ajax({
            url: apiUrl,
            method: "GET",
            success: function (response) {
              if (response.flag) {
                $("#verificationStatus")
                  .removeClass("status-failure")
                  .addClass("status-success")
                  .text("GST Verified Successfully!")
                  .show();

                // Populate fields with response data
                $("#tradeName").val(response.data.tradeNam);
                $("#pincode").val(response.data.pradr.addr.pncd);
                $("#state").val(response.data.pradr.addr.stcd);
                $("#city").val(response.data.pradr.addr.dst);
                $("#status").val(response.data.sts);
                $("#registrationDate").val(response.data.rgdt);

                $("#additionalInfo").show();
              } else {
                $("#verificationStatus")
                  .removeClass("status-success")
                  .addClass("status-failure")
                  .text("GST Verification Failed: " + response.message)
                  .show();

                $("#additionalInfo").hide();
              }
            },
            error: function (xhr, status, error) {
              console.error("Error Details:", xhr);
              $("#verificationStatus")
                .removeClass("status-success")
                .addClass("status-failure")
                .text("Error while verifying GST. Please try again.")
                .show();

              $("#additionalInfo").hide();
            },
          });
        });
      });
    </script>
  </body>
</html>
