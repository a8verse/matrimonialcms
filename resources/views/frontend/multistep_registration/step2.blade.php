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
                            <p>{{ translate('Step 2 of 4: Profile Details') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.step2.post') }}" method="POST">
                            @csrf
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
                                        <select class="form-control aiz-selectpicker @error('sub_caste') is-invalid @enderror" name="sub_caste" id="member_sub_caste_id" data-live-search="true">
                                        </select>
                                        @error('sub_caste')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="height">{{ translate('Height') }}</label>
                                        <input type="number" step="any" class="form-control @error('height') is-invalid @enderror" name="height" id="height" placeholder="{{ translate('Height') }}" value="{{ old('height') }}">
                                        @error('height')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="country">{{ translate('Country') }}</label>
                                        <select class="form-control aiz-selectpicker @error('country') is-invalid @enderror" name="country" id="present_country_id" data-live-search="true" required>
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}" @if(old('country') == $country->id) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="state">{{ translate('State') }}</label>
                                        <select class="form-control aiz-selectpicker @error('state') is-invalid @enderror" name="state" id="present_state_id" data-live-search="true" required>
                                        </select>
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="city">{{ translate('City') }}</label>
                                        <select class="form-control aiz-selectpicker @error('city') is-invalid @enderror" name="city" id="present_city_id" data-live-search="true" required>
                                        </select>
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="postal_code">{{ translate('Postal Code') }}</label>
                                        <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" id="postal_code" placeholder="{{ translate('Postal Code') }}" value="{{ old('postal_code') }}" required>
                                        @error('postal_code')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

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
    <script type="text/javascript">
        $(document).ready(function(){
            // Pre-select old values if they exist
            var old_country = '{{ old('country') }}';
            var old_state = '{{ old('state') }}';
            var old_city = '{{ old('city') }}';
            var old_religion = '{{ old('religion') }}';
            var old_caste = '{{ old('caste') }}';
            var old_sub_caste = '{{ old('sub_caste') }}';

            if(old_country){
                $('#present_country_id').val(old_country).change();
            }
            if(old_religion){
                $('#member_religion_id').val(old_religion).change();
            }
            
            get_states_by_country_for_present_address();
            get_castes_by_religion_for_member();
        });

        // For Present address
        $('#present_country_id').on('change', function() {
            get_states_by_country_for_present_address();
        });

        function get_states_by_country_for_present_address(){
            var present_country_id = $('#present_country_id').val();
            var old_state = '{{ old('state') }}';
            
            if(present_country_id){
                $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:present_country_id}, function(data){
                    $('#present_state_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#present_state_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_state){
                        $("#present_state_id").val(old_state).change();
                    } else {
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                    
                    get_cities_by_state_for_present_address();
                });
            } else {
                $('#present_state_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
                $('#present_city_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
    
        $('#present_state_id').on('change', function() {
            get_cities_by_state_for_present_address();
        });

        function get_cities_by_state_for_present_address(){
            var present_state_id = $('#present_state_id').val();
            var old_city = '{{ old('city') }}';
            
            if(present_state_id){
                $.post('{{ route('cities.get_cities_by_state') }}',{_token:'{{ csrf_token() }}', state_id:present_state_id}, function(data){
                    $('#present_city_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#present_city_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_city){
                        $("#present_city_id").val(old_city).change();
                    } else {
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                });
            } else {
                $('#present_city_id').html(null);
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
                   
                    get_sub_castes_by_caste_for_member();
                });
            } else {
                $('#member_caste_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
                $('#member_sub_caste_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }

        $('#member_caste_id').on('change', function() {
            get_sub_castes_by_caste_for_member();
        });
        
        function get_sub_castes_by_caste_for_member(){
            var member_caste_id = $('#member_caste_id').val();
            var old_sub_caste = '{{ old('sub_caste') }}';
            
            if(member_caste_id){
                $.post('{{ route('sub_castes.get_sub_castes_by_religion') }}',{_token:'{{ csrf_token() }}', caste_id:member_caste_id}, function(data){
                    $('#member_sub_caste_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#member_sub_caste_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_sub_caste){
                        $("#member_sub_caste_id").val(old_sub_caste).change();
                    } else {
                         AIZ.plugins.bootstrapSelect('refresh');
                    }
                });
            } else {
                $('#member_sub_caste_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
    </script>
@endsection