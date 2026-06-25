@extends('admin.app')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <a href="#" class="btn btn-info mt-3 mb-3" style="width: 20%;" data-toggle="modal" data-target="#modalPetugas">
            <i class="fas fa-plus-square-o"></i> Tambah Petugas
        </a>

        <p>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Id Petugas</th>
                    <th>Nama Petugas</th>
                    <th>Username</th>
                    <th>Telp</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($petugas as $index => $p)
                <tr>
                    <td>{{ $index + 1}}.</td>
                    <td>{{ $p->id_petugas }}</td>
                    <td>{{ $p->nama_petugas }}</td>
                    <td>{{ $p->username }}</td>
                    <td>{{ $p->telp }}</td>
                    <td>{{ $p->level }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $petugas->links('pagination::bootstrap-5') }}

        <!-- Modal Form Tambah Petugas -->
        <div class="modal fade" id="modalPetugas" tabindex="-1" aria-labelledby="modalPetugasLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPetugasLabel">Tambah Petugas</h5>
                    </div>
                    <form action="{{ route('admin.petugas.tambah') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <!-- Nama Petugas -->
                            <div class="form-group">
                                <label for="nama_petugas">Nama Petugas</label>
                                <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" required>
                            </div>

                            <!-- Username -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <!-- Telp -->
                            <div class="form-group">
                                <label for="telp">Telp</label>
                                <input type="text" name="telp" id="telp" class="form-control" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Akhir Modal Form Tambah Petugas -->
    </div>
</div>
@endsection