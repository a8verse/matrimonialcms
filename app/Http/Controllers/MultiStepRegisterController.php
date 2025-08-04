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
        $marital_statuses = \App\Models\MaritalStatus::all();
        $annual_salary_ranges = \App\Models\AnnualSalaryRange::all();

        return view('frontend.multistep_registration.step1', compact('on_behalves', 'marital_statuses', 'annual_salary_ranges'));
    }

    // Step 1: Handle form submission
    public function postStep1Form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'on_behalf'            => 'nullable|integer',
            'first_name'           => ['required', 'string', 'max:255'],
            'last_name'            => ['required', 'string', 'max:255'],
            'gender'               => 'required',
            'date_of_birth'        => 'required|date',
            'marital_status'       => 'required',
            'annual_salary_range'  => 'required',
            'phone'                => 'required_without:email|nullable|string|unique:users',
            'email'                => 'required_without:phone|nullable|email|unique:users',
            'password'             => ['required', 'string', 'min:8', 'confirmed'],
            'photo'                => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation failed.');
        }

        Session::put('registration_data', $request->all());
        return redirect()->route('register.step2');
    }

    // Step 2: Show profile details form
    public function showStep2Form()
    {
        if (Session::has('registration_data')) {
            $registration_data = Session::get('registration_data');
            $religions = \App\Models\Religion::all();
            $countries = \App\Models\Country::where('status', 1)->get();
            $family_values = \App\Models\FamilyValue::all();

            return view('frontend.multistep_registration.step2', compact('registration_data', 'religions', 'countries', 'family_values'));
        }
        return redirect()->route('register');
    }

    // Step 2: Handle form submission
    public function postStep2Form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'religion' => 'required|integer',
            'caste' => 'required|integer',
            'sub_caste' => 'nullable|integer',
            'height' => 'nullable|numeric',
            'country' => 'required|integer',
            'state' => 'required|integer',
            'city' => 'required|integer',
            'postal_code' => 'required|string',
            'father' => 'nullable|string',
            'father_occupation' => 'nullable|string',
            'mother' => 'nullable|string',
            'mother_occupation' => 'nullable|string',
            'no_of_brothers' => 'nullable|integer',
            'no_of_sisters' => 'nullable|integer',
            'about_parents' => 'nullable|string',
            'about_siblings' => 'nullable|string',
            'about_relatives' => 'nullable|string',
            'birth_country_id' => 'nullable|integer',
            'recidency_country_id' => 'nullable|integer',
            'growup_country_id' => 'nullable|integer',
            'immigration_status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $registration_data = Session::get('registration_data');
        Session::put('registration_data', array_merge($registration_data, $request->all()));
        
        return redirect()->route('register.step3');
    }

    // Step 3: Show hobbies & lifestyle form
    public function showStep3Form()
    {
        if (Session::has('registration_data')) {
            $registration_data = Session::get('registration_data');
            $languages = \App\Models\MemberLanguage::all();
            
            return view('frontend.multistep_registration.step3', compact('registration_data', 'languages'));
        }
        return redirect()->route('register');
    }

    // Step 3: Handle form submission
    public function postStep3Form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'diet' => 'nullable|string',
            'drink' => 'nullable|string',
            'smoke' => 'nullable|string',
            'living_with' => 'nullable|string',
            'affection' => 'nullable|string',
            'humor' => 'nullable|string',
            'political_views' => 'nullable|string',
            'religious_service' => 'nullable|string',
            'hobbies' => 'nullable|string',
            'interests' => 'nullable|string',
            'music' => 'nullable|string',
            'books' => 'nullable|string',
            'movies' => 'nullable|string',
            'tv_shows' => 'nullable|string',
            'sports' => 'nullable|string',
            'fitness_activities' => 'nullable|string',
            'cuisines' => 'nullable|string',
            'dress_styles' => 'nullable|string',
            'sun_sign' => 'nullable|string',
            'moon_sign' => 'nullable|string',
            'time_of_birth' => 'nullable|string',
            'city_of_birth' => 'nullable|string',
            'mother_tongue' => 'nullable|integer',
            'known_languages' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $registration_data = Session::get('registration_data');
        Session::put('registration_data', array_merge($registration_data, $request->all()));
        
        return redirect()->route('register.step4');
    }

    // Step 4: Show partner expectations & finalize form
    public function showStep4Form()
    {
        if (Session::has('registration_data')) {
            $registration_data = Session::get('registration_data');
            $marital_statuses = \App\Models\MaritalStatus::all();
            $countries = \App\Models\Country::where('status', 1)->get();
            $religions = \App\Models\Religion::all();
            $family_values = \App\Models\FamilyValue::all();
            $additional_attributes = \App\Models\AdditionalAttribute::where('status', 1)->get();

            return view('frontend.multistep_registration.step4', compact('registration_data', 'marital_statuses', 'countries', 'religions', 'family_values', 'additional_attributes'));
        }
        return redirect()->route('register');
    }

    // Step 4: Finalize and create user
    public function finalize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_marital_status' => 'required|integer',
            'partner_religion_id' => 'required|integer',
            'partner_caste_id' => 'nullable|integer',
            'residence_country_id' => 'required|integer',
            'partner_height' => 'nullable|numeric',
            'introduction' => 'required|string',
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

        // Redirect to login or dashboard
        if (get_setting('member_verification') != 1) {
            Auth::login($user);
        }

        flash(translate('Registration successfull. Please login to your account.'))->success();
        return redirect()->route('login');
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
        $member->on_behalves_id = $data['on_behalf'] ?? null;
        $member->birthday = date('Y-m-d', strtotime($data['date_of_birth']));
        $member->marital_status_id = $data['marital_status'];
        $member->annual_salary_range_id = $data['annual_salary_range'];
        $member->introduction = $data['introduction'] ?? null;
        $member->mothere_tongue = $data['mother_tongue'] ?? null;
        $member->known_languages = isset($data['known_languages']) ? json_encode($data['known_languages']) : '[]';
        $member->save();

        // Address Model (Present Address)
        $address = new Address;
        $address->user_id = $user->id;
        $address->country_id = $data['country'] ?? null;
        $address->state_id = $data['state'] ?? null;
        $address->city_id = $data['city'] ?? null;
        $address->postal_code = $data['postal_code'] ?? null;
        $address->type = 'present';
        $address->save();
        
        // Physical Attribute Model
        $physicalAttribute = new PhysicalAttribute;
        $physicalAttribute->user_id = $user->id;
        $physicalAttribute->height = $data['height'] ?? null;
        // Add other physical attributes here
        $physicalAttribute->save();
        
        // Spiritual Background Model
        $spiritualBackground = new SpiritualBackground;
        $spiritualBackground->user_id = $user->id;
        $spiritualBackground->religion_id = $data['religion'] ?? null;
        $spiritualBackground->caste_id = $data['caste'] ?? null;
        $spiritualBackground->sub_caste_id = $data['sub_caste'] ?? null;
        // Add other spiritual background fields here
        $spiritualBackground->save();

        // Lifestyle Model
        $lifestyle = new Lifestyle;
        $lifestyle->user_id = $user->id;
        $lifestyle->diet = $data['diet'] ?? null;
        $lifestyle->drink = $data['drink'] ?? null;
        $lifestyle->smoke = $data['smoke'] ?? null;
        $lifestyle->living_with = $data['living_with'] ?? null;
        $lifestyle->save();

        // Hobbies Model
        $hobby = new Hobby;
        $hobby->user_id = $user->id;
        $hobby->hobbies = $data['hobbies'] ?? null;
        $hobby->interests = $data['interests'] ?? null;
        $hobby->music = $data['music'] ?? null;
        $hobby->books = $data['books'] ?? null;
        $hobby->movies = $data['movies'] ?? null;
        $hobby->tv_shows = $data['tv_shows'] ?? null;
        $hobby->sports = $data['sports'] ?? null;
        $hobby->fitness_activities = $data['fitness_activities'] ?? null;
        $hobby->cuisines = $data['cuisines'] ?? null;
        $hobby->dress_styles = $data['dress_styles'] ?? null;
        $hobby->save();

        // Attitude Model
        $attitude = new Attitude;
        $attitude->user_id = $user->id;
        $attitude->affection = $data['affection'] ?? null;
        $attitude->humor = $data['humor'] ?? null;
        $attitude->political_views = $data['political_views'] ?? null;
        $attitude->religious_service = $data['religious_service'] ?? null;
        $attitude->save();
        
        // Astronomic Information
        $astrology = new Astrology;
        $astrology->user_id = $user->id;
        $astrology->sun_sign = $data['sun_sign'] ?? null;
        $astrology->moon_sign = $data['moon_sign'] ?? null;
        $astrology->time_of_birth = $data['time_of_birth'] ?? null;
        $astrology->city_of_birth = $data['city_of_birth'] ?? null;
        $astrology->save();

        // Partner Expectation Model
        $partnerExpectation = new PartnerExpectation;
        $partnerExpectation->user_id = $user->id;
        $partnerExpectation->general = $data['general'] ?? null;
        $partnerExpectation->residence_country_id = $data['residence_country_id'] ?? null;
        $partnerExpectation->marital_status_id = $data['partner_marital_status'] ?? null;
        $partnerExpectation->religion_id = $data['partner_religion_id'] ?? null;
        $partnerExpectation->caste_id = $data['partner_caste_id'] ?? null;
        $partnerExpectation->sub_caste_id = $data['partner_sub_caste_id'] ?? null;
        $partnerExpectation->height = $data['partner_height'] ?? null;
        $partnerExpectation->save();
        
        // Additional Member Info
        $additionalInfo = new AdditionalMemberInfo;
        $additionalInfo->user_id = $user->id;
        $additionalInfo->additional_attribute_id = 1; // Assuming 1 is the ID for Instagram
        $additionalInfo->value = $data['instagram_id'] ?? null;
        $additionalInfo->save();
        
        // Email verification notification to admin
        // ... (remaining notification code)
        
        return $user;
    }
}
