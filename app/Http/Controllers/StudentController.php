<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::where('studentName', '!=', null)->latest()->paginate(5);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = Student::where('studentName', '!=', null)->latest()->paginate(5);
        return response()->json([
            'students' => $students,
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
            'studentName' => 'required',
            'studentId' => 'required|unique:students|max:255',
            'nationalId' => 'required|unique:students|max:255',
            'phone' => 'required|unique:students|max:255',
            'email' => 'required|unique:students|max:255',
            'address' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'degree' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $student = new Student();
            $student->studentName = $request->studentName;
            $student->studentId = $request->studentId;
            $student->nationalId = $request->nationalId;
            $student->phone = $request->phone;
            $student->email = $request->email;
            $student->address = $request->address;
            $student->gender = $request->gender;
            $student->age = $request->age;
            $student->degree = $request->degree;

            $student->save();
            return response()->json([
                'status' => true,
                'success' => 'Student added successfully.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::all()->find($id);
        return response()->json(['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $student = Student::all()->find($request->id);
        $validator = Validator::make($request->all(), [
            'studentName' => 'required',
            'studentId' => 'required|max:255',
            'nationalId' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            'address' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'degree' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $student->studentName = $request->studentName;
            $student->studentId = $request->studentId;
            $student->nationalId = $request->nationalId;
            $student->phone = $request->phone;
            $student->email = $request->email;
            $student->address = $request->address;
            $student->gender = $request->gender;
            $student->age = $request->age;
            $student->degree = $request->degree;
            $student->save();
            return response()->json([
                'status' => true,
                'success' => 'Student updated successfully.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => true,
            'success' => 'Student deleted successfully',
        ]);
    }
}
