<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(){
        
        $user=Auth::user();
        $data['posts']=$user->posts()->select('content','created_at')->orderBy('created_at', 'desc')->get();
        $data['user_information']=[
            'name'=>$user->name,
            'location'=>$user->location,
            'status'=>$user->status
        ];
        $friends = $user->friends()->get();
        $data['friends']=$friends;
        return view('User.profile')->with('data',$data);
    }
    public function edit_profile(Request $request){
        $this->validate($request,[
            'status'=>'required|string|max:255',
            'location'=>'required|string|max:255'
        ]);
        $user=Auth::user();
        $user->update([
            'location'=>$request->location,
            'status'=>$request->status
        ]);
        return redirect()->route('user.profile');
    }
    public function Show(){
        return view('User.Index');
    }
    public function register(Request $request){
        $this->validate($request,[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|unique:users|email',
            'password' => 'required|string|min:6'
        ]);
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to a dashboard or home page
        return redirect()->route('home');
    }
     // Login
     public function login(Request $request)
     {
         // Validate the input
         $this->validate($request, [
             'email' => 'required|string|email',
             'password' => 'required|string',
         ]);
 
         // Attempt to log in the user
         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             return redirect()->route('home');
         }
 
         // Authentication failed, redirect back with an error message
         return back()->withErrors(['email' => 'Invalid credentials']);
     }
     public function logout()
    {
        Auth::logout(); // Log the user out
        return redirect()->route('login'); // Redirect to the login page 
    }
}
