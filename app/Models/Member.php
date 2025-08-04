<?php

namespace App\Models;
use App\Models\User;
use App\Models\Religion; // Make sure these are imported
use App\Models\Caste;
use App\Models\SubCaste;
use App\Models\MaritalStatus;
use App\Models\AnnualSalaryRange;
use App\Models\Education; // If education has a direct relationship to Member
use App\Models\Career;    // If career has a direct relationship to Member


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id','gender','birthday','on_behalves_id','current_package_id','remaining_interest','remaining_contact_view','remaining_photo_gallery','auto_profile_match','package_validity',
        'marital_status_id', // Ensure this is fillable if it's updated via forms
        'annual_salary_range_id', // Ensure this is fillable
        'religion_id',
        'caste_id',
        'sub_caste_id',
        'height',
        // Add any other new fields that are directly on the members table here if not already present
    ];


    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }
    public function caste()
    {
        return $this->belongsTo(Caste::class);
    }
    public function subCaste()
    {
        return $this->belongsTo(SubCaste::class);
    }
    public function partnerExpectation()
    {
        return $this->hasOne(PartnerExpectation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function on_behalves(){
        return $this->belongsTo(OnBehalf::class)->withTrashed();
    }

    // Corrected: Define the belongsTo relationship for MaritalStatus
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    // Define relationship for AnnualSalaryRange
    public function annualSalaryRange()
    {
        return $this->belongsTo(AnnualSalaryRange::class);
    }

    // If Education and Career are also directly related to Member model (and not just User)
    // Please confirm if member_id is a foreign key in education/career table or user_id
    // If it's user_id, these relationships should be on the User model as we've done for main `education` and `career` relations.
    // If there are separate education/career entries related to Member, then define them here.
    // For now, assuming they are linked via user_id in the User model based on previous fixes.

    public function package()
    {
        return $this->belongsTo(Package::class,'current_package_id')->withTrashed();
    }
}