<?php

namespace App\Http\Controllers\Backend\Student;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Student\StudentRepository;
use App\Http\Controllers\Backend\Student\StudentsController;
use App\Http\Requests\Backend\Student\ManageStudentRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Standard\Standard;

/**
 * Class StudentsTableController.
 */
class StudentsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var StudentRepository
     */
    protected $student;

    /**
     * variable to access public methods of Students Controller
     * @var $studentController
     */
    protected $studentController;

    /**
     * contructor to initialize repository object
     * @param StudentRepository $student;
     */
    public function __construct(StudentRepository $student, StudentsController $studentController)
    {
        $this->student           = $student;
        $this->studentController = $studentController;
    }

    /**
     * This method return the data of the model
     * @param ManageStudentRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageStudentRequest $request)
    {
        return Datatables::of($this->student->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($student) {
                return Carbon::parse($student->created_at)->toDateString();
            })
            ->addColumn('created_by', function ($student) {
                return $student->user_name;
            })
            ->addColumn('profile_picture', function ($student) {
                return '<img src="'.Storage::url("img/student/".($student->profile_picture ? $student->profile_picture : 'default.png' )).'" height="80" width="80">';
            })
            ->addColumn('standard', function ($student) {
                $stds = Standard::find($student->standard);
                return ($stds->name);
            })
            ->addColumn('gender', function ($student) {
                $gender = $this->studentController->gender;
                return ($gender[$student->gender]);
            })
            ->addColumn('actions', function ($student) {
                return $student->action_buttons;
            })
            ->make(true);
    }
}
