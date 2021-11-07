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
       .info-box {
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
            border-radius: 0.50rem;
            background-color: #fff;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            position: relative;
            width: 100%;
        }

        .info-box .info-box-icon {
            border-radius: 0.50rem 0 0 0.50rem;
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            font-size: 1.875rem;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
            width: 70px;
        }

        .info-box .info-box-icon > img {
            max-width: 100%;
        }

        .info-box .info-box-content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            line-height: 1.8;
            -ms-flex: 1;
            flex: 1;
            padding: 0 15px;
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
                    <div class="col-md-3 col-sm-6 col-12 p-1" onclick="location.href='{{ route('departements.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon" style="background-color: rgb(201, 4, 4);"><i class="fas fa-building text-white"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text font-size-18 text-bold">Departement</span>

                            <span class="font-size-12" style="color: rgba(175, 174, 174, 0.788); line-height:normal;">Create, read, update, delete departement and privileges.</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif

                    @if(auth()->user()->can('user-list'))
                    <div class="col-md-3 col-sm-6 col-12 p-1" onclick="location.href='{{ route('users.index') }}';">
                        <div class="info-box bg-gradient-info master-data">
                        <span class="info-box-icon" style="background-color: rgb(201, 4, 4);"><i class="fas fa-user text-white"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text font-size-18 text-bold">User</span>

                            <span class="font-size-12" style="color: rgba(175, 174, 174, 0.788); line-height:normal;">Create, read, update, and delete User.</span>
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
