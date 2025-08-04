@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Members')}}</h1>
        </div>
        @can('create_member')
            <div class="col-md-6 text-right">
                <a href="{{route('members.create')}}" class="btn btn-circle btn-primary">{{translate('Add New Member')}}</a>
            </div>
        @endcan
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row gutters-5 align-items-center">
  				<div class="col-md-3 text-center text-md-left">
  					<h5 class="mb-md-0 h6 text-capitalize">{{ translate('All members') }}</h5>
  				</div>
                <div class="col-md-9 d-flex justify-content-end align-items-center">
                    {{-- Search Box --}}
                    <div class="input-group input-group-sm mr-2" style="width: 250px;">
                        <input type="text" class="form-control" id="search_input" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Member ID / Name / Phone / Email') }}">
                        <div class="input-group-append">
                            <button type="submit" form="filter_members" class="btn btn-light"><i class="las la-search"></i></button>
                        </div>
                    </div>

                    {{-- Filter Button --}}
                    <a class="btn btn-light btn-sm mr-2" data-toggle="collapse" href="#filterCollapse" role="button" aria-expanded="false" aria-controls="filterCollapse">
                        {{ translate('Filters') }} <i class="las la-angle-down"></i>
                    </a>

                    {{-- Export Button (now triggers a modal with buttons) --}}
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exportModal">{{ translate('Download Data') }}</button>
                </div>
		    </div>

            <div class="card-body">
                {{-- Collapsible Filter Section --}}
                <div class="collapse mb-4" id="filterCollapse">
                    <form class="" id="filter_members" action="" method="GET">
                        <div class="row gutters-5">
                            <div class="col-md-3 mb-3">
                                <label for="gender">{{ translate('Gender')}}</label>
                                <select class="form-control aiz-selectpicker" name="gender" id="gender" data-selected="{{ $filters['gender'] ?? '' }}">
                                    <option value="">{{ translate('Any Gender') }}</option>
                                    <option value="1">{{ translate('Male') }}</option>
                                    <option value="2">{{ translate('Female') }}</option>
                                </select>
                            </div>
                            
                            {{-- Height Filter --}}
                            <div class="col-md-3 mb-3">
                                <label for="height_range">{{ translate('Height')}}</label>
                                <select class="form-control aiz-selectpicker" name="height_range" id="height_range" data-selected="{{ $filters['height_range'] ?? '' }}">
                                    <option value="">{{ translate('Any Height') }}</option>
                                    <option value="0-150">{{ translate('Under 150 cm') }}</option>
                                    <option value="150-160">{{ translate('150 - 160 cm') }}</option>
                                    <option value="160-170">{{ translate('160 - 170 cm') }}</option>
                                    <option value="170-180">{{ translate('170 - 180 cm') }}</option>
                                    <option value="180-190">{{ translate('180 - 190 cm') }}</option>
                                    <option value="190-999">{{ translate('Above 190 cm') }}</option>
                                </select>
                            </div>

                            {{-- Age Filter --}}
                            <div class="col-md-3 mb-3">
                                <label for="age_range">{{ translate('Age')}}</label>
                                <select class="form-control aiz-selectpicker" name="age_range" id="age_range" data-selected="{{ $filters['age_range'] ?? '' }}">
                                    <option value="">{{ translate('Any Age') }}</option>
                                    <option value="18-25">{{ translate('18 - 25 Years') }}</option>
                                    <option value="25-30">{{ translate('25 - 30 Years') }}</option>
                                    <option value="30-35">{{ translate('30 - 35 Years') }}</option>
                                    <option value="35-40">{{ translate('35 - 40 Years') }}</option>
                                    <option value="40-99">{{ translate('40+ Years') }}</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="education_id">{{ translate('Education')}}</label>
                                <select class="form-control aiz-selectpicker" name="education_id" id="education_id" data-selected="{{ $filters['education_id'] ?? '' }}">
                                    <option value="">{{ translate('Any Education') }}</option>
                                    @foreach ($educations_dropdown_data as $edu)
                                        <option value="{{ $edu->id }}">{{ $edu->level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="career_id">{{ translate('Career')}}</label>
                                <select class="form-control aiz-selectpicker" name="career_id" id="career_id" data-selected="{{ $filters['career_id'] ?? '' }}">
                                    <option value="">{{ translate('Any Career') }}</option>
                                    @foreach ($careers_dropdown_data as $car)
                                        <option value="{{ $car->id }}">{{ $car->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Income Filter --}}
                            <div class="col-md-3 mb-3">
                                <label for="income_range">{{ translate('Income')}}</label>
                                <select class="form-control aiz-selectpicker" name="income_range" id="income_range" data-selected="{{ $filters['income_range'] ?? '' }}">
                                    <option value="">{{ translate('Any Income') }}</option>
                                    @foreach ($annual_salary_ranges as $income_range)
                                        <option value="{{ $income_range->min_salary }}-{{ $income_range->max_salary }}">{{ $income_range->min_salary }} - {{ $income_range->max_salary }}</option>
                                    @endforeach
                                    <option value="0-10000">{{ translate('Under 10,000') }}</option>
                                    <option value="10000-20000">{{ translate('10,000 - 20,000') }}</option>
                                    <option value="20000-50000">{{ translate('20,000 - 50,000') }}</option>
                                    <option value="50000-100000">{{ translate('50,000 - 100,000') }}</option>
                                    <option value="100000-9999999">{{ translate('100,000+') }}</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="caste">{{ translate('Caste')}}</label>
                                <select class="form-control aiz-selectpicker" name="caste" id="caste" data-selected="{{ $filters['caste'] ?? '' }}">
                                    <option value="">{{ translate('Any Caste') }}</option>
                                    @foreach ($castes as $caste_item)
                                        <option value="{{ $caste_item->id }}">{{ $caste_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="religion">{{ translate('Religion')}}</label>
                                <select class="form-control aiz-selectpicker" name="religion" id="religion" data-selected="{{ $filters['religion'] ?? '' }}">
                                    <option value="">{{ translate('Any Religion') }}</option>
                                    @foreach ($religions as $religion_item)
                                        <option value="{{ $religion_item->id }}">{{ $religion_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="community">{{ translate('Community')}}</label>
                                <select class="form-control aiz-selectpicker" name="community" id="community" data-selected="{{ $filters['community'] ?? '' }}">
                                    <option value="">{{ translate('Any Community') }}</option>
                                    @foreach ($sub_castes as $sub_caste_item)
                                        <option value="{{ $sub_caste_item->id }}">{{ $sub_caste_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="country">{{ translate('Country')}}</label>
                                <select class="form-control aiz-selectpicker" name="country" id="country" data-live-search="true" data-selected="{{ $filters['country'] ?? '' }}">
                                    <option value="">{{ translate('Any Country') }}</option>
                                    @foreach ($countries as $country_item)
                                        <option value="{{ $country_item->id }}">{{ $country_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="state">{{ translate('State')}}</label>
                                <select class="form-control aiz-selectpicker" name="state" id="state" data-live-search="true" data-selected="{{ $filters['state'] ?? '' }}">
                                    <option value="">{{ translate('Any State') }}</option>
                                    @foreach ($states as $state_item)
                                        <option value="{{ $state_item->id }}">{{ $state_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="city">{{ translate('City')}}</label>
                                <select class="form-control aiz-selectpicker" name="city" id="city" data-live-search="true" data-selected="{{ $filters['city'] ?? '' }}">
                                    <option value="">{{ translate('Any City') }}</option>
                                    @foreach ($cities as $city_item)
                                        <option value="{{ $city_item->id }}">{{ $city_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="verification_status">{{ translate('Verification Status')}}</label>
                                <select class="form-control aiz-selectpicker" name="verification_status" id="verification_status" data-selected="{{ $filters['verification_status'] ?? '' }}">
                                    <option value="">{{ translate('All Statuses') }}</option>
                                    <option value="approved">{{ translate('Approved') }}</option>
                                    <option value="pending">{{ translate('Pending Request') }}</option>
                                    <option value="no_request">{{ translate('No Request') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="member_status">{{ translate('Member Status')}}</label>
                                <select class="form-control aiz-selectpicker" name="member_status" id="member_status" data-selected="{{ $filters['member_status'] ?? '' }}">
                                    <option value="">{{ translate('All Statuses') }}</option>
                                    <option value="active">{{ translate('Active') }}</option>
                                    <option value="deactivated">{{ translate('Deactivated') }}</option>
                                    <option value="blocked">{{ translate('Blocked') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="current_package">{{ translate('Current Package')}}</label>
                                <select class="form-control aiz-selectpicker" name="current_package" id="current_package" data-live-search="true" data-selected="{{ $filters['current_package'] ?? '' }}">
                                    <option value="">{{ translate('Any Package') }}</option>
                                    @foreach ($packages as $package_item)
                                        <option value="{{ $package_item->id }}">{{ $package_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="sort_by" value="{{ $sort_by }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">{{ translate('Apply Filter') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table Container for horizontal scrolling --}}
                <div class="table-responsive" style="min-height: 400px; overflow-x: auto;">
                    <table class="table aiz-table mb-0" id="member-table">
                        <thead>
                            <tr>
                                <th style="min-width: 120px;">{{translate('Member ID')}}</th>
                                <th style="min-width: 80px;">{{translate('Image')}}</th>
                                <th style="min-width: 250px;">{{translate('Your Name')}}</th>
                                <th data-sort-by="gender" class="sortable-header" style="min-width: 100px;">{{translate('Gender')}} <i class="las la-sort"></i></th>
                                <th style="min-width: 140px;">{{translate('Date of birth')}}</th>
                                <th data-sort-by="age" class="sortable-header" style="min-width: 80px;">{{translate('Age')}} <i class="las la-sort"></i></th>
                                <th style="min-width: 160px;">{{translate('Phone Number')}}</th>
                                <th style="min-width: 280px;">{{translate('Email ID')}}</th>
                                <th data-sort-by="height" class="sortable-header" style="min-width: 120px;">{{translate('Height')}} <i class="las la-sort"></i></th>
                                <th style="min-width: 150px;">{{translate('Religion')}}</th>
                                <th data-sort-by="marital_status" class="sortable-header" style="min-width: 150px;">{{translate('Marital Status')}} <i class="las la-sort"></i></th>
                                <th style="min-width: 150px;">{{translate('Caste')}}</th>
                                <th data-sort-by="income" class="sortable-header" style="min-width: 160px;">{{translate('Income')}} <i class="las la-sort"></i></th>
                                <th style="min-width: 180px;">{{translate('Career')}}</th>
                                <th style="min-width: 200px;">{{translate('Your Highest Education')}}</th>
                                <th style="min-width: 220px;">{{translate('Place of living')}}</th>
                                <th style="min-width: 150px;">{{translate('Instagram ID')}}</th>
                                <th style="min-width: 350px;">{{translate('Partner expectation')}}</th>
                                <th data-sort-by="member_since" class="sortable-header" style="min-width: 150px;">{{translate('Registration Date')}} <i class="las la-sort"></i></th>
                                <th data-sort-by="verification_status" class="sortable-header" style="min-width: 160px;">{{translate('Verification Status')}} <i class="las la-sort"></i></th>
                                <th style="min-width: 150px;">{{translate('Member Since')}}</th>
                                <th style="min-width: 170px;">{{translate('Current Package name')}}</th>
                                <th style="min-width: 170px;">{{translate('Package expiry date')}}</th>
                                <th style="min-width: 220px;">{{translate('Last login date & time')}}</th>
                                <th class="text-right" style="min-width: 100px;">{{translate('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody id="member-table-body">
                            @include('admin.members.partials.member_table_rows')
                        </tbody>
                    </table>
                </div>
                <div class="aiz-pagination" id="member-pagination-links">
                    {{ $members->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')

    {{-- Member Block Modal--}}
    <div class="modal fade member-block-modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <form class="form-horizontal member-block" action="{{ route('members.block') }}" method="POST">
                    @csrf
                    <input type="hidden" name="member_id" id="block_member_id" value="">
                    <input type="hidden" name="block_status" id="block_status" value="">
                    <div class="modal-header">
                        <h5 class="modal-title h6">{{translate('Member Block !')}}</h5>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{translate('Blocking Reason')}}</label>
                            <div class="col-md-9">
                                <textarea type="text" name="blocking_reason" class="form-control" placeholder="{{translate('Blocking Reason')}}" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{translate('Submit')}}</button>
                    </div>
                </form>
        	</div>
    	</div>
    </div>

    <!-- Member Unblock Modal -->
    <div class="modal fade member-unblock-modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
            <form class="form-horizontal member-block" action="{{ route('members.block') }}" method="POST">
                @csrf
                <input type="hidden" name="member_id" id="unblock_member_id" value="">
                <input type="hidden" name="block_status" id="unblock_block_status" value="">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Member Unblock !')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>
                        <b>{{translate('Blocked Reason')}} : </b>
                        <span id="block_reason"></span>
                    </p>
                    <p class="mt-1">{{translate('Are you want to unblock this member?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Unblock')}}</button>
                </div>
            </form>
      	</div>
    	</div>
    </div>

    <div class="modal fade member_wallet_balance_modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
            <form class="form-horizontal member-block" action="{{ route('member.wallet_balance_update') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="user_id_wallet_balance" value="">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Wallet Balance Update')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                  <div class="row">
                      <div class="col-md-4">
                          <label>{{ translate('Current Banalce')}}</label>
                      </div>
                      <div class="col-md-8">
                          <input type="number" class="form-control mb-3" id="member_wallet_balance" value="" readonly>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <label>{{ translate('Update Type')}} <span class="text-danger">*</span></label>
                      </div>
                      <div class="col-md-8">
                          <div class="mb-3">
                              <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="payment_option" data-live-search="true">
                                <option value="added_by_admin">{{ translate('Add')}}</option>
                                <option value="deducted_by_admin">{{ translate('Deduct')}}</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <label>{{ translate('Amount')}} <span class="text-danger">*</span></label>
                      </div>
                      <div class="col-md-8">
                          <input type="number" lang="en" class="form-control mb-3" name="wallet_amount" placeholder="{{ translate('Amount')}}" required>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Submit')}}</button>
                </div>
            </form>
      	</div>
    	</div>
    </div>

    {{-- Export Modal --}}
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">{{ translate('Download Data') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="export-modal-body">
                    {{-- Buttons for date range export --}}
                    <div class="d-flex flex-wrap justify-content-center mb-3">
                        <button type="button" class="btn btn-primary m-1 export-btn" data-date-range="all">{{ translate('All Time') }}</button>
                        <button type="button" class="btn btn-primary m-1 export-btn" data-date-range="today">{{ translate('Today') }}</button>
                        <button type="button" class="btn btn-primary m-1 export-btn" data-date-range="last_week">{{ translate('Last Week') }}</button>
                        <button type="button" class="btn btn-primary m-1 export-btn" data-date-range="this_month">{{ translate('This Month') }}</button>
                        <button type="button" class="btn btn-primary m-1 export-btn" data-date-range="last_month">{{ translate('Last Month') }}</button>
                        <button type="button" class="btn btn-primary m-1 export-btn" data-date-range="last_3_months">{{ translate('Last 3 Months') }}</button>
                    </div>

                    <hr>

                    {{-- Custom Date Range Section --}}
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-secondary btn-sm" id="toggle_custom_date_inputs">{{ translate('Custom Date Range') }}</button>
                    </div>
                    <div class="form-group d-none text-center" id="custom_date_range_inputs">
                        <label for="start_date">{{ translate('Start Date')}}</label>
                        <input type="date" class="form-control mb-3 mx-auto" style="max-width: 250px;" name="start_date" id="start_date">
                        <label for="end_date">{{ translate('End Date')}}</label>
                        <input type="date" class="form-control mx-auto" style="max-width: 250px;" name="end_date" id="end_date">
                        <button type="button" class="btn btn-success mt-3 export-btn" data-date-range="custom_date">{{ translate('Download Custom Data') }}</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                </div>
            </div>
        </div>
    </div>


    @include('modals.create_edit_modal')
    @include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">
    // Debounce function to limit AJAX calls
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    // AJAX function to fetch and update table
    function fetchMembersData() {
        var form = $('#filter_members');
        var url = new URL(window.location.href);

        // Get all filter, search, and sort parameters
        var params = {};
        form.find('select, input').each(function() {
            if ($(this).attr('name') && $(this).val() !== '') {
                params[$(this).attr('name')] = $(this).val();
            }
        });
        
        // Add search input value
        params['search'] = $('#search_input').val();

        // Update URL without full reload (for user's browser history)
        var new_url = new URL(window.location.origin + window.location.pathname);
        for (let key in params) {
            if (params[key]) {
                new_url.searchParams.set(key, params[key]);
            }
        }
        // Remove empty search param if search input is empty
        if (!params['search']) {
            new_url.searchParams.delete('search');
        }

        window.history.pushState({}, '', new_url);

        // Perform AJAX request
        $.ajax({
            url: "{{ route('members.index') }}",
            type: 'GET',
            data: params,
            beforeSend: function() {
                // Show a loading spinner or disable controls
                $('#member-table-body').css('opacity', '0.5');
            },
            success: function(response) {
                var tempDiv = $('<div>').html(response);
                
                var newTableBody = tempDiv.find('#member-table-body').html();
                var newPagination = tempDiv.find('#member-pagination-links').html();

                $('#member-table-body').html(newTableBody);
                $('#member-pagination-links').html(newPagination);
                
                AIZ.plugins.bootstrapSelect('refresh');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            },
            complete: function() {
                $('#member-table-body').css('opacity', '1');
            }
        });
    }

    $('#search_input').on('keyup', debounce(function() {
        fetchMembersData();
    }, 500));

    $('#filter_members').on('submit', function(e) {
        e.preventDefault();
        fetchMembersData();
    });
    
    $('#filterCollapse select').on('change', function() {
        fetchMembersData();
    });


    $(document).on('click', '#member-pagination-links .pagination a', function(e) {
        e.preventDefault();
        var page_url = $(this).attr('href');
        var url_obj = new URL(page_url);
        var page_number = url_obj.searchParams.get('page');
        
        var form = $('#filter_members');
        var current_url = new URL(window.location.href);
        current_url.searchParams.set('page', page_number);
        window.history.pushState({}, '', current_url);

        var params = {};
        form.find('select, input').each(function() {
            if ($(this).attr('name') && $(this).val() !== '') {
                params[$(this).attr('name')] = $(this).val();
            }
        });
        params['search'] = $('#search_input').val();
        params['page'] = page_number;

        $.ajax({
            url: "{{ route('members.index') }}",
            type: 'GET',
            data: params,
            beforeSend: function() { $('#member-table-body').css('opacity', '0.5'); },
            success: function(response) {
                var tempDiv = $('<div>').html(response);
                $('#member-table-body').html(tempDiv.find('#member-table-body').html());
                $('#member-pagination-links').html(tempDiv.find('#member-pagination-links').html());
                AIZ.plugins.bootstrapSelect('refresh');
            },
            error: function(xhr) { console.log(xhr.responseText); },
            complete: function() { $('#member-table-body').css('opacity', '1'); }
        });
    });


    $('.sortable-header').on('click', function() {
        var sort_by = $(this).data('sort-by');
        var direction = 'asc';
        var current_direction = new URL(window.location.href).searchParams.get('direction');
        var current_sort_by = new URL(window.location.href).searchParams.get('sort_by');

        if (current_sort_by === sort_by && current_direction === 'asc') {
            direction = 'desc';
        }

        var form = $('#filter_members');
        form.find('input[name="sort_by"]').val(sort_by);
        form.find('input[name="direction"]').val(direction);
        
        fetchMembersData();
    });
    
    // Toggle custom date range inputs in export modal
    $('#toggle_custom_date_inputs').on('click', function() {
        $('#custom_date_range_inputs').toggleClass('d-none');
    });

    // Handle export button clicks
    $(document).on('click', '.export-btn', function() {
        var date_range = $(this).data('date-range');
        var export_url = "{{ route('members.export') }}";
        var params = { date_range: date_range };

        if (date_range === 'custom_date') {
            params.start_date = $('#start_date').val();
            params.end_date = $('#end_date').val();
            if (!params.start_date || !params.end_date) {
                alert('Please select both start and end dates for custom export.');
                return;
            }
        }
        
        // Redirect to trigger file download
        window.location.href = export_url + '?' + $.param(params);
    });


    function package_info(id){
        $.post('{{ route('members.package_info') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
        });
    }

    function get_package(id){
        $.post('{{ route('members.get_package') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
        });
    }


    function approve_member(id){
        $('.member-approval-modal').modal('show');
        $('#member_id').val(id);
    }

    function block_member(id){
        $('.member-block-modal').modal('show');
        $('#block_member_id').val(id);
        $('#block_status').val(1);
    }

    function unblock_member(id){
        $('#unblock_member_id').val(id);
        $('#unblock_block_status').val(0);
        $.post('{{ route('members.blocking_reason') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.member-unblock-modal').modal('show');
            $('#block_reason').html(data);
        });
    }

    function wallet_balance_update(id, balance){
        $('.member_wallet_balance_modal').modal('show');
        $('#user_id_wallet_balance').val(id);
        $('#member_wallet_balance').val(balance);
    }
</script>
@endsection