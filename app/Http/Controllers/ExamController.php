<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ExamController extends Controller
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
        // $exams = Exam::where('course_id', '!=', null)->latest()->paginate(5);
        // return view('teacher.exams.index', compact('exams'));

        $course = Course::all();
        $halls = Hall::all();

        $exams = DB::table('exams')
            ->leftJoin('courses', 'exams.course_id', '=', 'courses.id')
            ->orderBy('exams.course_id')
            ->paginate(5);
        // $exams =  $exams->latest()->paginate(5);
        return view('teacher.exams.index', compact('exams', 'course', 'halls'));
        // return $exams;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $exams = Exam::where('course_id', '!=', null)->latest()->paginate(5);

        $exams = DB::table('exams')
            ->join('courses', 'exams.course_id', '=', 'courses.id')
            ->join('halls', 'exams.hall_id', '=', 'halls.id')
            ->select('exams.*', 'courses.name', 'courses.hours', 'halls.nameHall')
            ->get();

        // $exams = DB::table('exams')
        //     ->leftJoin('courses', 'exams.course_id', '=', 'courses.id')
        //     ->leftJoin('halls', 'exams.hall_id', '=', 'halls.id')
        //     ->orderBy('exams.id')
        //     ->get(['exams.*']);
        return response()->json([
            'exams' => $exams,
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
            'course_id' => 'required',
            'hall_id' => 'required',
            'day' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $exam = new Exam();
            $exam->course_id = $request->course_id;
            $exam->hall_id = $request->hall_id;
            $exam->day = $request->day;
            $exam->start = $request->start;
            $exam->end = $request->end;

            $exam->save();
            return response()->json([
                'status' => true,
                'success' => 'Exam added successfully.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::all()->find($id);
        return response()->json(['exam' => $exam]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'hall_id' => 'required',
            'day' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $exam = Exam::all()->find($request->id);
            $exam->course_id = $request->course_id;
            $exam->hall_id = $request->hall_id;
            $exam->day = $request->day;
            $exam->start = $request->start;
            $exam->end = $request->end;

            $exam->save();
            return response()->json([
                'status' => true,
                'success' => 'Exam updated successfully.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::find($id);
        $exam->delete();
        return response()->json([
            'status' => true,
            'success' => 'Exam deleted successfully',
        ]);
    }


    public function inputExam($id)
    {
        $exam = Exam::all()->find($id);
        $course = Course::all()->find($exam->course_id);
        // $exams = Course::all()->find($id);

        $exams = DB::table('exams')
            ->join('courses', 'exams.course_id', '=', 'courses.id')
            ->where('exams.id', '=', $id)
            ->select('courses.name')
            ->get();
        $name = $exams->first()->name;

        $student_exams = DB::table('student_exams')
            ->join('students', 'student_exams.student_id', '=', 'students.id')
            ->join('exams', 'student_exams.exam_id', '=', 'exams.id')
            ->join('courses', 'exams.course_id', '=', 'courses.id')
            ->join('halls', 'exams.hall_id', '=', 'halls.id')
            ->where('courses.name', '=', $name)
            ->select('student_exams.*', 'students.studentName', 'courses.*', 'exams.*', 'halls.nameHall')
            ->get();
        return view('teacher.exams.inputExam', compact('course', 'id','student_exams'));
    }
}
