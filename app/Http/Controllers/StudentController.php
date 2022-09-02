<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        $students = Student::get();

        return [
            'status' => 'success',
            'message' => 'The student has been successfully saved.',
            'data' => $students,
        ];
    }

    public function get( $id )
    {
        $student = Student::find( $id );

        return [
            'status' => 'success',
            'message' => 'The student has been successfully saved.',
            'data' => $student,
        ];
    }

    public function save(StudentRequest $request)
    {
        if ($request->get('id')) {

            $student = Student::find($request->get('id'));

            $student->name = data_get($request->all(), 'name');
            $student->gender = data_get($request->all(), 'gender');
            $student->dob = data_get($request->all(), 'dob');
            $student->major = data_get($request->all(), 'major');
            $student->save();

        } else {

            $arr = Arr::only($request->all(), ['name', 'gender', 'dob', 'major']);
            $student = Student::create($arr);
        }

        if ( $request->hasFile('profile') ) {
            $file_name = time().'_'.$request->file('profile')->getClientOriginalName();
            $file_path = $request->file('profile')->storeAs('uploads', $file_name, 'public');

            $student->profile = $file_path;
            $student->save();
        }

        return [
            'status' => 'success',
            'message' => 'The student has been successfully saved.',
            'data' => $student,
        ];
    }

    public function delete( $id )
    {
        $student = Student::find( $id );

        if ( $student ) {

            $student->delete();

            return [
                'status' => 'success',
                'message' => 'The student has been successfully deleted.',
                'data' => [],
            ];

        }

        return [
            'status' => 'error',
            'message' => 'The student not found.',
            'data' => [],
        ];
    }
}
