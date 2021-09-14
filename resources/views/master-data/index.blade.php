@extends('layouts.app')

@section('breadcumb')
    <li class="breadcrumb-item active">Master Data</li>
@endsection

@section('style')
   <style>
       .master-data {
           cursor: pointer;
       }

       .master-data:hover {
            box-shadow: 0px 0px 33px -14px rgba(0,0,0,0.75);
            -webkit-box-shadow: 0px 0px 33px -14px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 33px -14px rgba(0,0,0,0.75);
            border-right: 4px solid red;
       }
   </style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="row">
                    @if(auth()->user()->can('departement-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('departements.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-building"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Departement</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if(auth()->user()->can('user-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('users.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">User</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if (auth()->user()->can('user-technical-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('user-technicals.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-user-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">User Technical</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if (auth()->user()->can('user-group-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('user-technical-groups.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-users-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">User Groups</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif
                    
                    @if (auth()->user()->can('category-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('categories.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-th-large"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Category Assets</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if (auth()->user()->can('type-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('types.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-th"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Type Asset</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if (auth()->user()->can('material-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('materials.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-list"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Materials</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if (auth()->user()->can('bom-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('boms.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-clipboard-list"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Bill Of Materials</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if (auth()->user()->can('task-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('tasks.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-tasks"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Tasks</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if (auth()->user()->can('task-group-list'))
                    <div class="col-md-3 col-sm-6 col-12" onclick="location.href='{{ route('task-groups.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon"><i class="fas fa-clipboard-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Task Groups</span>

                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
