<?php

namespace App\Http\Controllers;

use App\Events\UserActivityChanged;
use App\Events\UserStatusChanged;
use App\Models\PhoneVerification;
use App\Models\User;
use Auth;
use GuzzleHttp\Client;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;
use Storage;
use Str;

class UserController extends Controller
{
    public function index_clients()
    {
        session(['title' => 'Staff']);
        $role = 'clients';
        $users = User::where('role', 'client')->orderBy('id', 'desc')->get();

        return view('users.index', compact('users', 'role'));
    }

    public function activate($id)
    {
        $user = User::find($id);
        if ($user->active == 0) {
            $user->active = 1;
            $message = 'client has been activated';
        } else {
            $user->active = 0;
            $message = 'client has been de-activated';
        }
        $user->save();

        return redirect()->back()->with(['message' => $message]);
    }

    public function create()
    {

        $user = new User;

        return view('users.create', compact('user'));
    }

    public function show($id)
    {
        session(['title' => 'Show Post']);
        $user = User::find($id);

        if (! $user) {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found'], 404);
        }

        return view('users.show', compact('user'));
    }

    public function getProfile(Request $request)
    {
        $user = User::with(['users', 'impacts'])
            ->withCount(['users', 'impacts'])
            ->find(Auth::id());

        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->first_name = ! is_null($request->first_name) ? $request->first_name : $user->first_name;
        $user->last_name = ! is_null($request->phone) ? $request->phone : $user->phone;
        $user->phone = ! is_null($request->phone) ? $request->phone : $user->phone;
        $user->email = ! is_null($request->email) ? $request->email : $user->email;
        $user->password = ! is_null($request->password) ? $request->password : $user->password;
        $user->save();

        return response()->json($user);
    }

    public function registerClient(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'position' => 'required',
                'username' => 'required',
                'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation rule for image upload
            ]);

            // Create a new User instance
            $user = new User;

            // Assign basic user information
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->position = $request->position;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->role = 'client';

            // Save the user record
            $user->save();

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                $profilePic = $request->file('profile_pic');
                $imageName = time().'.'.$profilePic->getClientOriginalExtension();
                $profilePic->move(public_path('profile_pics'), $imageName);
                $user->profile_pic = $imageName;
                $user->save();
            }

            // Create an access token
            $access_token_example = $user->createToken('LaravelAuthApp')->accessToken;
            $user->token = $access_token_example;

            if ($request->ajax()) {
                // Return JSON response with user information
                return response()->json([
                    'message' => 'User has been created successfully',
                    'user' => $user,
                ], 200);
            } else {
                // Redirect back with a success message
                return redirect()->route('index.clients')->with('success', 'User has been created successfully');
            }
        } catch (Exception $e) {
            // Handle exceptions as needed...

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred.'], 500);
            } else {
                // Redirect back with an error message
                return redirect()->route('index.clients')->with('error', 'An error occurred.');
            }
        }
    }

    public function uploadImage(Request $request)
    {
        $user = new User;
        $array = [];
        foreach ($request->file('images') as $image) {
            $str = Str::random(30);
            $uniqueFileName = $str.'.'.$image->getClientOriginalExtension();
            $url = url(Storage::url($image->storeAs('/images', $uniqueFileName, 'public')));
            array_push($array, $url);
        }
        $user->images = $array;
        $user->save();

        return response()->json($user);

    }

    public function loginUserExample(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Build login credentials array
        $login_credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'active' => 1,
        ];

        if (auth()->attempt($login_credentials)) {
            $user = auth()->user();

            // Check if the user has already logged in today
            $lastLoginTime = $user->last_login ? now()->parse($user->last_login) : null;

            if ($lastLoginTime === null || $lastLoginTime->lt(now()->startOfDay())) {
                // Update the last login time
                $user->last_login = now();
                $user->save();

                // Continue with the login process
                $user->online = true;
                $user->last_activity = now();
                $user->save();

                $user_login_token = $user->createToken('LaravelAuthApp')->accessToken;
                $user->token = $user_login_token;

                // Broadcast the user status change event
                broadcast(new UserStatusChanged($user));

                return response()->json($user, 200);
            } else {
                // User has already logged in today, deny login
                return response()->json(['error' => $user->name.' has already logged in today. You can only log in once a day.'], 401);
            }
        } else {
            // Wrong login credentials, return an error indicating unauthorized access
            return response()->json(['error' => 'Wrong login credentials, Unauthorized Access'], 401);
        }
    }

    // Helper method to get accurate location using HTML5 Geolocation API
    public function getAccurateLocation($ipAddress)
    {
        $apiKey = config('services.ipinfo.api_key');
        $apiUrl = "http://ipinfo.io/{$ipAddress}?token={$apiKey}";

        $client = new Client();
        $response = $client->get($apiUrl);
        $data = json_decode($response->getBody(), true);

        return [
            'latitude' => $data['loc'] ? explode(',', $data['loc'])[0] : null,
            'longitude' => $data['loc'] ? explode(',', $data['loc'])[1] : null,
            'formatted_address' => $data['city'] ?? 'Location not available',
        ];
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);
        $user = User::where('phone', $request->phone)->first();
        if (is_null($user)) {
            return response()->json(['code' => 0, 'message' => 'User with this phone number '.$request->phone.' does not exist']);
        }

        if ($user->active == 0) {
            return response()->json(['code' => 0, 'message' => 'User account has been de-activated']);
        }

        $pv = PhoneVerification::where('phone', $request->phone)->first();
        if (is_null($pv)) {
            $pv = new PhoneVerification;
        }
        $pv->phone = $user->phone;
        $pv->code = $this->generateRandomCode(5);
        $pv->verified = 0;
        $pv->save();

        $this->sms->sendCode($pv->phone, $pv->code);

        return response()->json(['code' => 1, 'message' => 'A verification code has been sent to this phone number '.$user->phone]);
    }

    public function generateRandomCode($length = 5)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required',
        ]);

        $pv = PhoneVerification::where('phone', $request->phone)
            ->where('code', $request->code)->first();

        if (is_null($pv)) {
            return response()->json(['code' => 0, 'message' => 'Verification code is incorrect']);
        }

        $pv->verified = 1;
        $pv->save();

        return response()->json(['code' => 1, 'message' => 'User has been verified']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (is_null($user)) {
            return response()->json(['code' => 0, 'message' => 'User does not exist']);
        }

        $pv = PhoneVerification::where('phone', $user->phone)->first();
        if (is_null($pv)) {
            return response()->json(['code' => 0, 'message' => 'User can not reset password at this time.']);
        }
        if ($pv->verified == 0) {
            return response()->json(['code' => 0, 'message' => 'User can not reset password at this time.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $pv->verified = 0;
        $pv->save();

        return response()->json(['code' => 1, 'message' => 'User has reset password successfully.']);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->online = false;
        $user->last_logout = now();
        $user->save();
    }

    public function updateUserStatus(Request $request)
    {
        $user = auth()->user();

        // Update user's online status based on the request data
        $user->online = $request->input('active');
        $user->save();

        // Broadcast the user status change event
        broadcast(new UserStatusChanged($user));
    }

    public function updateUserActivity($user_id)
    {
        $user = User::find($user_id);

        // Your logic to update user activity

        event(new UserActivityChanged($user));

        // Return the response or redirect as needed
    }

    public function confirmDelete($id)
    {
        session(['title' => 'Confirm Delete']);
        $user = User::find($id);

        return view('users.confirm_delete', compact('user'));
    }

    public function deletePost(Request $request)
    {
        $user = User::find($request->id);

        if ($user) {
            // Delete associated posts
            $user->posts()->delete();

            // Now, delete the user
            $user->delete();

            return redirect()->route('index.clients')->with('success', 'User and associated posts have been deleted successfully');
        } else {
            return redirect()->route('index.clients')->with('error', 'User not found');
        }
    }
}
