<?php
namespace App\Http\Controllers;

use App\Models\StudentSubject;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    public function index()
    {
        $subjects = StudentSubject::select('subject_code')
        ->distinct()
        ->get();
        $exams = Exam::with('subject')->get();
        return view('exams.index', compact('subjects', 'exams'));
    }

    public function create()
    {
        $subjects = StudentSubject::all();
        return view('exams.create', compact('subjects'));
    }
    
        public function store(Request $request)
        {
            $request->validate([
                'subject_code' => 'required|exists:student_subjects,subject_code',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'end_date.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية.',
            ]);
        
            try {
                Exam::create([
                    'subject_code' => $request->input('subject_code'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                ]);
        
                return response()->json(['success' => 'تم إنشاء الامتحان بنجاح.']);
            } catch (\Exception $e) {
                Log::error('Error creating exam: ' . $e->getMessage());
                return response()->json(['error' => 'فشل في إنشاء الامتحان.'], 500);
            }
        }
        
    

    public function edit($id)
    {
        $exam = Exam::find($id);
        $subjects = StudentSubject::all();
        return view('exams.edit', compact('exam', 'subjects'));
    }

    public function update(Request $request, $id)
    {
       /* $request->validate([
            'student_subject_id' => 'required|exists:student_subjects,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
*/
        $exam = Exam::find($id);
        try {
            $exam->update($request->only('student_subject_id', 'start_date', 'end_date'));
        } catch (\Exception $e) {
            Log::error('Error updating exam: ' . $e->getMessage());
            return redirect()->route('exams.index')
                ->with('error', 'Failed to update exam.');
        }

        return redirect()->route('exams')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy($id)
    {
        $exam = Exam::find($id);
        try {
            $exam->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting exam: ' . $e->getMessage());
            return redirect()->route('exams')
                ->with('error', 'Failed to delete exam.');
        }

        return redirect()->route('exams')
            ->with('success', 'Exam deleted successfully.');
    }
    public function deleteAll()
{
    // تأكد من أن هناك امتحانات قبل محاولة حذفها
    $exams = Exam::all();

    if ($exams->isEmpty()) {
        return redirect()->route('exams')->with('error', 'لا توجد امتحانات لحذفها.');
    }

    // حذف جميع الامتحانات
    Exam::query()->delete();

    return redirect()->route('exams')->with('success', 'تم حذف جميع الامتحانات بنجاح');
}

}
