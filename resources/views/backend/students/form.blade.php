<div class="box-body">
    <div class="form-group">
        {{ Form::label('first_name', trans('validation.attributes.backend.students.first_name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('first_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.students.first_name_ph'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('last_name', trans('validation.attributes.backend.students.last_name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('last_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.students.last_name_ph'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('gender', trans('validation.attributes.backend.students.gender'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-8">
            @if (count($gender) > 0)
                @foreach($gender as $genVal => $genLabel)
                    <div>
                        <label for="gender-{{$genVal}}" class="control control--radio">
                            <input type="radio" <?php  if(@$student->gender == $genVal) { echo 'checked';} else if($genVal == 'male') { echo 'checked'; } ?> value="{{$genVal}}" name="gender" id="gender-{{$genVal}}" class="get-gender-for-permissions" />  &nbsp;&nbsp;{!! $genLabel !!}
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                @endforeach
            @else
                {{ trans('validation.attributes.backend.students.no_gender') }}
            @endif
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('hobbies', trans('validation.attributes.backend.students.hobbies'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('hobbies', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.students.hobbies_desc')]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('profile_picture', trans('validation.attributes.backend.students.profile_picture'), ['class' => 'col-lg-2 control-label']) }}

        @if(!empty($student->profile_picture))
            <div class="col-lg-1 img-remove-logo">
                <img src="<?php echo Storage::url('img/student/'.($student->profile_picture ? $student->profile_picture : 'default.png')); ?>" height="80" width="80">
                <i id="remove-logo-img" class="fa fa-times remove-logo" data-id="profilepic" aria-hidden="true"></i>
            </div>
            <input type="hidden" name="remove_img" id="remove_profilepic" value="">
        @endif
        <div class="col-lg-5">
            <div class="custom-file-input">
                <input type="file" name="profile_picture" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
            </div>
        </div>
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('standard', trans('validation.attributes.backend.students.standard'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
           {{ Form::select('standard', $standard, null, ['class' => 'form-control select2 standard box-size', 'placeholder' => trans('validation.attributes.backend.students.standard')]) }}
        </div><!--col-lg-3-->
    </div><!--form control-->
</div>

@section("after-scripts")
<script>
    (function(){
        Backend.Students.init();
    })();
</script>
@endsection