@extends('layouts.custom-app')

@section('styles')
@endsection

@section('class')
    <div class="cover-image" data-image-src="{{ asset('assets/img/backgrounds/1.jpg') }}">
    @endsection

    @section('content')
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div
                        class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main py-45 justify-content-center mx-auto">
                        <div class="card-sigin mt-5 mt-md-0">

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- Demo content-->
                            <div class="main-card-signin d-md-flex bg-white">
                                <div class="wd-100p">
                                    <div class="main-signin-header">
                                        <h2>Forgot Password!</h2>
                                        <h4>Please Enter Your Email</h4>
                                        <form method="POST" action="{{ route('admin.resetPassword') }}"
                                            onsubmit="return validatePassword()">
                                            @csrf
                                            <div class="form-group text-start">
                                                <label>Email</label>
                                                <input class="form-control" name="email" placeholder="Enter your email"
                                                    type="email" required>
                                            </div>
                                            <div class="form-group text-start">
                                                <label>New Password</label>
                                                <input class="form-control" id="new_password" name="password"
                                                    placeholder="New Password" type="password" required
                                                    onchange="checkPasswordMatch()">
                                            </div>
                                            <div class="form-group text-start">
                                                <label>Confirm Password</label>
                                                <input class="form-control" id="confirm_password"
                                                    name="password_confirmation" placeholder="Confirm Password"
                                                    type="password" required onchange="checkPasswordMatch()">
                                                <small id="passwordError" class="text-danger"></small>
                                            </div>
                                            <button type="submit" class="btn ripple btn-primary btn-block">Reset
                                                Password</button>
                                        </form>
                                    </div>
                                    <div class="main-signup-footer mg-t-20 text-center">
                                        <p>Forget it, <a href="{{ route('admin.AdminLogin') }}"> Send me back</a> to the
                                            sign-in screen.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            function checkPasswordMatch() {
                let password = document.getElementById("new_password").value;
                let confirmPassword = document.getElementById("confirm_password").value;
                let errorMessage = document.getElementById("passwordError");

                if (password !== confirmPassword) {
                    errorMessage.innerText = "Passwords do not match!";
                    return false;
                } else {
                    errorMessage.innerText = "";
                    return true;
                }
            }

            function validatePassword() {
                let password = document.getElementById("new_password").value;
                let confirmPassword = document.getElementById("confirm_password").value;

                if (password !== confirmPassword) {
                    alert("Passwords do not match!");
                    return false; // Prevent form submission
                }
                return true;
            }
        </script>
    @endsection
