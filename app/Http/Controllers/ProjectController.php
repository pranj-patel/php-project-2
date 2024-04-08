<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectFile;
use App\Models\StudentProfile;
use App\Models\ProjectApplication;
use App\Models\StudentProject;
use Auth;
class ProjectController extends Controller
{

/**
 * Create Project
 *
 * This function is responsible for allowing Industry Partners (InPs) to create new projects. It enforces several checks and validations to ensure the project creation process is smooth and follows the specified requirements:
 * - It verifies that the InP is approved by the teacher before allowing project creation.
 * - Validates essential project details such as title, description, number of students, trimester, year, and file types.
 * - Ensures that the project description contains at least 3 words.
 * - Checks for existing projects with the same name in the same trimester and year, preventing duplicates.
 * - Finally, it creates the new project, saves project details, and handles file uploads if provided.
 *
 * */
    public function createProject(Request $request)
    {

        $inp_id = Auth::user()->id;

        $inp = User::find($inp_id);
     

        if($inp->approved === 0)
        {
            return redirect()->back()->with('error','You need to be approved by teacher to create projects.')->withInput();
        }

        // Perform the necessary validations for project creation
        $request->validate([
            'title' => 'required|min:6',
            'description' => 'required',
            'num_students' => 'required|integer|between:3,6',
            'trimester' => 'required|integer|between:1,3',
            'year' => 'required|integer|digits:4',
            'files.*' => 'mimes:jpeg,jpg,webp,png,pdf', // Validate file types
        ]);


        // validate description word count 
        if(str_word_count($request->description) < 3)
        {
            return redirect()->back()->with('error','Project Description must be at least 3 words')->withInput();
        }


        // Check for projects with the same name in the same offering
        $check_same_name_project = Project::where('inp_id',$inp_id)->where('title',$request->title)->where('trimester',$request->trimester)->where('year',$request->year)->first();

        if($check_same_name_project)
        {
            return redirect()->back()->with('error','Project with same name could not be created in same offering(Timester and Year)')->withInput();
        }


        // Create the project
        $project = new Project;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->num_students = $request->num_students;
        $project->trimester = $request->trimester;
        $project->year = $request->year;
        $project->inp_id = $inp_id;
        $project->inp_username = $inp->username;
        $project->inp_email = $inp->email;
        $project->save();
        

         // Handle file uploads
        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {

                // Save the file and get the name

                $file_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $file->move(public_path('files'), $file_name);

                $projectFile = new ProjectFile;
                $projectFile->project_id = $project->id;
                $projectFile->name = $file_name;
                $projectFile->type = $file_extension;
                $projectFile->save();
            }
    }


        return redirect()->back()->with('success','Success! New project created');
    }   


/**
 * Display the edit form for a project.
 * This function retrieves the project with the given ID and displays a form to edit its details. It's used to allow InPs to update their projects.
 */
    public function projectEdit($id)
    {
        $project = Project::find($id);

        return view('project.edit_form', ['project' => $project]);
        
    }




/**
 * Update Project
 *
 * This function allows Industry Partners (InPs) to update an existing project that they own. It performs several validations and checks to ensure a smooth update process:
 * - Retrieves the project to be updated.
 * - Validates that the project exists and that the authenticated user is the owner (InP) of the project.
 * - Validates essential project details such as title, description, number of students, trimester, year, and file types.
 * - Ensures that the project description contains at least 3 words.
 * - Checks for existing projects with the same name in the same trimester and year, excluding the current project.
 * - Updates the project details if all validations pass.
 * - Handles file uploads if new files are provided, associating them with the project.
 *
 */

    public function updateProject(Request $request)
    {
        // Retrieve the project you want to update
        $project = Project::find($request->project_id);
    

        // Perform the necessary validations for project update
        $request->validate([
            'title' => 'required|min:6',
            'description' => 'required',
            'num_students' => 'required|integer|between:3,6',
            'trimester' => 'required|integer|between:1,3',
            'year' => 'required|integer|digits:4',
            'files.*' => 'mimes:jpeg,jpg,webp,png,pdf', // Validate file types

        ]);
    
        // validate description word count 
        if (str_word_count($request->description) < 3) {
            return redirect()->back()->with('error', 'Project Description must be at least 3 words')->withInput();
        }
    
        // Check for projects with the same name in the same of  excluding the current project
        $check_same_name_project = Project::where('inp_id', $project->inp_id)
            ->where('title', $request->title)
            ->where('trimester', $request->trimester)
            ->where('year', $request->year)
            ->where('id', '!=', $project->id) // Exclude the current project
            ->first();
    
        if ($check_same_name_project) {
            return redirect()->back()->with('error', 'Project with the same name could not be created in the same offering (Trimester and Year)')->withInput();
        }
    
        // Update the project
        $project->title = $request->title;
        $project->description = $request->description;
        $project->num_students = $request->num_students;
        $project->trimester = $request->trimester;
        $project->year = $request->year;
        $project->save();
                    

         // Handle file uploads
         if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                // Save the file and get the name
                $file_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $file->move(public_path('files'), $file_name);
                $projectFile = new ProjectFile;
                $projectFile->project_id = $project->id;
                $projectFile->name = $file_name;
                $projectFile->type = $file_extension;
                $projectFile->save();
            }
    }


        return redirect('project-detail/'.$project->id)->with('success', 'Project updated successfully');
    }
    
    


/**
 * Project Detail
 *
 * This function retrieves and displays detailed information about a specific project, including its files, student profile information, project applications, and project assignments:
 * - Retrieves the currently authenticated user's ID.
 * - Finds the project with the given ID.
 * - Retrieves project files associated with the project.
 * - Fetches the student's profile information.
 * - Retrieves project applications and joins them with user information to display usernames.
 * - Retrieves project assignments and joins them with user information to display usernames.
 * - Renders the project detail view, passing in the project, project files, student profile, project applications, and project assignments as view data.
 *
 */
public function projectDetail($id)
{

    $student_id = Auth::user()->id;


    $project = Project::find($id);
    $project_files = ProjectFile::where('project_id',$id)->get();
    $student_profile = StudentProfile::where('user_id',$student_id)->first();
    $project_applications = ProjectApplication::where('project_id',$id)->join('users','project_applications.user_id','=','users.id')->select('project_applications.*','users.username as username')->get();
    $project_assignments  = StudentProject::where('project_id',$id)->join('users','student_projects.user_id','=','users.id')->select('student_projects.*','users.username as username')->get();
    
    return view('project.detail', ['project' => $project,'project_files'=>$project_files,'student_profile'=>$student_profile,'project_applications'=>$project_applications,'project_assignments'=>$project_assignments]);
}

/**
 * Project Deletion
 *
 * This function handles the deletion of a project with the given ID. It performs the following steps:
 * - Counts the number of project applications associated with the project.
 * - If there are project applications (students have applied), it redirects back with an error message.
 * - If there are no project applications, it proceeds to delete the project:
 *   - Finds the project by its ID.
 *   - Deletes the project from the database.
 *   - Redirects to the InP detail page for the project owner (InP) with a success message.
 * 
 **/

    public function projectDelete($id)
    {

        $count_project_applications = ProjectApplication::where('project_id',$id)->count();

        if($count_project_applications > 0)
        {
            return redirect()->back()->with('error','Yo cannot delete this project because students has applied to this project.');
        }else {
            $project = Project::find($id);
            $project->delete();
            return redirect('inp-detail/'.$project->inp_id)->with('success', 'Project deleted successfully');
        }

    }

/**
 * Projects List
 *
 * This function retrieves a list of all projects and groups them by year and trimester. It performs the following steps:
 * - Retrieves all projects, ordering them by year and trimester in descending order.
 * - Groups the projects by their year and trimester attributes.
 * - Passes the grouped projects to the 'project.list' view.
 *
 **/

    public function projectsList()
    {
        // Retrieve all projects, grouping by year and trimester
        $projectsByYearTrimester = Project::orderBy('year', 'desc')
            ->orderBy('trimester', 'desc')
            ->get()
            ->groupBy(['year', 'trimester']);

        return view('project.list', compact('projectsByYearTrimester'));
    }



    /**
 * Project Application
 *
 * This function handles the submission of a project application by a student. It performs the following steps:
 * - Validates the form fields, including project selection and justification.
 * - Checks if the student has already applied to the selected project and prevents re-application.
 * - Limits the number of projects a student can apply to (maximum 3).
 * - Creates a new project application record in the database.
 * - Redirects the user with a success message.
 *
**/

    public function projectApplication(Request $request)
    {
        $student_id = Auth::user()->id;

            // Perform validation for the form fields
            $request->validate([
                'project_id' => 'required',
                'justification' => 'required|min:5',
            ]);

            $chk_application_for_this_project =  ProjectApplication::where('user_id',$student_id)->where('project_id',$request->project_id)->count();
            if($chk_application_for_this_project > 0)
            {
                return redirect()->back()->with('error','You already applied to this project. You cannot re-apply to a project.')->withInput();
            }


            $chk_user_applications = ProjectApplication::where('user_id',$student_id)->count();
            if($chk_user_applications >= 3)
            {
                return redirect()->back()->with('error','You cannot apply to more than 3 projects.')->withInput();
            }


            // Create a new project application
            $projectApplication = new ProjectApplication;
            $projectApplication->project_id = $request->project_id;
            $projectApplication->user_id = $student_id; 
            $projectApplication->justification = $request->justification;
            $projectApplication->save();

            // Redirect to a success page or project details page
            return redirect()->back()->with('success', 'Your application has been submitted successfully.');

    }
}
