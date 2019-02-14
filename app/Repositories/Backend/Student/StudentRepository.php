<?php

namespace App\Repositories\Backend\Student;

use DB;
use Carbon\Carbon;
use App\Models\Student\Student;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class StudentRepository.
 */
class StudentRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Student::class;

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'student'.DIRECTORY_SEPARATOR;
        $this->storage     = Storage::disk('public');
    }

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.students.table').'.id',
                config('module.students.table').'.created_at',
                config('module.students.table').'.updated_at',
                config('module.students.table').'.first_name',
                config('module.students.table').'.last_name',
                config('module.students.table').'.standard',
                config('module.students.table').'.gender',
                config('module.students.table').'.profile_picture',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        DB::transaction(function () use ($input) {
            $input               = $this->uploadImage($input);
            $input['created_by'] = access()->user()->id;

            if ($student = Student::create($input)) {

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.students.create_error'));
        });
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Student $student
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Student $student, array $input)
    {
        $input               = $this->uploadImage($input);
        $input['updated_by'] = access()->user()->id;

        if ($student->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.students.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Student $student
     * @throws GeneralException
     * @return bool
     */
    public function delete(Student $student)
    {
        if ($student->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.students.delete_error'));
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input)
    {
        if(isset($input['remove_img']) && !empty($input['remove_img'])) {
            $input = array_merge($input, ['profile_picture' => '']);
            return $input;
        }

        $avatar = $input['profile_picture'];

        if (isset($input['profile_picture']) && !empty($input['profile_picture'])) {
            $fileName = time().$avatar->getClientOriginalName();

            $this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()));

            $input = array_merge($input, ['profile_picture' => $fileName]);

            return $input;
        }
    }
}
