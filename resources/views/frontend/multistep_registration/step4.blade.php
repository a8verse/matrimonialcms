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
                            <p>{{ translate('Step 4 of 4: Partner Expectations & Finalization') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.finalize') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="general">{{translate('General Requirement')}}</label>
                                        <input type="text" name="general" value="{{ old('general') }}" class="form-control" placeholder="{{translate('General')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="residence_country_id">{{translate('Residence Country')}}</label>
                                        <select class="form-control aiz-selectpicker" name="residence_country_id" id="partner_country_id" data-live-search="true" required>
                                            <option value="">{{translate('Select One')}}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}" @if(old('residence_country_id') == $country->id) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_height">{{translate('Min Height')}}</label>
                                        <input type="number" step="any" name="partner_height" value="{{ old('partner_height') }}" placeholder="{{ translate('Height') }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_marital_status">{{translate('Marital Status')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_marital_status" data-live-search="true" required>
                                            <option value="">{{ translate('Choose One') }}</option>
                                            @foreach ($marital_statuses as $marital_status)
                                            <option value="{{$marital_status->id}}" @if(old('partner_marital_status') == $marital_status->id) selected @endif>{{$marital_status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_religion_id">{{translate('Religion')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_religion_id" id="partner_religion_id" data-live-search="true" required>
                                            <option value="">{{translate('Select One')}}</option>
                                            @foreach ($religions as $religion)
                                                <option value="{{$religion->id}}" @if(old('partner_religion_id') == $religion->id) selected @endif>{{ $religion->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_caste_id">{{translate('Caste')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_caste_id" id="partner_caste_id" data-live-search="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_sub_caste_id">{{translate('Sub Caste')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_sub_caste_id" id="partner_sub_caste_id" data-live-search="true">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="introduction">{{translate('Introduction')}}</label>
                                        <textarea name="introduction" class="form-control" placeholder="{{translate('Introduction')}}" required>{{ old('introduction') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="instagram_id">{{translate('Instagram ID')}}</label>
                                        <input type="text" name="instagram_id" value="{{ old('instagram_id') }}" placeholder="{{ translate('Instagram ID') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            

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

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('register.step3') }}" class="btn btn-secondary">{{ translate('Previous') }}</a>
                                <button type="submit" class="btn btn-primary">{{ translate('Finalize & Register') }}</button>
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
    <script type="text/javascript">
        $(document).ready(function(){
            // Pre-select old values if they exist
            var old_religion = '{{ old('partner_religion_id') }}';
            var old_caste = '{{ old('partner_caste_id') }}';
            var old_sub_caste = '{{ old('partner_sub_caste_id') }}';
            var old_country = '{{ old('residence_country_id') }}';

            if(old_religion){
                $('#partner_religion_id').val(old_religion).change();
            }
            if(old_country){
                $('#partner_country_id').val(old_country).change();
            }
        });
        
        // get castes and subcastes For partner
        $('#partner_religion_id').on('change', function() {
            get_castes_by_religion_for_partner();
        });

        function get_castes_by_religion_for_partner(){
            var partner_religion_id = $('#partner_religion_id').val();
            var old_caste = '{{ old('partner_caste_id') }}';
            
            if(partner_religion_id){
                $.post('{{ route('castes.get_caste_by_religion') }}',{_token:'{{ csrf_token() }}', religion_id:partner_religion_id}, function(data){
                    $('#partner_caste_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#partner_caste_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_caste){
                        $("#partner_caste_id").val(old_caste).change();
                    } else {
                         AIZ.plugins.bootstrapSelect('refresh');
                    }
                   
                    get_sub_castes_by_caste_for_partner();
                });
            } else {
                $('#partner_caste_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
                $('#partner_sub_caste_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
    
        $('#partner_caste_id').on('change', function() {
            get_sub_castes_by_caste_for_partner();
        });
        
        function get_sub_castes_by_caste_for_partner(){
            var partner_caste_id = $('#partner_caste_id').val();
            var old_sub_caste = '{{ old('partner_sub_caste_id') }}';
            
            if(partner_caste_id){
                $.post('{{ route('sub_castes.get_sub_castes_by_religion') }}',{_token:'{{ csrf_token() }}', caste_id:partner_caste_id}, function(data){
                    $('#partner_sub_caste_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#partner_sub_caste_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_sub_caste){
                        $("#partner_sub_caste_id").val(old_sub_caste).change();
                    } else {
                         AIZ.plugins.bootstrapSelect('refresh');
                    }
                });
            } else {
                $('#partner_sub_caste_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
    </script>
@endsection