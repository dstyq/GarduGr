<!DOCTYPE html>
<html>
<head>
	<title>Report Work Order</title>
    <style type="text/css">
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed, 
        figure, figcaption, footer, header, hgroup, 
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
            font-family: sans-serif;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure, 
        footer, header, hgroup, menu, nav, section {
            display: block;
        }
        body {
            line-height: 1;
        }
        ol, ul {
            list-style: none;
        }
        blockquote, q {
            quotes: none;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .header {
            margin-top: 30px;
        }

        .header .title {
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 30px;
            font-weight: 700;
            text-align: center;
        }
        
        .detail {
            margin: 0 20px;
            letter-spacing: 0.1px;
            line-height: 1.1rem;
        }

        .detail  .bold {
            font-weight: bold;
            margin-right: 5px;
        }

        .detail .left {
            float: left;
            width: 40%;
        }

        .detail .right {
            float: right;
            width: 40%;
        }

        .table {
            margin: 20px 20px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .images {
            margin: 20px 20px;
            margin-top: 30;
        }

        .images .wo-image {
            width: 25%;
            margin-top: 30px;
        }
        
	</style>
</head>
<body>
 
    <div class="header">
        <div class="title">
            <h1>Laporan Work Order</h1>
        </div>
        <div class="detail">
            <div class="left">
                <p><span class="bold">Work Order Name:</span> {{ $work_order->name }}</p>
                <p><span class="bold">Status:</span> {{ $work_order->workOrderStatus->name }}</p>
                <p><span class="bold">Task Complete:</span> {{ $task_complete }}</p>
                <p><span class="bold">Priority:</span> {{ $work_order->priority }}</p>
                <p><span class="bold">Type:</span> {{ $work_order->maintenanceType->name }}</p>
                <p><span class="bold">Estimate Complete:</span> {{ $work_order->suggested_completion_date ?? '-' }}</p>
                <p><span class="bold">Actual Complete:</span> {{ $work_order->actual_completion_date ?? '-' }}</p>
            </div>
            <div class="right">
                <p><span class="bold">Maintenance:</span> {{ $work_order->scheduleMaintenance->name }}</p>
                <p><span class="bold">Asset:</span> {{ $work_order->asset->name }}</p>
                <p><span class="bold">Description:</span> {{ $work_order->description }}</p>
                <p><span class="bold">Completion Notes:</span> {{ $work_order->completion_notes ?? '-' }}</p>
                <p><span class="bold">Date:</span> {{ date('Y/m/d H:i:s') }}</p>
            </div>
        </div>

        <hr style="clear: both">

        <div class="table">
            <legend style="font-weight: 600; font-size: 19px">Tasks:</legend>
            <table>
                <tr>
                    <th>No</th>
                    <th>Task Name</th>
                    <th>Remarks</th>
                    <th>User</th>
                    <th>Status</th>
                </tr>
                @forelse ($work_order->reportTaskWorkOrders as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->remarks ?? '-' }}</td>
                        <td>{{ ($task->status) ? ($task->userTechnical->username ?? '-') : '-' }}</td>
                        <td>{{ $task->status ? 'Done' : 'Wait'}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center">No Data Available</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <div class="table">
            <legend style="font-weight: 600; font-size: 19px; margin-top: 10px;">Material Change History:</legend>
            <table>
                <tr>
                    <th>No</th>
                    <th>Previous Material</th>
                    <th>New Material</th>
                    <th>Remarks</th>
                </tr>
                @forelse ($work_order->reportAssetMaterials as $material)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->prevMaterial->material_name }}</td>
                        <td>{{ $material->currentMaterial->material_name }}</td>
                        <td>{{ $material->remarks ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center">No Data Available</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <div class="images">
            <legend style="font-weight: 600; font-size: 19px;">Images:</legend> <br>
            @foreach ($work_order->images as $image)
                <img src="{{ public_path('img/work-orders/' . $image->name) }}" alt="" class="wo-image">
            @endforeach
        </div>
    </div>
</body>
</html>