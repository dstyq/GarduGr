@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">History</li>
@endsection

@section('style')
<style>
    .pointer {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <span class="tx-bold font-size-18 text-lg">
                                    <i class="icon ion ion-ios-speedometer font-size-20 text-lg"></i>&nbsp;
                                    History
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                @include('components.flash-message')
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="cctvTable" class="table table-hover table-responsive-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                    <th>Departement</th>
                                    <th>Datetime</th>
                                    @if(auth()->user()->can('cctv-delete'))
                                    <th>Delete</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $l)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $l->user->username }}</td>
                                    <td>{{ $l->type }}</td>
                                    <td>{{ $l->user->getRoleNames()[0] }}</td>
                                    <td>{{ $l->datetime }}</td>
                                    @if(auth()->user()->can('history-log-delete'))
                                    <td>
                                        @can('history-log-delete')
                                        <a href="#" class="btn btn-danger f-12" onclick="modalDelete('History Log', '{{ $l->user->username }}', 'history-log/' + {{ $l->id }}, '/history-log/')">
                                            <i class="far fa-trash-alt"></i>
                                            Delete
                                        </a>
                                        @endcan
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@endsection