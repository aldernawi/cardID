<?php

namespace App\Http\Controllers;
use App\Imports\StudentsImport;
use App\Imports\StudentSubjectsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function showForm()
    {
        return view('import');
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Students imported successfully!');
    }

    public function importStudentSubjects(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
    
        Excel::import(new StudentSubjectsImport, $request->file('file'));
    
        return redirect()->back()->with('success', 'Student Subjects imported successfully!');
    }
}
