<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\StudentProfile;
use App\Models\ProjectApplication;
use App\Models\StudentProject;

class MainController extends Controller
{
    public function homePage()
    {
        $inps = User::where('user_type','inp')->paginate(5);
        return view('home',['inps'=>$inps]);
    }

/**
 * Trigger Auto Assignment By Teacher.
 * 
 * This function automates the assignment of students to projects for a given academic offering (year and trimester).
 * It considers factors such as student  project applications, and previous assignments.
 * The function saves the assignment results in the database and provides feedback to the teacher.
 *

 * */


public function autoAssign(Request $request)
{
    // Validate the academic offering (year and trimester)
    $request->validate([
        'trimester' => 'required|integer|between:1,3',
        'year' => 'required|integer|digits:4',
    ]);

    // Initialize an array to store the shortlisted student ids
    $assignedStudentIds = [];

    // Retrieve all projects within the specified offering
    $projects = Project::where('year', $request->year)->where('trimester', $request->trimester)->get();
    

    // Loop through each project and assign students
    foreach ($projects as $project) {

        // Determine the number of students needed for this project
        $requiredStudents = $project->num_students;

        // Initialize blank assigned students ids 
        $shortListedStudentIds = [];


        // Retrieve all unique student IDs who have applied to any of $projects
        $student_ids = ProjectApplication::where('project_id',$project->id)->distinct('user_id')->pluck('user_id')->toArray();

        // Get students with the retrieved IDs
        $students = User::whereIn('id', $student_ids)->get();

        // Loop through students and assign them to this project
        foreach ($students as $student) {

            $isApplied = ProjectApplication::where('project_id',$project->id)->where('user_id',$student->id)->exists();

            if($isApplied)
            {     
                // Check if the student has not been assigned to another project
                $isSelected = StudentProject::where('user_id', $student->id)->where('project_id', $project->id)->exists();

                // Check if not already selected
                if ($isSelected == false) {
                    // Assign the student to the project
                    $shortListedStudentIds[] = $student->id;
                    $assignedStudentIds[] = $student->id;

                    // Check if required students have been assigned
                    if (count($shortListedStudentIds) == $requiredStudents) {
                        break;
                    }
                }
            }

        }

        // Save the student project assignments
        foreach ($shortListedStudentIds as $studentId) {
            $studentProject = new StudentProject;
            $studentProject->user_id = $studentId;
            $studentProject->project_id = $project->id;
            $studentProject->save();
        }
    }

    if (count($assignedStudentIds) > 0) {
        return redirect()->back()->with('success', count($assignedStudentIds) . ' students have been assigned to the projects.');
    } else {
        return redirect()->back()->with('error', 'No students have been assigned to the projects.')->withInput();
    }
}


    
}
