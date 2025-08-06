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
                            <p>{{ translate('Step 2 of 5: Personal & Contact Details') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.step2.post') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="height">{{ translate('Height') }}</label>
                                        <select class="form-control aiz-selectpicker @error('height') is-invalid @enderror" name="height" id="height" data-live-search="true" required>
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($heights as $height)
                                                <option value="{{$height->id}}" @if(old('height') == $height->id) selected @endif>{{ $height->height }}</option>
                                            @endforeach
                                        </select>
                                        @error('height')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="marital_status">{{ translate('Marital Status') }}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            @foreach ($marital_statuses as $marital_status)
                                                <label class="btn btn-outline-secondary flex-grow-1 @if(old('marital_status') == $marital_status->id) active @endif">
                                                    <input type="radio" name="marital_status" value="{{$marital_status->id}}" @if(old('marital_status') == $marital_status->id) checked @endif autocomplete="off" required> {{ $marital_status->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('marital_status')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="religion">{{ translate('Religion') }}</label>
                                        <select class="form-control aiz-selectpicker @error('religion') is-invalid @enderror" name="religion" id="member_religion_id" data-live-search="true" required>
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($religions as $religion)
                                                <option value="{{$religion->id}}" @if(old('religion') == $religion->id) selected @endif>{{$religion->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('religion')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="caste">{{ translate('Caste') }}</label>
                                        <select class="form-control aiz-selectpicker @error('caste') is-invalid @enderror" name="caste" id="member_caste_id" data-live-search="true" required>
                                        </select>
                                        @error('caste')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="sub_caste">{{ translate('Sub Caste') }}</label>
                                        <input type="text" class="form-control @error('sub_caste') is-invalid @enderror" name="sub_caste" id="member_sub_caste_id" placeholder="{{ translate('Sub Caste') }}" value="{{ old('sub_caste') }}">
                                        @error('sub_caste')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="mother_tongue">{{ translate('Mother Tongue') }}</label>
                                        <select class="form-control aiz-selectpicker @error('mother_tongue') is-invalid @enderror" name="mother_tongue" data-live-search="true" required>
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($member_languages as $language)
                                                <option value="{{$language->id}}" @if(old('mother_tongue') == $language->id) selected @endif>{{$language->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('mother_tongue')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="manglik">{{ translate('Manglik') }}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('manglik') == 'yes') active @endif">
                                                <input type="radio" name="manglik" value="yes" @if(old('manglik') == 'yes') checked @endif autocomplete="off" required> {{ translate('Yes') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('manglik') == 'no') active @endif">
                                                <input type="radio" name="manglik" value="no" @if(old('manglik') == 'no') checked @endif autocomplete="off"> {{ translate('No') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('manglik') == 'notsure') active @endif">
                                                <input type="radio" name="manglik" value="notsure" @if(old('manglik') == 'notsure') checked @endif autocomplete="off"> {{ translate('Not Sure') }}
                                            </label>
                                        </div>
                                        @error('manglik')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="instagram_id">{{ translate('Instagram ID') }}</label>
                                        <input type="text" class="form-control @error('instagram_id') is-invalid @enderror" name="instagram_id" placeholder="{{ translate('Instagram ID') }}" value="{{ old('instagram_id') }}">
                                        @error('instagram_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="residence_country">{{ translate('Country') }}</label>
                                        <select class="form-control aiz-selectpicker @error('residence_country') is-invalid @enderror" name="residence_country" id="residence_country_id" data-live-search="true" required>
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}" @if(old('residence_country') == $country->id) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('residence_country')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="residence_state">{{ translate('State') }}</label>
                                        <select class="form-control aiz-selectpicker @error('residence_state') is-invalid @enderror" name="residence_state" id="residence_state_id" data-live-search="true" required>
                                        </select>
                                        @error('residence_state')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="residence_city">{{ translate('City') }}</label>
                                        <select class="form-control aiz-selectpicker @error('residence_city') is-invalid @enderror" name="residence_city" id="residence_city_id" data-live-search="true" required>
                                        </select>
                                        @error('residence_city')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group phone-form-group mb-3 d-none">
                                <label class="form-label">{{ translate('Mobile Number') }}</label>
                                <input type="tel" id="phone-code" class="form-control" placeholder="" name="phone" value="{{ old('phone') }}">
                            </div>

                            <input type="hidden" name="country_code" value="">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('register') }}" class="btn btn-secondary">{{ translate('Previous') }}</a>
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

@section('script')
    @include('partials.emailOrPhone')
    <script type="text/javascript">
        $(document).ready(function(){
            // Pre-select old values if they exist
            var old_country = '{{ old('residence_country') }}';
            var old_state = '{{ old('residence_state') }}';
            var old_city = '{{ old('residence_city') }}';
            var old_religion = '{{ old('religion') }}';
            var old_caste = '{{ old('caste') }}';
            
            if(old_country){
                $('#residence_country_id').val(old_country).change();
            }
            if(old_religion){
                $('#member_religion_id').val(old_religion).change();
            }
            
            // This initializes the dropdowns on page load.
            get_states_by_country_for_present_address();
            get_castes_by_religion_for_member();
        });

        // For Present address
        $('#residence_country_id').on('change', function() {
            get_states_by_country_for_present_address();
        });

        function get_states_by_country_for_present_address(){
            var present_country_id = $('#residence_country_id').val();
            var old_state = '{{ old('residence_state') }}';
            
            if(present_country_id){
                $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:present_country_id}, function(data){
                    $('#residence_state_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#residence_state_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_state){
                        $("#residence_state_id").val(old_state).change();
                    } else {
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                    
                    get_cities_by_state_for_present_address();
                });
            } else {
                $('#residence_state_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
                $('#residence_city_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
    
        $('#residence_state_id').on('change', function() {
            get_cities_by_state_for_present_address();
        });

        function get_cities_by_state_for_present_address(){
            var present_state_id = $('#residence_state_id').val();
            var old_city = '{{ old('residence_city') }}';
            
            if(present_state_id){
                $.post('{{ route('cities.get_cities_by_state') }}',{_token:'{{ csrf_token() }}', state_id:present_state_id}, function(data){
                    $('#residence_city_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#residence_city_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_city){
                        $("#residence_city_id").val(old_city).change();
                    } else {
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                });
            } else {
                $('#residence_city_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }

        // get castes and subcastes For member
        $('#member_religion_id').on('change', function() {
            get_castes_by_religion_for_member();
        });
        
        function get_castes_by_religion_for_member(){
    var member_religion_id = $('#member_religion_id').val();
    var old_caste = '{{ old('caste') }}';

    if(member_religion_id){
        $.post('{{ route('castes.get_caste_by_religion') }}',{_token:'{{ csrf_token() }}', religion_id:member_religion_id}, function(data){
            $('#member_caste_id').html(null);
            for (var i = 0; i < data.length; i++) {
                $('#member_caste_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
            }
            if(old_caste){
                $("#member_caste_id").val(old_caste).change();
            } else {
                 AIZ.plugins.bootstrapSelect('refresh');
            }
        });
    } else {
        $('#member_caste_id').html(null);
        AIZ.plugins.bootstrapSelect('refresh');
    }
}
    </script>
@endsection