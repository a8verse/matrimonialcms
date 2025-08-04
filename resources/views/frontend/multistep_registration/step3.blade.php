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
                            <p>{{ translate('Step 3 of 4: Lifestyle & Hobbies') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.step3.post') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="diet">{{translate('Diet')}}</label>
                                        <select class="form-control aiz-selectpicker" name="diet" required>
                                            <option value="">{{translate('Select One')}}</option>
                                            <option value="vegetarian" @if(old('diet') == 'vegetarian') selected @endif >{{translate('Vegetarian')}}</option>
                                            <option value="non_vegetarian" @if(old('diet') == 'non_vegetarian') selected @endif >{{translate('Non-Vegetarian')}}</option>
                                            <option value="vegan" @if(old('diet') == 'vegan') selected @endif >{{translate('Vegan')}}</option>
                                            <option value="other" @if(old('diet') == 'other') selected @endif >{{translate('Other')}}</option>
                                        </select>
                                        @error('diet')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="drink">{{translate('Drink')}}</label>
                                        <select class="form-control aiz-selectpicker" name="drink" required>
                                            <option value="">{{translate('Select One')}}</option>
                                            <option value="yes" @if(old('drink') == 'yes') selected @endif >{{translate('Yes')}}</option>
                                            <option value="no" @if(old('drink') == 'no') selected @endif >{{translate('No')}}</option>
                                            <option value="socially" @if(old('drink') == 'socially') selected @endif >{{translate('Socially')}}</option>
                                        </select>
                                        @error('drink')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="smoke">{{translate('Smoke')}}</label>
                                        <select class="form-control aiz-selectpicker" name="smoke" required>
                                            <option value="">{{translate('Select One')}}</option>
                                            <option value="yes" @if(old('smoke') == 'yes') selected @endif >{{translate('Yes')}}</option>
                                            <option value="no" @if(old('smoke') == 'no') selected @endif >{{translate('No')}}</option>
                                            <option value="socially" @if(old('smoke') == 'socially') selected @endif >{{translate('Socially')}}</option>
                                        </select>
                                        @error('smoke')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="living_with">{{translate('Living With')}}</label>
                                        <input type="text" name="living_with" value="{{ old('living_with') }}" placeholder="{{ translate('Living With') }}" class="form-control" required>
                                        @error('living_with')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="affection">{{translate('Affection')}}</label>
                                        <input type="text" name="affection" value="{{ old('affection') }}" class="form-control" placeholder="{{translate('Affection')}}">
                                        @error('affection')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="humor">{{translate('Humor')}}</label>
                                        <input type="text" name="humor" value="{{ old('humor') }}" placeholder="{{ translate('Humor') }}" class="form-control">
                                        @error('humor')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="political_views">{{translate('Political Views')}}</label>
                                        <input type="text" name="political_views" value="{{ old('political_views') }}" class="form-control" placeholder="{{translate('Political Views')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="religious_service">{{translate('Religious Service')}}</label>
                                        <input type="text" name="religious_service" value="{{ old('religious_service') }}" placeholder="{{ translate('Religious Service') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="hobbies">{{translate('Hobbies')}}</label>
                                        <input type="text" name="hobbies" value="{{ old('hobbies') }}" class="form-control" placeholder="{{translate('Hobbies')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="interests">{{translate('Interests')}}</label>
                                        <input type="text" name="interests" value="{{ old('interests') }}" placeholder="{{ translate('Interests') }}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="music">{{translate('Music')}}</label>
                                        <input type="text" name="music" value="{{ old('music') }}" class="form-control" placeholder="{{translate('Music')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="books">{{translate('Books')}}</label>
                                        <input type="text" name="books" value="{{ old('books') }}" placeholder="{{ translate('Books') }}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('register.step2') }}" class="btn btn-secondary">{{ translate('Previous') }}</a>
                                <button type="submit" class="btn btn-primary">{{ translate('Next Step') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection