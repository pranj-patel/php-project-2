<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\StudentProfile;

use Auth;
class UserController extends Controller
{



    /**
     * Handle user login.
     *
     * This function performs user login by validating the user's email and password,
     * checking if the email is registered, and attempting authentication.
     * If the login is successful, the user is redirected to the home page with a success message.
     * If authentication fails, the user is redirected back to the login page with an error message.
     *
     */
        public function login(Request $request)
        {
            // Validate user input
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $chk_user = User::where('email',$request->email)->first();
            if(!$chk_user)
            {
                return redirect('register')->with('error','This email not register with us. Please register to continue.');
            }

            // Attempt to authenticate the user
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication successful
                return redirect('/')->with('success','Welcome you are logged in.'); // Redirect to the home after registration
            } else {
                // Authentication failed
                return redirect()->back()->withInput()->with('error','Invalid credentials');
            }
        }



/**
 * Handle user registration.
 *
 * This function performs user registration by checking if the email is already registered,
 * validating the registration form fields, creating a new user, and logging in the user.
 * If registration is successful, the user is redirected to the home page with a success message.
 * If the email is already registered, the user is redirected to the login page with an error message.
 *
 */
        
    public function register(Request $request)
    {        
        $chk_user = User::where('email',$request->email)->first();
        if($chk_user)
        {
            return redirect('login')->with('error','This email is already registered. Please login to continue.');
        }

        // validate registration form fields 
        $request->validate([
            'username' => 'required|unique:users|min:6',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'user_type' => 'required',
        ]);
    
        // Create a new user
        $user               =  new User;
        $user->username     =  $request->username;
        $user->email        =  $request->email;
        $user->user_type    =  $request->user_type;
        $user->password     =  bcrypt($request->password);
        $user->save();

        //  login the user
        Auth::login($user);

        return redirect('/')->with('success','Welcome you are registered and logged in.'); // Redirect to the home after registration
    }


/**
 * Display detailed information about an Industry Partner (InP) and their projects.
 *
 */
    public function inpDetail($id)
    {
        $inp = User::find($id);
        $projects = Project::where('inp_id',$id)->get();
        return view('inp.detail',['inp'=>$inp,'projects'=>$projects]);
    }


    public function updateStudentProfile(Request $request)
    {
        // Perform the necessary validations for updating the student's profile
        $request->validate([
            'gpa' => 'required|numeric|between:0,7',
            'roles' => 'required|array|min:1', // At least one role must be selected
            'skills' => 'string|nullable',
            'portfolio_link' => 'url|nullable',
        ]);
    
        $student_id = Auth::user()->id;
    
        // Retrieve the student's profile or create a new one if it doesn't exist
        $profile = StudentProfile::where('user_id', $student_id)->first() ?? new StudentProfile;
    
        // Update the profile information based on the form data
        $profile->user_id = $student_id;
        $profile->gpa = $request->input('gpa');
        $profile->skills = $request->input('skills');
    

        
        
        // Convert roles array to a comma-separated string and save it to the profile
        $roles = implode(',', $request->input('roles'));
        $profile->roles = $roles;
    
        // Save the updated or newly created profile
        $profile->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    

/**
 * Show a student's profile.
 *
 * This function displays a student's profile based on the provided student ID.
 * If the currently authenticated user is an InP (Industry Partner), they cannot access student profiles.
 * It retrieves the student's profile information and renders it in the 'user.profile' view.
 *
 */
    public function showProfile($id)
    {

        $user = Auth::user();

        if($user->user_type === 'inp')
        {
            return redirect()->back()->with('error','You cannot access student profile page.');
        }


        $student_id = $id;
        $profile = StudentProfile::where('user_id', $student_id)->first();

        return view('user.profile',['profile'=>$profile]);
    }


/**
 * Approve an InP (Industry Partner) by Teacher for creating projects.
 *
 * This function approves an InP by updating their 'approved' status to 1,
 * indicating that they are approved to create projects.
 *
 */

    public function approveInp($id)
    {
        
        $inp = User::find($id);
        $inp->approved = 1;
        $inp->save();

        return redirect()->back()->with('success', 'Inp '.$inp->name.' Approved for creating projects');
    }


    
/**
 * Handle user logout.
*/
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('success','You are logged out.'); // Redirect to the home after loggin out

    }
}
