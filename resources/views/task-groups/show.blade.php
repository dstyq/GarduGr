<table class="table display responsive nowrap datatable2 table-bordered" id="">
    <thead class="thead-dark">
        <th width="2%">No</th>
        <th>Task</th>
        <th>Description</th>
        <th>Time Estimate <small>(minutes)</small></th>
    </thead>
    <tbody>
        @foreach ($task_group->tasks as $task)
        <tr>
            <td style="color: black">{{$loop->iteration}}</td>
            <td style="color: black">{{$task->task}}</td>
            <td style="color: black">{{ $task->description ?? 'N/A' }}</td>
            <td style="color: black">{{ $task->time_estimate ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>