<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Hall;
use App\Models\Student;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class StudentExamController extends Controller
{

    public function __construct()
    {
        $this->middleware('teacher');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('teacher.exams.index', compact('exams'));

        $examsAll = DB::table('exams')
            ->join('courses', 'exams.course_id', '=', 'courses.id')
            ->select('exams.*', 'courses.name')
            ->get();

        $halls = Hall::all();
        $students = Student::all();
        $exams = DB::table('student_exams')
            ->leftJoin('exams', 'student_exams.exam_id', '=', 'exams.id')
            ->orderBy('student_exams.id')
            ->paginate(5);
        return view('teacher.StudentExam.index', compact('exams', 'examsAll', 'halls', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student_exams = DB::table('student_exams')
            ->join('students', 'student_exams.student_id', '=', 'students.id')
            ->join('exams', 'student_exams.exam_id', '=', 'exams.id')
            ->join('courses', 'exams.course_id', '=', 'courses.id')
            ->join('halls', 'exams.hall_id', '=', 'halls.id')
            ->select('students.studentName', 'courses.*', 'exams.*', 'halls.nameHall', 'student_exams.*')
            ->get();

        return response()->json([
            'student_exams' => $student_exams,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'exam_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $student_exam = new StudentExam();
            $student_exam->exam_id = $request->exam_id;
            $student_exam->student_id = $request->student_id;
            $student_exam->isPresent = 0;
            $student_exam->save();

            return response()->json([
                'status' => true,
                // 'success' => $student_exam,
                'success' => 'Exam added successfully.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function show(StudentExam $studentExam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $student_exam = StudentExam::all()->find($id);
        return response()->json([
            'status' => true,
            // 'success' => $id,
            'student_exam' => $student_exam,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $student_exam = StudentExam::all()->find($request->id);
        $student_exam->exam_id = $request->exam_id;
        $student_exam->student_id = $request->student_id;
        $student_exam->save();
        return response()->json([
            // 'success' => $student_exam,
            'success' => 'Student Exam updated  successfully.',
        ]);
    }


    public function updateAtt(Request $request)
    {

        $student_id = Student::all()->where('studentId', '=', $request->StudentNumber)->first()->id;

        $student_exam = StudentExam::all()
            ->where('student_id', '=', $student_id)
            ->where('exam_id', '=', $request->id)
            ->first();

        $student_exam->isPresent = 1;
        $student_exam->save();
        return response()->json([
            // 'success' => $student_exam,
            'success' => 'Student attendance  successfully.',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student_exam = StudentExam::find($id);
        $student_exam->delete();
        return response()->json([
            'status' => true,
            'success' => 'Student Exam deleted successfully',
        ]);
    }
}
