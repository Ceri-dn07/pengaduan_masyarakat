@extends('admin.app')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <p>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Telp</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $index => $u)
                <tr>
                    <td>{{ $index + 1}}.</td>
                    <td>{{ $u->nik }}</td>
                    <td>{{ $u->nama }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->telp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $user->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection