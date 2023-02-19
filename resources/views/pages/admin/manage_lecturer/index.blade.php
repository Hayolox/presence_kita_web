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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Dosen</h6>
                    </div>
                    <div class="card-body">



                            <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                                <a href="{{ route('ManageLecturer.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
                                <form action="{{ route('ManageLecturer.index') }}">
                                    <div class="input-group col-12 mb-3">
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
                                        <th>NIP</th>
                                        <th>Full Name</th>
                                        <th>Username</th>
                                        <th>Jurusan</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                @foreach ( $lecturers  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $lecturers->firstItem() + $data }}</th>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->major->name }}</td>
                                        <td>  <a href="{{ route('ManageLecturer.edit',$item->nip) }}" class="btn btn-info btn-circle btn-lg"><i class="fas fa-pencil-ruler"></i></a>
                                            <form action="{{ route('ManageLecturer.destroy', $item->nip) }}" method="POST" class="d-inline-block">
                                              @csrf
                                              @method('delete')
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?')" class="btn btn-danger btn-circle btn-lg"><i class="fas fa-trash"></i></button>
                                            </form></td>

                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            {{ $lecturers->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2020</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

@endsection
