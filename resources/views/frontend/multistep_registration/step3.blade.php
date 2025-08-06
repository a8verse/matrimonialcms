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
                            <p>{{ translate('Step 3 of 5: Professional & Family Background') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.step3.post') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="education_level_id">{{translate('Education Level')}}</label>
                                        <select class="form-control aiz-selectpicker" name="education_level_id" data-live-search="true" required>
                                            <option value="">{{translate('Select One')}}</option>
                                            @foreach ($education_levels as $level)
                                                <option value="{{$level->id}}" @if(old('education_level_id') == $level->id) selected @endif>{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="occupation_status">{{translate('Occupation')}}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons" id="occupation_status">
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('occupation_status') == 'govt_employee') active @endif">
                                                <input type="radio" name="occupation_status" value="govt_employee" @if(old('occupation_status') == 'govt_employee') checked @endif autocomplete="off" required> {{ translate('Govt. Employee') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('occupation_status') == 'private') active @endif">
                                                <input type="radio" name="occupation_status" value="private" @if(old('occupation_status') == 'private') checked @endif autocomplete="off"> {{ translate('Private Sector') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('occupation_status') == 'business') active @endif">
                                                <input type="radio" name="occupation_status" value="business" @if(old('occupation_status') == 'business') checked @endif autocomplete="off"> {{ translate('Business') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('occupation_status') == 'defense') active @endif">
                                                <input type="radio" name="occupation_status" value="defense" @if(old('occupation_status') == 'defense') checked @endif autocomplete="off"> {{ translate('Defense') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('occupation_status') == 'self_employed') active @endif">
                                                <input type="radio" name="occupation_status" value="self_employed" @if(old('occupation_status') == 'self_employed') checked @endif autocomplete="off"> {{ translate('Self-Employed') }}
                                            </label>
                                            <label class="btn btn-outline-secondary flex-grow-1 @if(old('occupation_status') == 'not_working') active @endif">
                                                <input type="radio" name="occupation_status" value="not_working" @if(old('occupation_status') == 'not_working') checked @endif autocomplete="off"> {{ translate('Not Working') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="working_details" class="d-none">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="occupation_id">{{translate('List of Occupations')}}</label>
                                            <select class="form-control aiz-selectpicker" name="occupation_id" id="occupation_id" data-live-search="true">
                                                <option value="">{{translate('Select One')}}</option>
                                                @foreach ($occupations as $occupation)
                                                    <option value="{{$occupation->id}}" @if(old('occupation_id') == $occupation->id) selected @endif>{{$occupation->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="annual_income_id">{{translate('Annual Income')}}</label>
                                            <select class="form-control aiz-selectpicker" name="annual_income_id" data-live-search="true">
                                                <option value="">{{translate('Select One')}}</option>
                                                @foreach ($annual_salary_ranges as $range)
                                                    <option value="{{$range->id}}" @if(old('annual_income_id') == $range->id) selected @endif>{{$range->min_salary}} - {{$range->max_salary}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="work_country_id">{{ translate('Working Country') }}</label>
                                            <select class="form-control aiz-selectpicker" name="work_country_id" id="work_country_id" data-live-search="true">
                                                <option value="">{{ translate('Select One') }}</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}" @if(old('work_country_id') == $country->id) selected @endif>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="work_state_id">{{ translate('Working State') }}</label>
                                            <select class="form-control aiz-selectpicker" name="work_state_id" id="work_state_id" data-live-search="true">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="not_working_details" class="d-none">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="current_country_id">{{ translate('Current Country') }}</label>
                                            <select class="form-control aiz-selectpicker" name="current_country_id" id="current_country_id" data-live-search="true">
                                                <option value="">{{ translate('Select One') }}</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}" @if(old('current_country_id') == $country->id) selected @endif>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="current_state_id">{{ translate('Current State') }}</label>
                                            <select class="form-control aiz-selectpicker" name="current_state_id" id="current_state_id" data-live-search="true">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="father_name">{{translate('Father\'s Name')}}</label>
                                        <input type="text" name="father_name" value="{{ old('father_name') }}" class="form-control" placeholder="{{translate('Father\'s Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="father_occupation">{{translate('Father\'s Occupation')}}</label>
                                        <input type="text" name="father_occupation" value="{{ old('father_occupation') }}" class="form-control" placeholder="{{translate('Father\'s Occupation')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="mother_name">{{translate('Mother\'s Name')}}</label>
                                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" class="form-control" placeholder="{{translate('Mother\'s Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="mother_occupation">{{translate('Mother\'s Occupation')}}</label>
                                        <input type="text" name="mother_occupation" value="{{ old('mother_occupation') }}" class="form-control" placeholder="{{translate('Mother\'s Occupation')}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="no_of_siblings">{{translate('Number of Siblings')}}</label>
                                        <input type="number" name="no_of_siblings" value="{{ old('no_of_siblings') }}" class="form-control" placeholder="{{translate('Number of Siblings')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="family_status_id">{{translate('Family Status')}}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            @foreach ($family_statuses as $status)
                                                <label class="btn btn-outline-secondary flex-grow-1 @if(old('family_status_id') == $status->id) active @endif">
                                                    <input type="radio" name="family_status_id" value="{{$status->id}}" @if(old('family_status_id') == $status->id) checked @endif autocomplete="off" required> {{ $status->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="family_values_id">{{translate('Family Values')}}</label>
                                        <div class="d-flex btn-group-toggle" data-toggle="buttons">
                                            @foreach ($family_values as $value)
                                                <label class="btn btn-outline-secondary flex-grow-1 @if(old('family_values_id') == $value->id) active @endif">
                                                    <input type="radio" name="family_values_id" value="{{$value->id}}" @if(old('family_values_id') == $value->id) checked @endif autocomplete="off" required> {{ $value->name }}
                                                </label>
                                            @endforeach
                                        </div>
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

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        // Show/hide conditional fields based on old value
        var occupationStatus = $('input[name="occupation_status"]:checked').val();
        handleOccupationStatus(occupationStatus);
        
        // Handle occupation status change
        $('input[name="occupation_status"]').on('change', function() {
            var selectedStatus = $(this).val();
            handleOccupationStatus(selectedStatus);
        });

        function handleOccupationStatus(status) {
            if (status && status !== 'not_working') {
                $('#working_details').removeClass('d-none');
                $('#not_working_details').addClass('d-none');
            } else if (status && status === 'not_working') {
                $('#not_working_details').removeClass('d-none');
                $('#working_details').addClass('d-none');
            } else {
                $('#working_details').addClass('d-none');
                $('#not_working_details').addClass('d-none');
            }
        }
        
        // Pre-select old values for working address
        var old_work_country = '{{ old('work_country_id') }}';
        var old_work_state = '{{ old('work_state_id') }}';
        if(old_work_country){
            $('#work_country_id').val(old_work_country).change();
        }
        $('#work_country_id').on('change', function() {
            get_states_by_country_for_work_address();
        });
        function get_states_by_country_for_work_address(){
            var country_id = $('#work_country_id').val();
            if(country_id){
                $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:country_id}, function(data){
                    $('#work_state_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#work_state_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_work_state){
                        $("#work_state_id").val(old_work_state).change();
                    } else {
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                });
            } else {
                $('#work_state_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
        
        // Pre-select old values for current address
        var old_current_country = '{{ old('current_country_id') }}';
        var old_current_state = '{{ old('current_state_id') }}';
        if(old_current_country){
            $('#current_country_id').val(old_current_country).change();
        }
        $('#current_country_id').on('change', function() {
            get_states_by_country_for_current_address();
        });
        function get_states_by_country_for_current_address(){
            var country_id = $('#current_country_id').val();
            if(country_id){
                $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:country_id}, function(data){
                    $('#current_state_id').html(null);
                    for (var i = 0; i < data.length; i++) {
                        $('#current_state_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                    if(old_current_state){
                        $("#current_state_id").val(old_current_state).change();
                    } else {
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                });
            } else {
                $('#current_state_id').html(null);
                AIZ.plugins.bootstrapSelect('refresh');
            }
        }
    });
</script>
@endsection