<?php

namespace App\Http\Responses\Backend\Student;

use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable
{
    /**
     * [$gender Get Gender list from Controller]
     * @var [Array]
     */
    protected $gender;

    /**
     * [$standard Get Standards list from Controller]
     * @var [Array]
     */
    protected $standard;

    public function __construct($gender, $standard)
    {
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
        return view('backend.students.create')->with([
            'gender'   => $this->gender,
            'standard' => $this->standard,
        ]);
    }
}