@extends('layouts.app')

@section('breadcumb')
<li class="breadcrumb-item active">Assets</li>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<style>
    .jstree-themeicon-custom {
        background-size: cover !important;
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
                            <div class="col-6">
                                <span class="tx-bold text-lg">
                                    <i class="icon ion ion-ios-speedometer text-lg"></i>
                                    Asset
                                </span>
                            </div>

                            @can('asset-create')
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route('assets.create') }}" class="btn btn-md btn-info">
                                    <i class="fa fa-plus"></i>
                                    Asset
                                </a>
                            </div>
                            @endcan
                        </div>

                        @include('components.flash-message')
                    </div>

                    <div class="card-body">
                        @if ($asset_count < 1)
                            <img src="{{ asset('img/no-data.jpg') }}" class="mx-auto d-block" width="50%" alt="">
                        @else
                            <div id="treeview"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('script')
{{-- js tree --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

<script>
    $(document).ready(function () {
        var dataTree = [];
        $.ajax({
            type: 'GET',
            url: '/api/assets',
            dataType: 'json',
            async: false,
            success: function (data) {
                dataTree = data.data
            },
            error: function (data) {
                $.alert('Failed Load Data!');
                console.log(data);
            }
        });

        $('#treeview').jstree({
            'core': {
                "animation": 0,
                "check_callback": true,
                "themes": {
                    "stripes": true
                },
                'data': dataTree
            },
            'plugins': ["contextmenu","wholerow"],
            'contextmenu': {
                items: customMenu,
            }
        }).bind("select_node.jstree", function (e, data) {
            // var href = data.node.a_attr.href;
            // document.location.href = href;
        });

        function customMenu(node) {
            // The default set of all items
            var items = {
                add_child: { // The "detail" menu item
                    label: "Add Child",
                    action: function () {
                        var href = node.a_attr.add_child;
                        document.location.href = href;
                    }
                },
                detail: { // The "detail" menu item
                    label: "Detail",
                    action: function () {
                        var href = node.a_attr.show;
                        document.location.href = href;
                    }
                },
                edit: { // The "edit" menu item
                    label: "Edit",
                    action: function () {
                        var href = node.a_attr.edit;
                        document.location.href = href;
                    }
                },
                delete: { // The "delete" menu item
                    label: "Delete",
                    action: function () {
                        var id = node.id;
                        var name = node.a_attr.name;
                        modalDelete('Asset', name, 'assets/' + id, '/assets/');
                    }
                },
            };

            

            if ($(node).hasClass("folder")) {
                // Delete the "delete" menu item
                delete items.deleteItem;
            }

            return items;
        }
    });

</script>
@endsection