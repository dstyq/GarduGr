<!DOCTYPE html>
<html>
<head>
	<title>Report Maintenance</title>
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
            margin: 20px 20px
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
        
	</style>
</head>
<body>
 
    <div class="header">
        <div class="title">
            <h1>Laporan Schedule Maintenace</h1>
        </div>
        <div class="detail">
            <div class="left">
                <p><span class="bold">Maintenance Code:</span> {{ $schedule_maintenance->code }}</p>
                <p><span class="bold">Maintenance Name:</span> {{ $schedule_maintenance->name }}</p>
                <p><span class="bold">Asset:</span> {{ $schedule_maintenance->asset->name }}</p>
                <p><span class="bold">Priority:</span> {{ $schedule_maintenance->priority }}</p>
                <p><span class="bold">Type:</span> {{ $schedule_maintenance->maintenanceType->name }}</p>
            </div>
            <div class="right">
                <p><span class="bold">Description:</span> {{ $schedule_maintenance->description }}</p>
                <p><span class="bold">Schedule:</span> {{ $schedule_maintenance->schedule }}</p>
                <p><span class="bold">Date:</span> {{ date('Y/m/d H:i:s') }}</p>
            </div>
        </div>

        <hr style="clear: both">

        <div class="table">
            <legend style="font-weight: 600; font-size: 19px">Work Orders:</legend>
            <table>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Estimate Complete</th>
                    <th>Actual Complete</th>
                    <th>Status</th>
                </tr>
                @forelse ($work_orders as $work_order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $work_order->name }}</td>
                        <td>{{ $work_order->suggested_completion_date ?? '-' }}</td>
                        <td>{{ $work_order->actual_completion_date ?? '-' }}</td>
                        <td>{{ $work_order->workOrderStatus->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center">No Data Available</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</body>
</html>