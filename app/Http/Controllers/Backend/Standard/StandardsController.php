<?php

namespace App\Http\Controllers\Backend\Standard;

use App\Models\Standard\Standard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Standard\CreateResponse;
use App\Http\Responses\Backend\Standard\EditResponse;
use App\Repositories\Backend\Standard\StandardRepository;
use App\Http\Requests\Backend\Standard\ManageStandardRequest;
use App\Http\Requests\Backend\Standard\CreateStandardRequest;
use App\Http\Requests\Backend\Standard\StoreStandardRequest;
use App\Http\Requests\Backend\Standard\EditStandardRequest;
use App\Http\Requests\Backend\Standard\UpdateStandardRequest;
use App\Http\Requests\Backend\Standard\DeleteStandardRequest;

/**
 * StandardsController
 */
class StandardsController extends Controller
{
    /**
     * variable to store the repository object
     * @var StandardRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param StandardRepository $repository;
     */
    public function __construct(StandardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Standard\ManageStandardRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageStandardRequest $request)
    {
        return new ViewResponse('backend.standards.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateStandardRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Standard\CreateResponse
     */
    public function create(CreateStandardRequest $request)
    {
        return new CreateResponse('backend.standards.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreStandardRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreStandardRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.standards.index'), ['flash_success' => trans('alerts.backend.standards.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Standard\Standard  $standard
     * @param  EditStandardRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Standard\EditResponse
     */
    public function edit(Standard $standard, EditStandardRequest $request)
    {
        return new EditResponse($standard);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStandardRequestNamespace  $request
     * @param  App\Models\Standard\Standard  $standard
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateStandardRequest $request, Standard $standard)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $standard, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.standards.index'), ['flash_success' => trans('alerts.backend.standards.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteStandardRequestNamespace  $request
     * @param  App\Models\Standard\Standard  $standard
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Standard $standard, DeleteStandardRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($standard);
        //returning with successfull message
        return new RedirectResponse(route('admin.standards.index'), ['flash_success' => trans('alerts.backend.standards.deleted')]);
    }
    
}
