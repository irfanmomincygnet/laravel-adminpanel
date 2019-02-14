@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.students.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.students.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.students.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.students.partials.students-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="students-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.general.actions') }}</th>
                            <th>{{ trans('labels.backend.students.table.id') }}</th>
                            <th>{{ trans('labels.backend.students.table.first_name') }}</th>
                            <th>{{ trans('labels.backend.students.table.last_name') }}</th>
                            <th>{{ trans('labels.backend.students.table.gender') }}</th>
                            <th>{{ trans('labels.backend.students.table.standard') }}</th>
                            <th>{{ trans('labels.backend.students.table.profile_picture') }}</th>
                            <th>{{ trans('labels.backend.students.table.createdat') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>
                                {!! Form::text('first_name', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.access.users.table.first_name')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th>
                                {!! Form::text('last_name', null, ["class" => "search-input-text form-control", "data-column" => 3, "placeholder" => trans('labels.backend.access.users.table.last_name')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th>
                                {!! Form::select('gender', $gender, null, ["class" => "search-input-select form-control", "data-column" => 4, "placeholder" => trans('labels.backend.blogs.table.all')]) !!}
                            </th>
                            <th>
                                {!! Form::select('standard', $standard, null, ["class" => "search-input-select form-control", "data-column" => 5, "placeholder" => trans('labels.backend.blogs.table.all')]) !!}
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function() {
            var dataTable = $('#students-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.students.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                    {data: 'id', name: '{{config('module.students.table')}}.id'},
                    {data: 'first_name', name: '{{config('module.students.table')}}.first_name'},
                    {data: 'last_name', name: '{{config('module.students.table')}}.last_name'},
                    {data: 'gender', name: '{{config('module.students.table')}}.gender'},
                    {data: 'standard', name: '{{config('module.students.table')}}.standard'},
                    {data: 'profile_picture', name: '{{config('module.students.table')}}.profile_picture'},
                    {data: 'created_at', name: '{{config('module.students.table')}}.created_at'},
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection
