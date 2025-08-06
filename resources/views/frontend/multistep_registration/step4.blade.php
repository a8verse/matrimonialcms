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
                            <p>{{ translate('Step 4 of 5: Lifestyle & Partner Preferences') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.step4.post') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="introduction">{{translate('Introduction')}}</label>
                                        <textarea name="introduction" class="form-control" placeholder="{{translate('Write a few words to get to know yourself better')}}" required>{{ old('introduction') }}</textarea>
                                        <small class="form-text text-muted">{{ translate('Character count: ') }}<span id="char_count">0</span>/500</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="diet_id">{{translate('Diet')}}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            @foreach ($diets as $diet)
                                                <label class="btn btn-outline-secondary flex-grow-1 @if(old('diet_id') == $diet->id) active @endif">
                                                    <input type="radio" name="diet_id" value="{{$diet->id}}" @if(old('diet_id') == $diet->id) checked @endif autocomplete="off" required> {{ $diet->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="disability_id">{{translate('Disability')}}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            @foreach ($disabilities as $disability)
                                                <label class="btn btn-outline-secondary flex-grow-1 @if(old('disability_id') == $disability->id) active @endif">
                                                    <input type="radio" name="disability_id" value="{{$disability->id}}" @if(old('disability_id') == $disability->id) checked @endif autocomplete="off"> {{ $disability->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="time_of_birth">{{translate('Time of Birth')}}</label>
                                        <input type="time" name="time_of_birth" value="{{ old('time_of_birth') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="place_of_birth">{{translate('Place of Birth')}}</label>
                                        <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" class="form-control" placeholder="{{translate('Place of Birth')}}">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">{{ translate('Partner Preferences') }}</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_min_age">{{translate('Age Range')}}</label>
                                        <div class="d-flex">
                                            <input type="number" name="partner_min_age" value="{{ old('partner_min_age') }}" class="form-control" placeholder="{{translate('Min Age')}}">
                                            <span class="mx-2 my-auto">-</span>
                                            <input type="number" name="partner_max_age" value="{{ old('partner_max_age') }}" class="form-control" placeholder="{{translate('Max Age')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_height_id">{{translate('Height Range')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_height_id" data-live-search="true">
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($heights as $height)
                                                <option value="{{$height->id}}" @if(old('partner_height_id') == $height->id) selected @endif>{{ $height->height }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_religion_id">{{translate('Religion')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_religion_id" data-live-search="true">
                                            <option value="">{{translate('Select One')}}</option>
                                            @foreach ($religions as $religion)
                                                <option value="{{$religion->id}}" @if(old('partner_religion_id') == $religion->id) selected @endif>{{$religion->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_marital_status_id">{{translate('Marital Status')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_marital_status_id" data-live-search="true">
                                            <option value="">{{ translate('Select One') }}</option>
                                            @foreach ($marital_statuses as $marital_status)
                                                <option value="{{$marital_status->id}}" @if(old('partner_marital_status_id') == $marital_status->id) selected @endif>{{$marital_status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_income_id">{{translate('Annual Income')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_income_id" data-live-search="true">
                                            <option value="">{{translate('Select One')}}</option>
                                            @foreach ($annual_salary_ranges as $range)
                                                <option value="{{$range->id}}" @if(old('partner_income_id') == $range->id) selected @endif>{{$range->min_salary}} - {{$range->max_salary}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_diet_id">{{translate('Diet')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_diet_id" data-live-search="true">
                                            <option value="">{{translate('Select One')}}</option>
                                            @foreach ($diets as $diet)
                                                <option value="{{$diet->id}}" @if(old('partner_diet_id') == $diet->id) selected @endif>{{$diet->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="partner_manglik">{{translate('Manglik')}}</label>
                                        <select class="form-control aiz-selectpicker" name="partner_manglik" data-live-search="true">
                                            <option value="">{{translate('Select One')}}</option>
                                            <option value="yes" @if(old('partner_manglik') == 'yes') selected @endif>{{translate('Yes')}}</option>
                                            <option value="no" @if(old('partner_manglik') == 'no') selected @endif>{{translate('No')}}</option>
                                            <option value="notsure" @if(old('partner_manglik') == 'notsure') selected @endif>{{translate('Not Sure')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="preferred_countries">{{translate('Preferred Countries')}}</label>
                                        <select class="form-control aiz-selectpicker" name="preferred_countries[]" id="preferred_countries_id" multiple data-live-search="true">
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}" @if(old('preferred_countries') && in_array($country->id, old('preferred_countries'))) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="preferred_states">{{translate('Preferred States')}}</label>
                                        <select class="form-control aiz-selectpicker" name="preferred_states[]" id="preferred_states_id" multiple data-live-search="true">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('register.step3') }}" class="btn btn-secondary">{{ translate('Previous') }}</a>
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
    $(document).ready(function() {
        // Character counter for introduction field
        $('textarea[name="introduction"]').on('keyup', function() {
            var charCount = $(this).val().length;
            $('#char_count').text(charCount);
        });
        
        // Auto-select country from step 2
        var residence_country_id = "{{ Session::get('registration_data')['residence_country'] ?? '' }}";
        if (residence_country_id) {
            $('#preferred_countries_id').val(residence_country_id);
            AIZ.plugins.bootstrapSelect('refresh');
            get_states_by_country();
        }
        
        $('#preferred_countries_id').on('change', function() {
            get_states_by_country();
        });
        
        function get_states_by_country() {
            var country_ids = $('#preferred_countries_id').val();
            if (country_ids.length > 0) {
                $.post('{{ route('states.get_state_by_country') }}', {
                    _token: '{{ csrf_token() }}',
                    country_ids: country_ids
                }, function(data) {
                    $('#preferred_states_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#preferred_states_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    AIZ.plugins.bootstrapSelect('refresh');
                });
            } else {
                $('#preferred_states_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
        
        // Populate and select old values
        var old_preferred_countries = @json(old('preferred_countries', []));
        if(old_preferred_countries.length > 0) {
            $('#preferred_countries_id').val(old_preferred_countries);
            get_states_by_country();
        }
        var old_preferred_states = @json(old('preferred_states', []));
        if(old_preferred_states.length > 0) {
            setTimeout(function() {
                $('#preferred_states_id').val(old_preferred_states);
                AIZ.plugins.bootstrapSelect('refresh');
            }, 500);
        }
    });
</script>
@endsection