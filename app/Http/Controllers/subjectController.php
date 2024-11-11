<?php

namespace App\Http\Controllers;

use App\Models\StudentSubject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class SubjectController extends Controller
{
    public function index()
    {
        $studentSubjects = StudentSubject::with('student')->get();
        return view('subjects.index', compact('studentSubjects'));
    }

    public function create()
    {
        $students = Student::all();
        return view('subjects.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_number' => 'required|exists:students,student_number',
            'subject_code' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            // التحقق إذا كان الطلب AJAX
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
    
        $student = Student::where('student_number', $request->student_number)->first();
    
        StudentSubject::create([
            'student_number' => $student->student_number,
            'subject_code' => $request->subject_code,
            'subject_name' => $request->subject_name,
        ]);
    
        if ($request->ajax()) {
            return response()->json(['success' => 'تم إضافة المادة بنجاح.']);
        } else {
            return redirect()->route('subjects')
                ->with('success', 'تم إضافة المادة بنجاح.');
        }
    }
    

    public function show(StudentSubject $studentSubject)
    {
        $studentSubject->load('student');
        return view('subjects.show', compact('studentSubject'));
    }

    public function edit($id)
    {
        $studentSubject = StudentSubject::find($id);
        return view('subjects.edit', compact('studentSubject'));
    }

    public function update(Request $request, StudentSubject $studentSubject)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'student_number' => 'required|exists:students,student_number',
            'subject_code' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            // إعادة التوجيه مع عرض الأخطاء
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // العثور على الطالب بناءً على رقم القيد
        $student = Student::where('student_number', $request->student_number)->first();

        // تحديث المادة
        $studentSubject->update([
            'student_number' => $student->student_number,
            'subject_code' => $request->subject_code,
            'subject_name' => $request->subject_name,
        ]);

        return response()->json(['message' => 'تم التعديل بنجاح.']);
    }
    public function destroy($id)
{
    $studentSubject = StudentSubject::find($id);

    if (!$studentSubject) {
        return redirect()->route('subjects')->with('error', 'المادة غير موجودة.');
    }

    $studentSubject->delete();

    return redirect()->route('subjects')->with('success', 'تم حذف المادة بنجاح');
}

public function deleteAll()
{
    $studentSubjects = StudentSubject::all();

    if ($studentSubjects->isEmpty()) {
        return redirect()->route('subjects')->with('error', 'لا توجد مواد لحذفها.');
    }

    // حذف جميع المواد
    StudentSubject::query()->delete();

    return redirect()->route('subjects')->with('success', 'تم حذف جميع المواد بنجاح');
}


}
