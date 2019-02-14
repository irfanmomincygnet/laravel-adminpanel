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

    /**
     * @var Get Gender List from Controller
     */
    protected $gender;

    /**
     * @var Get Standard List from Controller
     */
    protected $standard;

    /**
     * @param App\Models\Student\Student $students
     */
    public function __construct($students, $gender, $standard)
    {
        $this->students = $students;
        $this->gender   = $gender;
        $this->standard = $standard;
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
        return view('backend.students.edit')->with([
            'student'  => $this->students,
            'gender'   => $this->gender,
            'standard' => $this->standard,
        ]);
    }
}