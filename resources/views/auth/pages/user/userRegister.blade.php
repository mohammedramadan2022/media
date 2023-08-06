@extends('layouts.app')

@section('title', trans('back.login'))

@section('content')
    <section class="contact-us bg-light">
        <div class="container">
            <h3 class="text-center">Sign Up To Join Us</h3>

            <div class="row justify-content-center">
                <div class="col-md-7 col-sm-10">
                    <div class="contact-form">
                        @include('includes.flash')
                        <form action="{{ route('front.register') }}" method="POST">
                            @csrf
                            <div class="form-group ">
                                <label for="inputName">Write Your Name</label>
                                <input type="text" id="inputName" value="{{old('name')}}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Write Your Name">
                                @error('name')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Your Email Addrss</label>
                                <input type="email" id="inputEmail" value="{{old('email')}}" name="email" class="form-control @error('name') is-invalid @enderror" placeholder="Write Your Email">
                                @error('email')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Enter Password</label>
                                <input type="password" id="inputPassword" name="password" class="form-control @error('password') is-invalid @enderror" placeholder=" Write Your password">
                                @error('password')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputConfirmPassword">Confirm Password</label>
                                <input type="password" id="inputConfirmPassword" name="password_confirmation" class="form-control" placeholder="Confirm Your password">
                            </div>

                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-gradiant">Sign Up</button>
                            </div>

                            <div>
                                <b> <span>Have An Account ?</span> <a href="{{ route('front.sign-in') }}" class="main-color">Login</a></b>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
