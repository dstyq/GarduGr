<!DOCTYPE html>
<html>
<head>
	<title>Report Asset</title>
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

        .images {
            margin: 20px 20px;
            margin-top: 30;
        }

        .images .asset-image {
            width: 50%;
            margin-top: 30px;
        }
        
	</style>
</head>
<body>
 
    <div class="header">
        <div class="title">
            <h1>Laporan Asset</h1>
        </div>
        <div class="detail">
            <div class="left">
                <p><span class="bold">Asset Code:</span> {{ $asset->code }}</p>
                <p><span class="bold">Asset Name:</span> {{ $asset->name }}</p>
                <p><span class="bold">Parent:</span> {{ $asset->parent->name ?? '-' }}</p>
                <p><span class="bold">Model:</span> {{ $asset->model }}</p>
                <p><span class="bold">Brand:</span> {{ $asset->brand }}</p>
                <p><span class="bold">Purchase Date:</span> {{ date('d M Y', strtotime($asset->purchase_at)) }}</p>
                <p><span class="bold">Price:</span> {{ "Rp " . number_format($asset->purchase_price,2,',','.') }}</p>
                <p><span class="bold">Location:</span> {{ $asset->location->address }}</p>
            </div>
            <div class="right">
                <p><span class="bold">Description:</span> {{ $asset->description }}</p>
                <p><span class="bold">Category:</span> {{ $asset->category->name }}</p>
                <p><span class="bold">Type:</span> {{ $asset->type->name }}</p>
                <p><span class="bold">Status:</span> {{ $asset->status ? 'Active' : 'Inactive' }}</p>
                <p><span class="bold">Date:</span> {{ date('Y/m/d H:i:s') }}</p>
            </div>
        </div>

        <hr style="clear: both">

        <div class="table">
            <legend style="font-weight: 600; font-size: 19px">Maintenance:</legend>
            <table>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Priority</th>
                </tr>
                @forelse ($asset->scheduleMaintenances as $schedule_maintenance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $schedule_maintenance->code }}</td>
                        <td>{{ $schedule_maintenance->name }}</td>
                        <td>{{ $schedule_maintenance->priority }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center">No Data Available</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <div class="table">
            <legend style="font-weight: 600; font-size: 19px">Boms:</legend> <br>
            {{ $boms->count() > 0 ? implode(", ", $boms->pluck('name')->toArray()) : '-'}}
        </div>

        <div class="table">
            <legend style="font-weight: 600; font-size: 19px">Material:</legend> <br>
            {{ count($material) > 0 ? implode(", ", $material) : '-'}}
        </div>

        <div class="table">
            <legend style="font-weight: 600; font-size: 19px">Children of asset:</legend> <br>
            {{ $asset->children->count() > 0 ? implode(", ", $asset->children->pluck('name')->toArray()) : '-'}}
        </div>

        <div class="images">
            <legend style="font-weight: 600; font-size: 19px;">Images:</legend> <br>
            <img src="{{ public_path('img/assets/' . $asset->image) }}" alt="" class="asset-image">
        </div>
    </div>
</body>
</html>