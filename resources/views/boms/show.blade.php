<table class="table display responsive nowrap datatable2 table-bordered" id="">
    <thead class="thead-dark">
        <th width="2%">No</th>
        <th>Name</th>
        <th>Model</th>
        <th>Brand</th>
        <th>Type</th>
        <th>Price</th>
    </thead>
    <tbody>
        @foreach ($materials as $material)
        <tr>
            <td style="color: black">{{$loop->iteration}}</td>
            <td style="color: black">{{$material->material_name}}</td>
            <td style="color: black">{{ $material->model }}</td>
            <td style="color: black">{{ $material->brand }}</td>
            <td style="color: black">{{ $material->type->name ?? 'N/A' }}</td>
            <td style="color: black">{{ $material->purchase_price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>