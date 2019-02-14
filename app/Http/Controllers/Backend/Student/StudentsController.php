<?php

namespace App\Http\Controllers\Backend\Student;

use App\Models\Student\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Student\CreateResponse;
use App\Http\Responses\Backend\Student\EditResponse;
use App\Repositories\Backend\Student\StudentRepository;
use App\Http\Requests\Backend\Student\ManageStudentRequest;
use App\Http\Requests\Backend\Student\CreateStudentRequest;
use App\Http\Requests\Backend\Student\StoreStudentRequest;
use App\Http\Requests\Backend\Student\EditStudentRequest;
use App\Http\Requests\Backend\Student\UpdateStudentRequest;
use App\Http\Requests\Backend\Student\DeleteStudentRequest;
use App\Models\Standard\Standard;

/**
 * StudentsController
 */
class StudentsController extends Controller
{
    /**
     * variable to store the repository object
     * @var StudentRepository
     */
    protected $repository;

    /**
     * [$gender Gender List]
     * @var [type]
     */
    public $gender = [
        'male'   => 'Male',
        'female' => 'Female',
        'other'  => 'Other',
    ];

    /**
     * contructor to initialize repository object
     * @param StudentRepository $repository;
     */
    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * getStandardsArray Get Standards list Dynamically
     * @return Standards Array
     */
    public function getStandardsArray()
    {
        $standard = Standard::where('status', 1)->pluck('name', 'id');

        return $standard;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Student\ManageStudentRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageStudentRequest $request)
    {
        return new ViewResponse('backend.students.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateStudentRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Student\CreateResponse
     */
    public function create(CreateStudentRequest $request)
    {
        return new CreateResponse($this->gender, $this->getStandardsArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreStudentRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreStudentRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.students.index'), ['flash_success' => trans('alerts.backend.students.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Student\Student  $student
     * @param  EditStudentRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Student\EditResponse
     */
    public function edit(Student $student, EditStudentRequest $request)
    {
        return new EditResponse($student, $this->gender, $this->getStandardsArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStudentRequestNamespace  $request
     * @param  App\Models\Student\Student  $student
     * @return \App\Http\Responses\RedirectResponse
     */

    public function update(UpdateStudentRequest $request, Student $student)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $student, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.students.index'), ['flash_success' => trans('alerts.backend.students.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteStudentRequestNamespace  $request
     * @param  App\Models\Student\Student  $student
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Student $student, DeleteStudentRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($student);
        //returning with successfull message
        return new RedirectResponse(route('admin.students.index'), ['flash_success' => trans('alerts.backend.students.deleted')]);
    }

}
