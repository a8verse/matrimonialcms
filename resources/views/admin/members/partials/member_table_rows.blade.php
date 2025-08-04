@foreach($members as $key => $member)
    <tr> {{-- Removed style="white-space: nowrap;" from here --}}
        <td>{{ $member->code }}</td>
        <td>
            @if(uploaded_asset($member->photo) != null)
                <img class="img-md" src="{{ uploaded_asset($member->photo) }}" height="45px"  alt="{{translate('photo')}}">
            @else
                <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px"  alt="{{translate('photo')}}">
            @endif
        </td>
        <td>{{ $member->first_name.' '.$member->last_name }}</td>
        <td>
            @if ($member->member != null && $member->member->gender == 1)
                {{ translate('Male') }}
            @elseif ($member->member != null && $member->member->gender == 2)
                {{ translate('Female') }}
            @else
                {{ ' ' }}
            @endif
        </td>
        <td>{{ $member->member ? date('d-m-Y', strtotime($member->member->birthday)) : '' }}</td>
        <td>
            @if ($member->member && $member->member->birthday)
                {{ \Carbon\Carbon::parse($member->member->birthday)->age }}
            @else
                N/A
            @endif
        </td>
        <td>{{ $member->phone ?? 'N/A' }}</td>
        <td>{{ $member->email ?? 'N/A' }}</td>
        <td>{{ $member->member?->height ?? 'N/A' }}</td>
        <td>{{ $member->member?->religion?->name ?? 'N/A' }}</td>
        <td>{{ $member->member?->maritalStatus?->name ?? 'N/A' }}</td>
        <td>{{ $member->member?->caste?->name ?? 'N/A' }}</td>
        <td>{{ $member->member?->annualSalaryRange?->min_salary ?? 'N/A' }} - {{ $member->member?->annualSalaryRange?->max_salary ?? 'N/A' }}</td>
        <td>{{ $member->career?->name ?? 'N/A' }}</td>
        <td>{{ $member->education?->level ?? 'N/A' }}</td>
        <td>{{ $member->address?->city?->name ?? '' }}, {{ $member->address?->state?->name ?? '' }}, {{ $member->address?->country?->name ?? 'N/A' }}</td>
        <td>{{ $member->additionalInfo?->instagram_id ?? 'N/A' }}</td>
        <td>
            @if($member->partnerExpectation)
                {{ $member->partnerExpectation->maritalStatus?->name ?? '' }},
                {{ $member->partnerExpectation->caste?->name ?? '' }},
                {{ $member->partnerExpectation->country?->name ?? '' }}
            @else
                N/A
            @endif
        </td>
        <td>{{ date('d-m-Y', strtotime($member->created_at)) }}</td>
        <td>
            @if($member->approved == 1)
                <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
            @elseif($member->verification_info != null)
                <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
            @else
                <span class="badge badge-inline badge-warning">{{translate('No Request')}}</span>
            @endif
        </td>
        <td>{{ date('d-m-Y', strtotime($member->created_at)) }}</td>
        <td>{{ $member->packagePayment?->package?->name ?? 'N/A' }}</td>
        <td>{{ $member->packagePayment?->end_date ?? 'N/A' }}</td>
        <td>{{ $member->last_login_at ? date('d-m-Y h:i A', strtotime($member->last_login_at)) : 'N/A' }}</td>
        <td class="text-right">
            <div class="btn-group mb-2">
                <div class="btn-group">
                    <button type="button" class="btn py-0" data-toggle="dropdown"
                            aria-expanded="false">
                        <i class="las la-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @can ('view_member_profile')
                            <a class="dropdown-item" href="{{ route('members.show', encrypt($member->id)) }}">{{translate('View')}}</a>
                        @endcan
                        @can('edit_member')
                            <a class="dropdown-item" href="{{ route('members.edit', encrypt($member->id)) }}">{{translate('Edit')}}</a>
                        @endcan
                        @can ('block_member')
                            @if($member->blocked == 0)
                                <a class="dropdown-item" onclick="block_member({{$member->id}})" href="javascript:void(0);">{{translate('Block')}}</a>
                            @elseif($member->blocked == 1)
                                <a class="dropdown-item" onclick="unblock_member({{$member->id}})" href="javascript:void(0);" >{{translate('Unblock')}}</a>
                            @endif
                        @endcan
                        @can ('approve_member')
                            @if(get_setting('member_verification') == 1 && $member->verification_info != null)
                                <a class="dropdown-item" href="{{ route('member.show_verification_info', encrypt($member->id)) }}" >{{translate('View Verification Info')}}</a>
                            @endif
                        @endcan

                        @can ('update_member_package')
                            <a class="dropdown-item" onclick="package_info({{$member->id}})" href="javascript:void(0);" >{{translate('Package')}}</a>
                        @endcan
                            <a class="dropdown-item" onclick="wallet_balance_update({{$member->id}},{{$member->balance}})" href="javascript:void(0);" >{{translate('Wallet Balance')}}</a>
                        @can ('login_as_member')
                            <a href="{{ route('members.login', encrypt($member->id)) }}" class="dropdown-item">{{translate('Log in as this Member')}}</a>
                        @endcan
                        @can ('delete_member')
                            <a class="dropdown-item confirm-delete" data-href="{{route('members.destroy', $member->id)}}">{{translate('Delete')}}</a>
                        @endcan
                    </div>
                </div>
            </div>
        </td>
    </tr>
@endforeach