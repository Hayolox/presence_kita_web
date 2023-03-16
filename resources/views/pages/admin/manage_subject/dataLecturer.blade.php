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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Dosen Pengajar</h6>
                    </div>
                    <div class="card-body">



                            <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mt-2 mb-4 mr-3" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Data Dosen Pengajar
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Dosen Pengajar</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('ManageSubject.lecturer-store', $classrooms_id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <select class="form-select" name="lecturer_nip" aria-label="Default select example">
                                                        <option value="0" selected>Pilih Dosen</option>
                                                        @foreach ($lecturerss as $item )
                                                        <option value="{{ $item->nip }}">{{ $item->full_name }}</option>
                                                        @endforeach
                                                      </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dosen</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ( $lecturers  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $lecturers->firstItem() + $data }}</th>
                                        <td>{{ $item->lecturer->full_name}}</td>
                                        <td>
                                            <form action="{{ route('ManageSubject.lecturerDestroy', $item->id) }}" method="POST" class="d-inline-block">
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
