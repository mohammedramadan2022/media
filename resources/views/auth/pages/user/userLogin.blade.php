@extends('layouts.app')

@section('title', trans('back.login'))

@section('content')
    <section class="contact-us bg-light">
        <div class="container">
            <h3 class="text-center">Login To Join Us</h3>

            <div class="row justify-content-center">
                <div class="col-md-7 col-sm-10">
                    <div class="contact-form">
                        @include('includes.flash')
                        <form action="{{ route('front.user.submit.login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="inputEmail">Your Email Addrss</label>
                                <input type="email" name="email" value="{{old('email')}}" id="inputEmail" class="form-control @error('email') is-invalid @enderror" placeholder="Write Your Email">
                                @error('email')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Your Password </label>
                                <input type="password" name="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror" placeholder=" Write Your password">
                                @error('password')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-gradiant">login</button>
                            </div>

                            <div>
                                <b> <span>Don't Have An Account ?</span> <a href="{{ route('front.show.register') }}" class="main-color ">Sign Up</a></b>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
