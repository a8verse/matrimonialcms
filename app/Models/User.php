<?php

namespace App\Models;
use App\Models\Member;
use App\Models\Address;
use App\Models\Education;
use App\Models\Career;
use App\Models\PhysicalAttribute;
use App\Models\Hobby;
use App\Models\Attitude;
use App\Models\Recidency;
use App\Models\Lifestyle;
use App\Models\Astrology;
use App\Models\Family;
use App\Models\PartnerExpectation;
use App\Models\SpiritualBackground;
use App\Models\PackagePayment;
use App\Models\HappyStory;
use App\Models\Shortlist;
use App\Models\IgnoredUser;
use App\Models\ReportedUser;
use App\Models\Staff;
use App\Models\GalleryImage;
use App\Models\ExpressInterest;
use App\Models\ProfileMatch;
use App\Models\AdditionalMemberInfo; // Make sure this is imported

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\EmailVerificationNotification;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use SoftDeletes;
    use Notifiable;
    use HasRoles;

    protected $appends = ['age']; // Adding 'age' as an appended attribute

    public function getAgeAttribute()
    {
        return $this->member->birthday ? \Carbon\Carbon::parse($this->member->birthday)->age : null;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime', // Ensure this is cast as datetime
    ];


    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class)->latestOfMany(); // Assuming one primary address
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function education()
    {
        return $this->hasOne(Education::class)->latestOfMany(); // For highest education
    }

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function career()
    {
        return $this->hasOne(Career::class)->latestOfMany(); // For current career
    }

    public function physical_attributes()
    {
        return $this->hasOne(PhysicalAttribute::class);
    }

    public function hobbies()
    {
        return $this->hasOne(Hobby::class);
    }

    public function attitude()
    {
        return $this->hasOne(Attitude::class);
    }

    public function recidency()
    {
        return $this->hasOne(Recidency::class);
    }

    public function lifestyles()
    {
        return $this->hasOne(Lifestyle::class);
    }

    public function astrologies()
    {
        return $this->hasOne(Astrology::class);
    }

    public function families()
    {
        return $this->hasOne(Family::class);
    }

    public function partner_expectations()
    {
        return $this->hasOne(PartnerExpectation::class);
    }

    public function partnerExpectation() // Alias for clarity matching controller/export
    {
        return $this->hasOne(PartnerExpectation::class);
    }

    public function spiritual_backgrounds()
    {
        return $this->hasOne(SpiritualBackground::class);
    }

    // Corrected relationship name and type
    public function packagePayment()
    {
        return $this->hasOne(PackagePayment::class)->latestOfMany(); // Assuming one active package payment
    }

    public function happy_story()
    {
        return $this->hasOne(HappyStory::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function shortlist()
    {
        return $this->hasMany(Shortlist::class);
    }

    public function ignored_users()
    {
        return $this->hasMany(IgnoredUser::class);
    }

    public function reported_users()
    {
        return $this->hasMany(ReportedUser::class);
    }

    public function gallery_images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function express_interests()
    {
        return $this->hasMany(ExpressInterest::class);
    }

    public function profile_matches()
    {
        return $this->hasMany(ProfileMatch::class);
    }

    // This is the additional relationship for Additional Profile Attributes (like Instagram ID)
    public function additionalInfo()
    {
        return $this->hasOne(AdditionalMemberInfo::class);
    }
}