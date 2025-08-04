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
                            <p>{{ translate('Step 1 of 4: Account & Basic Info') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.step1') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="on_behalf">{{ translate('On Behalf') }}</label>
                                        @php $on_behalves = \App\Models\OnBehalf::all(); @endphp
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
                                        <select class="form-control aiz-selectpicker @error('gender') is-invalid @enderror" name="gender" required>
                                            <option value="1" @if(old('gender') == 1) selected @endif>{{translate('Male')}}</option>
                                            <option value="2" @if(old('gender') == 2) selected @endif>{{translate('Female')}}</option>
                                        </select>
                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="date_of_birth">{{ translate('Date Of Birth') }}</label>
                                        <input type="text" class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="{{ translate('Date Of Birth') }}" data-single="true" data-show-dropdown="true" data-max-date="{{ get_max_date() }}" autocomplete="off" value="{{ old('date_of_birth') }}" required>
                                        @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="marital_status">{{ translate('Marital Status') }}</label>
                                        <select class="form-control aiz-selectpicker @error('marital_status') is-invalid @enderror" name="marital_status" data-live-search="true" required>
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($marital_statuses as $marital_status)
                                                <option value="{{$marital_status->id}}" @if(old('marital_status') == $marital_status->id) selected @endif>{{$marital_status->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('marital_status')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="annual_salary_range">{{ translate('Annual Salary Range') }}</label>
                                        <select class="form-control aiz-selectpicker @error('annual_salary_range') is-invalid @enderror" name="annual_salary_range" data-live-search="true" required>
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($annual_salary_ranges as $range)
                                                <option value="{{$range->id}}" @if(old('annual_salary_range') == $range->id) selected @endif>{{$range->min_salary}} - {{$range->max_salary}}</option>
                                            @endforeach
                                        </select>
                                        @error('annual_salary_range')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="photo">{{translate('Profile Photo')}} <small>(800x800)</small></label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="photo" class="selected-files" value="{{ old('photo') }}">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                        @error('photo')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if(addon_activation('otp_system'))
                                <div>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <label class="form-label" for="email">{{ translate('Email / Phone') }}</label>
                                        <button class="btn btn-link p-0 opacity-50 text-reset fs-12" type="button" onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button>
                                    </div>
                                    <div class="form-group phone-form-group mb-1">
                                        <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                    </div>

                                    <input type="hidden" name="country_code" value="">

                                    <div class="form-group email-form-group mb-1 d-none">
                                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email"  autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                            <label class="form-label" for="email">{{ translate('Email address') }}</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="signinSrEmail" placeholder="{{ translate('Email Address') }}" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password">{{ translate('Password') }}</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********" aria-label="********" required>
                                        <small>{{ translate('Minimun 8 characters') }}</small>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password-confirm">{{ translate('Confirm password') }}</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="********" required>
                                        <small>{{ translate('Minimun 8 characters') }}</small>
                                    </div>
                                </div>
                            </div>

                            @if(addon_activation('referral_system'))
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="referral_code">{{ translate('Referral Code') }}</label>
                                        <input type="text" class="form-control{{ $errors->has('referral_code') ? ' is-invalid' : '' }}" value="{{ old('referral_code') }}" placeholder="{{  translate('Referral Code') }}" name="referral_code">
                                        @if ($errors->has('referral_code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('referral_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(get_setting('google_recaptcha_activation') == 1)
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                @error('g-recaptcha-response')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif

                            <div class="mb-3">
                                <label class="aiz-checkbox">
                                <input type="checkbox" name="checkbox_example_1" required>
                                    <span class=opacity-60>{{ translate('By signing up you agree to our')}}
                                        <a href="{{ env('APP_URL').'/terms-conditions' }}" target="_blank">{{ translate('terms and conditions')}}.</a>
                                    </span>
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                            @error('checkbox_example_1')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror

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

@section('script')
    @if(get_setting('google_recaptcha_activation') == 1)
        @include('partials.recaptcha')
    @endif
    @if(addon_activation('otp_system'))
        @include('partials.emailOrPhone')
    @endif
@endsection