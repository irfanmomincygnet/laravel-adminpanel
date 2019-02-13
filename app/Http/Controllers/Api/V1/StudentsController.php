<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\StudentsResource;
use App\Models\Student\Student;
use App\Repositories\Backend\Student\StudentRepository;
use Illuminate\Http\Request;
use Validator;

class StudentsController extends APIController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return the students.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit   = $request->get('paginate') ? $request->get('paginate') : 25;
        $orderBy = $request->get('orderBy') ? $request->get('orderBy') : 'ASC';
        $sortBy  = $request->get('sortBy') ? $request->get('sortBy') : 'created_at';

        return StudentsResource::collection(
            $this->repository->getForDataTable()->orderBy($sortBy, $orderBy)->paginate($limit)
        );
    }

    /**
     * Return the specified resource.
     *
     * @param Student student
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Student $student)
    {
        return new StudentsResource($student);
    }

    /**
     * Creates the Resource for Student.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = $this->validateStudent($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->create($request->all());

        return new StudentsResource(Student::orderBy('created_at', 'desc')->first());
    }

    /**
     * Update student.
     *
     * @param Student    $student
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Student $student)
    {
        $validation = $this->validateStudent($request, 'update');

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->update($student, $request->all());

        $student = Student::findOrfail($student->id);

        return new StudentsResource($student);
    }

    /**
     * Delete Student.
     *
     * @param Student    $student
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Student $student, Request $request)
    {
        $this->repository->delete($student);

        return $this->respond([
            'message' => trans('alerts.backend.students.deleted'),
        ]);
    }

    /**
     * validate Student.
     *
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateStudent(Request $request, $action = 'insert')
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'standard'   => 'required',
            'gender'     => 'required',
        ]);

        return $validation;
    }

    /**
     * validate message for validate student.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function messages()
    {
        return [
            'name.required' => 'Please insert Student Title',
            'name.max'      => 'Student Title may not be greater than 191 characters.',
        ];
    }
}
