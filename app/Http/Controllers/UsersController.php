<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        return view('users.users', compact('users'));
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    public function update(EditUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update($request->all());

        return redirect('/users');
    }
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users');
    }
    public function create()
    {
        return view('auth.register');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
             'password' => ['required', 'string', 'min:8', 'confirmed'],
         ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $data = $request->all();
        User::create([
              'name' => $data['name'],
              'email' => $data['email'],
              'password' => Hash::make($data['password']),
          ]);
        return redirect('/users');
    }
    public function editPass(User $user)
    {
        return view('users.change-password', compact('user'));
    }

    public function updatePass(Request $request, User $user)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Podane aktualne hasło jest nie prawidłowe. Proszę spróbuj jeszcze raz!");
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "Nowe hasło nie może być takie same jak poprzednie. Proszę wpisz inne hasło.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password

        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect('/users');
    }
}
