<?php

namespace App\Http\Controllers\Backend\Standard;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Standard\StandardRepository;
use App\Http\Requests\Backend\Standard\ManageStandardRequest;

/**
 * Class StandardsTableController.
 */
class StandardsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var StandardRepository
     */
    protected $standard;

    /**
     * contructor to initialize repository object
     * @param StandardRepository $standard;
     */
    public function __construct(StandardRepository $standard)
    {
        $this->standard = $standard;
    }

    /**
     * This method return the data of the model
     * @param ManageStandardRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageStandardRequest $request)
    {
        return Datatables::of($this->standard->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($standard) {
                return Carbon::parse($standard->created_at)->toDateString();
            })
            ->addColumn('actions', function ($standard) {
                return $standard->action_buttons;
            })
            ->make(true);
    }
}
