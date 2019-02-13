<?php

namespace App\Http\Responses\Backend\Student;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Standard\Standard;

class CreateResponse implements Responsable
{
    protected $gender;

    public function __construct($gender)
    {
        $this->gender = $gender;
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

        return view('backend.students.create')->with([
            'gender'   => $this->gender,
            'standard' => $standard,
        ]);
    }
}