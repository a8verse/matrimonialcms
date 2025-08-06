@extends('frontend.layouts.app')

@section('content')
<div class="py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">

                        <div class="mb-5 text-center">
                            <h1 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h1>
                            <p>{{ translate('Step 1 of 5: Account & Basic Info') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.step1') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="on_behalf">{{ translate('On Behalf') }}</label>
                                        <select class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror" name="on_behalf" required>
                                            @foreach ($on_behalves as $on_behalf)
                                                <option value="{{$on_behalf->id}}" @if(old('on_behalf') == $on_behalf->id) selected @endif>{{$on_behalf->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('on_behalf')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="first_name">{{ translate('First Name') }}</label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="{{translate('First Name')}}" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="last_name">{{ translate('Last Name') }}</label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="{{ translate('Last Name') }}" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="gender">{{ translate('Gender') }}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('gender') == 1) active @endif">
                                                <input type="radio" name="gender" value="1" @if(old('gender') == 1) checked @endif autocomplete="off" required> {{ translate('Male') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('gender') == 2) active @endif">
                                                <input type="radio" name="gender" value="2" @if(old('gender') == 2) checked @endif autocomplete="off"> {{ translate('Female') }}
                                            </label>
                                        </div>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="looking_for">{{ translate('Looking For') }}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('looking_for') == 1) active @endif">
                                                <input type="radio" name="looking_for" value="1" @if(old('looking_for') == 1) checked @endif autocomplete="off" required> {{ translate('Male') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('looking_for') == 2) active @endif">
                                                <input type="radio" name="looking_for" value="2" @if(old('looking_for') == 2) checked @endif autocomplete="off"> {{ translate('Female') }}
                                            </label>
                                        </div>
                                        @error('looking_for')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="date_of_birth">{{ translate('Date Of Birth') }}</label>
                                        <input type="text" class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="{{ translate('Date Of Birth') }}" data-single="true" data-show-dropdown="true" data-max-date="{{ get_max_date() }}" autocomplete="off" value="{{ old('date_of_birth') }}" required>
                                        <small class="form-text text-muted">{{ translate('Your date of birth helps us find the perfect match.') }}</small>
                                        @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="email">{{ translate('Email address') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="signinSrEmail" placeholder="{{ translate('Email Address') }}" value="{{ old('email') }}" required>
                                        <small class="form-text text-muted">{{ translate('Remember to check your e-mail for matches.') }}</small>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password">{{ translate('Password') }}</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********" required>
                                        <small>{{ translate('Password must have between 8-20 characters') }}</small>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password-confirm">{{ translate('Confirm password') }}</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="********" required>
                                        <small>{{ translate('Password must have between 8-20 characters') }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-block btn-primary">{{ translate('Next Step') }}</button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted mb-0">{{ translate("Already have an account?") }}</p>
                                <a href="{{ route('login') }}">{{ translate('Login to your account') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection