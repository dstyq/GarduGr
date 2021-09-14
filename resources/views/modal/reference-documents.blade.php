<table class="table table-hover" id="table1">
    <thead>
        <tr>
            <th></th>
            <th>No</th>
            <th>Filename</th>
            <th>Size</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($documents as $document)
        <tr>
            <td>{{ $document->id }}</td>
            <td>{{ $loop->iteration }}</td>
            <td>                                             
                <a href="{{ asset('docs/'.$document->filename) }}" target="_blank">
                    {{ Str::limit($document->filename ?? "N/A", 45, '...') }}
                </a> 
            </td>
            <td>{{ ($document->filename) ? number_format(filesize(public_path('docs/' . $document->filename)) / 1024, 1) . ' KB' : "0 KB" }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    
</script>