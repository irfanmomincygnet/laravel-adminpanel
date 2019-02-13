<div class="box-body">
    <div class="form-group">
        {{ Form::label('name', trans('validation.attributes.backend.standard.name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.standard.name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.backend.standard.status'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-1">
            <div class="control-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('status', '1', @$standard->status == 1) }}
                <div class="control__indicator"></div>
                </label>
            </div>
        </div><!--col-lg-1-->
    </div><!--form control-->
</div>

@section("after-scripts")
@endsection