<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Package;
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
use App\Models\AdditionalMemberInfo;
use App\Models\OnBehalf;
use App\Models\MemberLanguage; // NEW
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use Notification;
use App\Notifications\DbStoreNotification;
use Kutia\Larafirebase\Facades\Larafirebase;


class MultiStepRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Step 1: Show account creation form
    public function showStep1Form()
    {
        $on_behalves = OnBehalf::all();
        return view('frontend.multistep_registration.step1', compact('on_behalves'));
    }

    // Step 1: Handle form submission
    public function postStep1Form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'on_behalf'     => 'required|integer',
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'gender'        => 'required|in:1,2',
            'looking_for'   => 'required|in:1,2',
            'date_of_birth' => 'required|date|before_or_equal:' . date('Y-m-d', strtotime('-18 years')),
            'email'         => 'required|email|unique:users',
            'password'      => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ]);

        // Age validation logic
        $age = \Carbon\Carbon::parse($request->date_of_birth)->age;
        if ($request->gender == 1 && $age < 21) {
            $validator->errors()->add('date_of_birth', 'Male members must be at least 21 years old.');
        }
        if ($request->gender == 2 && $age < 18) {
            $validator->errors()->add('date_of_birth', 'Female members must be at least 18 years old.');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation failed.');
        }

        Session::put('registration_data', $request->all());
        return redirect()->route('register.step2');
    }

    // Step 2: Show personal details form
    public function showStep2Form()
    {
        if (Session::has('registration_data')) {
            $registration_data = Session::get('registration_data');
            $marital_statuses = \App\Models\MaritalStatus::all();
            $religions = \App\Models\Religion::all();
            $countries = \App\Models\Country::where('status', 1)->get();
            $heights = get_heights();
            $member_languages = \App\Models\MemberLanguage::all();
            
            return view('frontend.multistep_registration.step2', compact('registration_data', 'marital_statuses', 'religions', 'countries', 'heights', 'member_languages'));
        }
        return redirect()->route('register');
    }

    // Step 2: Handle form submission
    public function postStep2Form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'height'            => 'required|integer',
            'marital_status'    => 'required|integer',
            'religion'          => 'required|integer',
            'caste'             => 'required|integer',
            'sub_caste'         => 'nullable|string',
            'mother_tongue'     => 'nullable|integer',
            'instagram_id'      => 'nullable|string',
            'manglik'           => 'required|in:yes,no,notsure',
            'phone'             => 'required_without:email|nullable|string|unique:users',
            'country_code'      => 'required_with:phone|nullable|string',
            'residence_country' => 'required|integer',
            'residence_state'   => 'required|integer',
            'residence_city'    => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $registration_data = Session::get('registration_data');
        Session::put('registration_data', array_merge($registration_data, $request->all()));

        return redirect()->route('register.step3');
    }

    // Step 3: Show professional and family form
    public function showStep3Form()
    {
        if (Session::has('registration_data')) {
            $registration_data = Session::get('registration_data');
            $education_levels = \App\Models\EducationLevel::all();
            $occupations = \App\Models\Occupation::all();
            $annual_salary_ranges = \App\Models\AnnualSalaryRange::all();
            $family_statuses = \App\Models\FamilyStatus::all();
            $family_values = \App\Models\FamilyValue::all();
            $countries = \App\Models\Country::where('status', 1)->get();

            return view('frontend.multistep_registration.step3', compact('registration_data', 'education_levels', 'occupations', 'annual_salary_ranges', 'family_statuses', 'family_values', 'countries'));
        }
        return redirect()->route('register');
    }

    // Step 3: Handle form submission
    public function postStep3Form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'education_level_id'        => 'required|integer',
            'occupation_status'         => 'required|string',
            'occupation_id'             => 'required_if:occupation_status,!=,not_working|integer',
            'annual_income_id'          => 'required_if:occupation_status,!=,not_working|integer',
            'work_country_id'           => 'required_if:occupation_status,!=,not_working|integer',
            'work_state_id'             => 'required_if:occupation_status,!=,not_working|integer',
            'current_country_id'        => 'required_if:occupation_status,not_working|integer',
            'current_state_id'          => 'required_if:occupation_status,not_working|integer',
            'father_name'               => 'nullable|string',
            'father_occupation'         => 'nullable|string',
            'mother_name'               => 'nullable|string',
            'mother_occupation'         => 'nullable|string',
            'no_of_siblings'            => 'nullable|integer',
            'family_status_id'          => 'required|integer',
            'family_values_id'          => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $registration_data = Session::get('registration_data');
        Session::put('registration_data', array_merge($registration_data, $request->all()));

        return redirect()->route('register.step4');
    }

    // Step 4: Show lifestyle and partner preferences form
    public function showStep4Form()
    {
        if (Session::has('registration_data')) {
            $registration_data = Session::get('registration_data');
            $diets = \App\Models\Diet::all();
            $disabilities = \App\Models\Disability::all();
            $marital_statuses = \App\Models\MaritalStatus::all();
            $countries = \App\Models\Country::where('status', 1)->get();
            $religions = \App\Models\Religion::all();
            $heights = get_heights();
            $annual_salary_ranges = \App\Models\AnnualSalaryRange::all();

            return view('frontend.multistep_registration.step4', compact('registration_data', 'diets', 'disabilities', 'marital_statuses', 'countries', 'religions', 'heights', 'annual_salary_ranges'));
        }
        return redirect()->route('register');
    }

    // Step 4: Handle form submission
    public function postStep4Form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'introduction'                  => 'required|string|max:500',
            'diet_id'                       => 'required|integer',
            'disability_id'                 => 'nullable|integer',
            'manglik'                       => 'required|in:yes,no,notsure',
            'time_of_birth'                 => 'nullable|string',
            'place_of_birth'                => 'nullable|string',
            'partner_min_age'               => 'nullable|integer',
            'partner_max_age'               => 'nullable|integer',
            'partner_height_id'             => 'nullable|integer',
            'partner_religion_id'           => 'nullable|integer',
            'partner_marital_status_id'     => 'nullable|integer',
            'partner_diet_id'               => 'nullable|integer',
            'partner_manglik'               => 'nullable|in:yes,no,notsure',
            'partner_income_id'             => 'nullable|integer',
            'preferred_countries'           => 'nullable|array',
            'preferred_states'              => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $registration_data = Session::get('registration_data');
        Session::put('registration_data', array_merge($registration_data, $request->all()));

        return redirect()->route('register.step5');
    }

    // Step 5: Show photo upload and verification form
    public function showStep5Form()
    {
        if (Session::has('registration_data')) {
            $registration_data = Session::get('registration_data');
            return view('frontend.multistep_registration.step5', compact('registration_data'));
        }
        return redirect()->route('register');
    }

    // Step 5: Finalize and create user
    public function finalize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'             => 'required',
            'gallery_images'    => 'nullable|array',
            'gov_id_proof'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $registration_data = Session::get('registration_data');
        $all_data = array_merge($registration_data, $request->all());

        // Create the user and profile
        $user = $this->createUser($all_data);

        // Clear session data
        Session::forget('registration_data');

        // Handle verification based on country code
        if (isset($all_data['country_code']) && $all_data['country_code'] == '91') {
            SmsUtility::sendSMSVerificationCode($user->phone, $user->code);
            flash(translate('Registration successful. A verification code has been sent to your phone number. Please enter the code to verify your account.'))->success();
            return redirect()->route('verification.notice');
        } else {
            try {
                $user->sendEmailVerificationNotification();
                flash(translate('Registration successful. A verification email has been sent to your email address. Please verify your account.'))->success();
                return redirect()->route('verification.notice');
            } catch (\Exception $e) {
                flash(translate('Registration successful. Please verify your email to activate your account.'))->success();
                return redirect()->route('verification.notice');
            }
        }
    }

    protected function createUser(array $data)
    {
        $approval = get_setting('member_verification') == 1 ? 0 : 1;

        $user = new User;
        $user->first_name  = $data['first_name'];
        $user->last_name   = $data['last_name'];
        $user->membership  = 1;
        $user->email       = $data['email'] ?? null;
        $user->phone       = isset($data['phone']) ? '+' . $data['country_code'] . $data['phone'] : null;
        $user->password    = Hash::make($data['password']);
        $user->code        = unique_code();
        $user->approved    = $approval;
        $user->photo       = $data['photo'] ?? null;
        $user->user_type   = 'member';
        $user->save();

        // Member Model
        $member = new Member;
        $member->user_id = $user->id;
        $member->gender = $data['gender'];
        $member->on_behalves_id = $data['on_behalf'];
        $member->looking_for = $data['looking_for'];
        $member->birthday = date('Y-m-d', strtotime($data['date_of_birth']));
        $member->marital_status_id = $data['marital_status'];
        $member->introduction = $data['introduction'];
        $member->mother_tongue = $data['mother_tongue'] ?? null;
        $member->known_languages = isset($data['known_languages']) ? json_encode($data['known_languages']) : '[]';
        $member->save();

        // Address Model (Present Address)
        $address = new Address;
        $address->user_id = $user->id;
        $address->country_id = $data['residence_country'];
        $address->state_id = $data['residence_state'];
        $address->city_id = $data['residence_city'];
        $address->type = 'present';
        $address->save();

        // Physical Attribute Model
        $physicalAttribute = new PhysicalAttribute;
        $physicalAttribute->user_id = $user->id;
        $physicalAttribute->height = $data['height'];
        $physicalAttribute->save();

        // Spiritual Background Model
        $spiritualBackground = new SpiritualBackground;
        $spiritualBackground->user_id = $user->id;
        $spiritualBackground->religion_id = $data['religion'];
        $spiritualBackground->caste_id = $data['caste'];
        $spiritualBackground->sub_caste = $data['sub_caste'] ?? null;
        $spiritualBackground->manglik = $data['manglik'];
        $spiritualBackground->save();

        // Educational and Career Models
        if (isset($data['education_level_id'])) {
            $education = new Education;
            $education->user_id = $user->id;
            $education->education_level_id = $data['education_level_id'];
            $education->save();
        }

        $career = new Career;
        $career->user_id = $user->id;
        $career->occupation_status = $data['occupation_status'];
        if ($data['occupation_status'] != 'not_working') {
            $career->occupation_id = $data['occupation_id'];
            $career->annual_income_id = $data['annual_income_id'];
            $career->working_country_id = $data['work_country_id'];
            $career->working_state_id = $data['work_state_id'];
        } else {
            // Save address if not working
            $address = new Address;
            $address->user_id = $user->id;
            $address->country_id = $data['current_country_id'];
            $address->state_id = $data['current_state_id'];
            $address->save();
        }
        $career->save();

        // Family Model
        $family = new Family;
        $family->user_id = $user->id;
        $family->father_name = $data['father_name'] ?? null;
        $family->father_occupation = $data['father_occupation'] ?? null;
        $family->mother_name = $data['mother_name'] ?? null;
        $family->mother_occupation = $data['mother_occupation'] ?? null;
        $family->no_of_siblings = $data['no_of_siblings'] ?? null;
        $family->family_status_id = $data['family_status_id'];
        $family->family_values_id = $data['family_values_id'];
        $family->save();

        // Lifestyle Model
        $lifestyle = new Lifestyle;
        $lifestyle->user_id = $user->id;
        $lifestyle->diet_id = $data['diet_id'];
        $lifestyle->disability_id = $data['disability_id'] ?? null;
        $lifestyle->save();

        // Hobbies Model (if needed, based on lifestyle info)
        $hobby = new Hobby;
        $hobby->user_id = $user->id;
        $hobby->save();

        // Partner Expectation Model
        $partnerExpectation = new PartnerExpectation;
        $partnerExpectation->user_id = $user->id;
        $partnerExpectation->min_age = $data['partner_min_age'] ?? null;
        $partnerExpectation->max_age = $data['partner_max_age'] ?? null;
        $partnerExpectation->height = $data['partner_height_id'] ?? null;
        $partnerExpectation->religion_id = $data['partner_religion_id'] ?? null;
        $partnerExpectation->marital_status_id = $data['partner_marital_status_id'] ?? null;
        $partnerExpectation->diet_id = $data['partner_diet_id'] ?? null;
        $partnerExpectation->manglik = $data['partner_manglik'] ?? null;
        $partnerExpectation->income_id = $data['partner_income_id'] ?? null;
        $partnerExpectation->preferred_countries = isset($data['preferred_countries']) ? json_encode($data['preferred_countries']) : null;
        $partnerExpectation->preferred_states = isset($data['preferred_states']) ? json_encode($data['preferred_states']) : null;
        $partnerExpectation->save();

        // Astrology Model
        $astrology = new Astrology;
        $astrology->user_id = $user->id;
        $astrology->time_of_birth = $data['time_of_birth'] ?? null;
        $astrology->place_of_birth = $data['place_of_birth'] ?? null;
        $astrology->save();

        // Additional Member Info
        $additionalInfo = new AdditionalMemberInfo;
        $additionalInfo->user_id = $user->id;
        $additionalInfo->additional_attribute_id = 1;
        $additionalInfo->value = $data['instagram_id'] ?? null;
        $additionalInfo->save();

        return $user;
    }
}