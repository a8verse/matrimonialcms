<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class MembersExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = User::where('user_type', 'member')->with([
            'member',
            'member.religion',
            'member.caste',
            'member.subCaste',
            // 'member.maritalStatus', // TEMPORARILY REMOVED FOR TROUBLESHOOTING
            'member.annualSalaryRange',
            'address.country',
            'address.state',
            'address.city',
            'packagePayment.package',
            'additionalInfo',
            'partnerExpectation.maritalStatus',
            'partnerExpectation.caste',
            'partnerExpectation.country',
            'partnerExpectation.state',
            'partnerExpectation.city',
            'education',
            'career',
        ]);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Member ID',
            'Your Name',
            'Gender',
            'Date of birth',
            'Age',
            'Phone Number',
            'Email ID',
            'Height',
            'Religion',
            'Marital Status', // Still in headings, but data will be 'N/A'
            'Caste',
            'Income (Min)',
            'Income (Max)',
            'Career',
            'Your Highest Education',
            'Place of living (City)',
            'Place of living (State)',
            'Place of living (Country)',
            'Instagram ID',
            'Partner Expectation (Marital Status)',
            'Partner Expectation (Caste)',
            'Partner Expectation (Location)',
            'Registration Date',
            'Verification Status',
            'Member Since',
            'Current Package Name',
            'Package Expiry Date',
            'Last login date & time',
        ];
    }

    public function map($member): array
    {
        $partnerExpectationMaritalStatus = $member->partnerExpectation?->maritalStatus?->name ?? 'N/A';
        $partnerExpectationCaste = $member->partnerExpectation?->caste?->name ?? 'N/A';
        $partnerExpectationLocation = ($member->partnerExpectation?->city?->name ?? '') . ', ' .
                                    ($member->partnerExpectation?->state?->name ?? '') . ', ' .
                                    ($member->partnerExpectation?->country?->name ?? 'N/A');

        return [
            $member->code,
            $member->first_name . ' ' . $member->last_name,
            $member->member?->gender == 1 ? 'Male' : ($member->member?->gender == 2 ? 'Female' : 'N/A'),
            $member->member?->birthday ? date('d-m-Y', strtotime($member->member->birthday)) : 'N/A',
            $member->member?->birthday ? Carbon::parse($member->member->birthday)->age : 'N/A',
            $member->phone ?? 'N/A',
            $member->email ?? 'N/A',
            $member->member?->height ?? 'N/A',
            $member->member?->religion?->name ?? 'N/A',
            // $member->member?->maritalStatus?->name ?? 'N/A', // TEMPORARILY REMOVED FOR TROUBLESHOOTING
            'N/A', // Replace with N/A as it's not being loaded
            $member->member?->caste?->name ?? 'N/A',
            $member->member?->annualSalaryRange?->min_salary ?? 'N/A',
            $member->member?->annualSalaryRange?->max_salary ?? 'N/A',
            $member->career?->name ?? 'N/A',
            $member->education?->level ?? 'N/A',
            $member->address?->city?->name ?? 'N/A',
            $member->address?->state?->name ?? 'N/A',
            $member->address?->country?->name ?? 'N/A',
            $member->additionalInfo?->instagram_id ?? 'N/A',
            $partnerExpectationMaritalStatus,
            $partnerExpectationCaste,
            $partnerExpectationLocation,
            date('d-m-Y', strtotime($member->created_at)),
            $member->approved == 1 ? 'Approved' : ($member->verification_info != null ? 'Pending' : 'No Request'),
            date('d-m-Y', strtotime($member->created_at)),
            $member->packagePayment?->package?->name ?? 'N/A',
            $member->packagePayment?->end_date ?? 'N/A',
            $member->last_login_at ? date('d-m-Y h:i A', strtotime($member->last_login_at)) : 'N/A',
        ];
    }
}