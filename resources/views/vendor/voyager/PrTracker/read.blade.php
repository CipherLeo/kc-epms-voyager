@extends('voyager::master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<title>{{ $pr_tracker->no }}</title>

@section('content')
    <div class="page-content container-fluid">
        <div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="voyager-compass"></i>
                        TRACKER
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-responsive">
                        <tr>
                            <td>No.</td>
                            <td>{{ $pr_tracker->no }}</td>
                        </tr>

                        <tr>
                            <td>Title</td>
                            <td>{{ $pr_tracker->title }}</td>
                        </tr>

                        <tr>
                            <td>Unit Responsible</td>
                            <td>{{ $pr_tracker->responsible_unit->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">PURCHASE REQUESTS</h3>
                </div>
                <div class="panel-body">

                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="voyager-bag"></i>
                        SUPPLEMENTAL REQUESTS
                    </h3>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
@endsection