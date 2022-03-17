<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
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
        $colleges = College::where('name', '!=', null)->latest()->paginate(30);
        // return view('admin.colleges.index', compact('colleges'));
        return view('admin.colleges.index', compact('colleges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colleges = College::where('name', '!=', null)->latest()->paginate(30);
        return response()->json([
            'colleges' => $colleges,
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
            'name' => 'required|unique:colleges|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->messages(),
            ]);
        } else {
            $college = new College();
            $college->name = $request->name;
            $college->save();
            return response()->json([
                'status' => true,
                'success' => 'College added successfully.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function show(College $college)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $college = College::all()->find($id);
        return response()->json(['college' => $college]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $college = College::all()->find($request->idEdit);

        if ($request->nameEdit == $college->name) {
            return response()->json([
                'status' => false,
                'info' => 'No modification has been made.',
            ]);
        } else {

            $validator = Validator::make($request->all(), [
                'name' => 'unique:colleges|max:255',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'statusUpdate' => false,
                    'errors' => $validator->errors()->messages(),
                ]);
            } else {
                $college->name = $request->nameEdit;
                $college->save();
                return response()->json([
                    'statusUpdate' => true,
                    'success' => 'College update successfully.',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $college = College::find($id);
        $college->delete();
        return response()->json([
            'status' => true,
            'success' => 'College deleted successfully',
        ]);
    }
}
