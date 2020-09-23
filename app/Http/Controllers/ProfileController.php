<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserProfile;
use Session;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response   
     */
    public function index()
    {
        $users = User::with('role', 'profile')->paginate(5);
        //dd($users);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $countries = Country::all();

        return view('admin.users.create', compact('roles', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request)
    {

        if($request->has('thumbnail')) {
            $name = basename($request->thumbnail->getClientOriginalName());
            $name = $name;
            $path = $request->thumbnail->move('images/profiles', $name, 'public');
            }
           

        $user = User::create([

            'email' => $request->email, 
            'password' => bcrypt($request->password), 
            'status' => $request->status, 

        ]);

        if($user) {

            $profile = Profile::create([

                'user_id' => $user->id, 
                'name' => $request->name, 
                'thumbnail' => $request->path,
                'country_id' => $request->country_id, 
                'state_id' => $request->state_id, 
                'city_id' => $request->city_id, 
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }

        if($user && $profile)
        {


            Session::flash('success', 'User has been successfully added!');
            
            return redirect()->route('admin.profiles.create');
        }
        else {

            Session::flash('success', 'Product not added!');
            
            return redirect()->route('admin.product.create');
        }


        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $user = User::find($profile)->first();

        $roles = Role::all();

        $countries = Country::all();

        return view('admin.users.create', compact('user', 'roles', 'countries', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {


        if($request->has('thumbnail')) {

            $name = basename($request->thumbnail->getClientOriginalName());
            $name = $name;
            $path = $request->thumbnail->move('images/profiles', $name, 'public');
            $profile->thumbnail = $path;
        }

        
        $profile->name = $request->name;
        $profile->address = $request->address;
        $profile->country_id = $request->country_id;
        $profile->state_id = $request->state_id;
        $profile->city_id = $request->city_id;


        $profile->save();

        Session::flash('success', 'Profile has been successfully updated!');

        return redirect()->route('admin.profiles.create', compact('profile'));

    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {

        $users = User::where('id', $profile->user_id)->first();
        if($profile->forceDelete()) {

            $profile->delete();
            $users->delete();
            Session::flash('success', 'User has been successfully deleted!');
            return redirect()->route('admin.profiles.index', compact('profile'));
    
            }
            else {
                Session::flash('success', 'User not deleted!');
                return redirect()->route('admin.profiles.index', compact('profile'));
            }
    }

    public function getCities($id) {

        if(request()->ajax())
        return City::where('state_id', $id)->get();
        else
        return 0;

    }

    public function getStates($id) {

        if(request()->ajax())
        return State::where('country_id', $id)->get();
        else
        return 0;

    }
}
