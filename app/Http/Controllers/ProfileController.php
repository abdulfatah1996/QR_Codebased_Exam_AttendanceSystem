<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colleges = College::all();
        $id = Auth::user()->id;
        $profile = Profile::all()->where('user_id', $id)->first();

        if ($profile == null) {
            $profile = new Profile();
            $profile->user_id = Auth::user()->id;
            $profile->save();
        }
        // return $profile;
        return view('admin.profile.index', compact('colleges', 'profile'));
    }


    public function PersonalInformationUpdate(Request $request)
    {
        $user = User::all()->find(Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            // 'password' => 'required|string|min:8|confirmed',
            // 'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return response()->json([
                'status' => true,
                'success' => 'Personal Information updated .',
            ]);
        }
    }

    public function PasswordUpdate(Request $request)
    {
        $user = User::all()->find(Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|same:password-confirm',
            // 'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return response()->json([
                'status' => true,
                'success' => 'Password updated .',
            ]);
        }
    }


    public function ProfileInfoUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'address' => 'required',
            'age' => 'required',
            'college_id' => 'required',
            'degree' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {

            $id = Auth::user()->id;
            $profile = Profile::all()->where('user_id', $id)->first();
            $profile->user_id  = Auth::user()->id;
            $profile->phone  = $request->phone;
            $profile->address  = $request->address;
            $profile->age  = $request->age;
            $profile->college_id  = $request->college_id;
            $profile->degree  = $request->degree;
            $profile->gender  = $request->gender;

            $profile->save();
            return response()->json([
                'success' => 'Your profile has been successfully modified.',
            ]);
        }
    }
}
