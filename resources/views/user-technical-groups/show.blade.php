<table class="table display responsive nowrap datatable2 table-bordered" id="">
    <thead class="thead-dark">
        <th width="2%">No</th>
        <th>Avatar</th>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Whatsapp</th>
        <th>Address</th>
    </thead>
    <tbody>
        @foreach ($user_technical_group->userTechnicals as $user_technical)
        <tr>
            <td style="color: black">{{ $loop->iteration }}</td>
            <td>
                <img src="{{ asset('img/user-technicals/'.($user_technical->avatar ?? 'user.png')) }}" width="40px" class="img-circle">
            </td>
            <td style="color: black">{{ $user_technical->name }}</td>
            <td style="color: black">{{ $user_technical->username }}</td>
            <td style="color: black">{{ $user_technical->email }}</td>
            <td style="color: black">{{ $user_technical->phone }}</td>
            <td style="color: black">{{ $user_technical->whatsapp }}</td>
            <td style="color: black">{{ $user_technical->address }}</td>
        </tr>
        @endforeach
    </tbody>
</table>