<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
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
        $courses = Course::where('name', '!=', null)->latest()->paginate(30);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::where('name', '!=', null)->latest()->paginate(30);
        return response()->json([
            'courses' => $courses,
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
            'name' => 'required|unique:courses|max:255',
            'hours' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $course = new Course();
            $course->name = $request->name;
            $course->hours = $request->hours;
            $course->save();
            return response()->json([
                'status' => true,
                'success' => 'Course added successfully.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::all()->find($id);
        return response()->json(['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $course = Course::all()->find($request->id);
        if ($request->name ==  $course->name) {
            $validator = Validator::make($request->all(), [
                'hours' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages(),
                ]);
            } else {
                $course->hours = $request->hours;
                $course->save();
                return response()->json([
                    'status' => true,
                    'success' => 'Course updated successfully.',
                ]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:courses|max:255',
                'hours' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->messages(),
                ]);
            } else {
                $course->name = $request->name;
                $course->hours = $request->hours;
                $course->save();
                return response()->json([
                    'status' => true,
                    'success' => 'Course updated successfully.',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();
        return response()->json([
            'status' => true,
            'success' => 'Course deleted successfully',
        ]);
    }
}
