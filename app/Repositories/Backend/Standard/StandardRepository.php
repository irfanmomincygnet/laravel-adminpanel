<?php

namespace App\Repositories\Backend\Standard;

use DB;
use Carbon\Carbon;
use App\Models\Standard\Standard;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StandardRepository.
 */
class StandardRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Standard::class;

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
                config('module.standards.table').'.id',
                config('module.standards.table').'.name',
                config('module.standards.table').'.status',
                config('module.standards.table').'.created_at',
                config('module.standards.table').'.updated_at',
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
        if (Standard::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.standards.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Standard $standard
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Standard $standard, array $input)
    {
    	if ($standard->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.standards.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Standard $standard
     * @throws GeneralException
     * @return bool
     */
    public function delete(Standard $standard)
    {
        if ($standard->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.standards.delete_error'));
    }
}
