<?php

namespace App\Http\Responses\Backend\Student;

use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable
{
    protected $standard;
    protected $gender;

    public function __construct($standard, $gender)
    {
        $this->standard = $standard;
        $this->gender   = $gender;
    }

    public function toResponse($request)
    {
        return view('backend.students.index')->with([
            'standard' => $this->standard,
            'gender' => $this->gender,
        ]);
    }
}
