<?php

namespace App\Http\Responses\Backend\Standard;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Standard\Standard
     */
    protected $standards;

    /**
     * @param App\Models\Standard\Standard $standards
     */
    public function __construct($standards)
    {
        $this->standards = $standards;
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
        return view('backend.standards.edit')->with([
            'standard' => $this->standards
        ]);
    }
}