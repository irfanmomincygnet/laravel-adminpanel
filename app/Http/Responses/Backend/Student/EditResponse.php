<?php

namespace App\Http\Responses\Backend\Student;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Standard\Standard;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Student\Student
     */
    protected $students;
    protected $gender;

    /**
     * @param App\Models\Student\Student $students
     */
    public function __construct($students, $gender)
    {
        $this->students = $students;
        $this->gender   = $gender;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        $stds = Standard::where('status', 1)->get()->all();
        $standard = [];
        if(!empty($stds)) {
            foreach ($stds as $std) {
                $standard[$std->id] = $std->name;
            }
        }

        return view('backend.students.edit')->with([
            'student'  => $this->students,
            'gender'   => $this->gender,
            'standard' => $standard,
        ]);
    }
}