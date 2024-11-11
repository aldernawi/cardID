<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;



class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
{
    
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'student_number' => 'required|unique:students,student_number',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return Response::json([
            'errors' => $validator->errors()
        ], 422); // HTTP status code for Unprocessable Entity
    }

    // If validation passes, create the student
    try {
        $data = $request->only('name', 'student_number');
        Student::create($data);
        return Response::json([
            'success' => 'Student created successfully.'
        ], 200); // HTTP status code for OK
    } catch (\Exception $e) {
        // Log the exception and return an error response
        Log::error('Error creating student: ' . $e->getMessage());
        return Response::json([
            'error' => 'Failed to create student.'
        ], 500); // HTTP status code for Internal Server Error
    }
}
    
    
    public function showStudentCard($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('students.card', compact('student'));
    }
    
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return view('students.edit', compact('student'));
    }


    public function update(Request $request, $id)
{
    // التحقق من صحة البيانات
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'student_number' => 'required|string|unique:students,student_number,' . $id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        // إعادة التوجيه إلى الصفحة السابقة مع عرض الأخطاء
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // استخراج البيانات المطلوبة فقط
    $data = $request->only('name', 'student_number');

    // الحصول على الطالب للتحقق من وجوده والمواد المرتبطة به
    $student = Student::findOrFail($id);

    // التحقق مما إذا كان الطالب مرتبطاً بمواد
    if ($student->studentSubjects()->count() > 0) {
        return redirect()->back()
            ->with('error', 'لا يمكن تغيير رقم القيد لأن الطالب مرتبط بمواد.')
            ->withInput();
    }

    $image = $request->file('image');
    if ($image) {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;
    }

    $student->update($data);

    return redirect()->route('students')
        ->with('success', 'تم تحديث بيانات الطالب بنجاح.');
}



public function destroy($id)
{
    $student = Student::find($id);
    
    if ($student) {
        $student->delete();
        return redirect()->route('students')->with('success', 'تم حذف الطالب بنجاح.');
    } else {
        return redirect()->route('students')->with('error', 'لم يتم العثور على الطالب.');
    }
}

    public function getStudents(Request $request)
    {
        return view('subjects.create');
    }


    public function checkExam(Request $request)
{
    $studentNumber = $request->input('student_number');

    // تحقق من تقديم رقم الطالب
    if (!$studentNumber) {
        return response()->json(['error' => 'رقم الطالب مطلوب'], 400);
    }

    // تحقق من وجود الطالب
    $student = Student::where('student_number', $studentNumber)->first();
    if (!$student) {
        return response()->json(['error' => 'الطالب غير موجود'], 404);
    }

    // تنفيذ الاستعلام باستخدام DB::select
    $exams = DB::select("
        SELECT ss.student_number, e.*
        FROM student_subjects ss
        JOIN exams e ON ss.subject_code = e.subject_code
        WHERE NOW() BETWEEN e.start_date AND e.end_date
        AND ss.student_number = ?
    ", [$studentNumber]);

    // تحقق مما إذا كانت هناك امتحانات حالياً
    if (!empty($exams)) {
        return response()->json([
            'name' => $student->name,  // أضف اسم الطالب هنا
            'student_number' => $student->student_number,  // أضف رقم الطالب هنا
            'image' => $student->image,
            'message' => 'تم العثور على امتحانات للطالب في الوقت الحالي.',
            'exams' => $exams
        ]);
    } else {
        return response()->json([
            'name' => $student->name,  // أضف اسم الطالب هنا
            'student_number' => $student->student_number,  // أضف رقم الطالب هنا
            'error' => 'لا يوجد امتحانات للطالب في الوقت الحالي.'
        ], 404);
    }
}
    
}

