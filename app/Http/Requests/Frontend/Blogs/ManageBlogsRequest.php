<?php

namespace App\Http\Requests\Frontend\Blogs;

use App\Http\Requests\Request;

/**
 * Class ManageBlogsRequest.
 */
class ManageBlogsRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
