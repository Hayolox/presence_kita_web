@extends('layouts.admin')
@section('content')
       <!-- Content Wrapper -->
       <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4 mt-5">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa</h6>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                            <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mt-2 mb-4 mr-3" data-toggle="modal" data-target="#exampleModal">
                                    Import Data
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Import Data Mahasiswa File Excel</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('ManageStudent.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="file" name="file">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('ManageStudent.template.import.student') }}" class="btn btn-primary  mt-2 mb-4 mr-3">Download Template</a>
                                <a href="{{ route('ManageStudent.create') }}" class="btn btn-primary  mt-2 mb-4">Tambah Data</a>
                                <form action="{{ route('ManageStudent.index') }}">
                                    <div class="input-group col-12 mb-4 mt-2">
                                        <input type="search" name="search" class="form-control rounded" placeholder="Search Username" aria-label="Search"
                                          aria-describedby="search-addon" />
                                        <button type="submit" class="btn btn-outline-primary">search</button>
                                      </div>
                                </form>
                            </div>


                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Angkatan</th>
                                        <th>Jurusan</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                @foreach ( $students  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $students->firstItem() + $data }}</th>
                                        <td>{{ $item->nsn }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->generation }}</td>
                                        <td>{{ $item->major->name }}</td>
                                        <td>  <a href="{{ route('ManageStudent.edit',$item->nsn) }}" class="btn btn-info btn-circle btn-lg"><i class="fas fa-pencil-ruler"></i></a>
                                            <form action="{{ route('ManageStudent.destroy', $item->nsn) }}" method="POST" class="d-inline-block">
                                              @csrf
                                              @method('delete')
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?')" class="btn btn-danger btn-circle btn-lg"><i class="fas fa-trash"></i></button>
                                            </form></td>

                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

@endsection
