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
                                            <form action="{{ route('ManagePresence.classrooms.pratikum.student.import', $classroomsPratikumId) }}" method="POST" enctype="multipart/form-data">
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
                                <a href="{{ route('ManageSubject.dataStudentDownloadTemplate') }}">   <div class="btn btn-primary mt-2 mb-4 mr-3">Download Template</div></a>
                                <a href="{{ route('ManagePresence.classrooms.pratikum.student.create', $classroomsPratikumId) }}">   <div class="btn btn-primary mt-2 mb-4 mr-3">Tambah Mahasiswa</div></a>
                                <form action="{{ route('ManageSubject.student', $classroomsPratikumId) }}">
                                    <div class="input-group col-12 mb-3 mt-2 mb-4">
                                        <input type="search" name="search" class="form-control rounded" placeholder="Search NIM" aria-label="Search"
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
                                        <th>Nama Mahasiswa</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ( $students  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $students->firstItem() + $data }}</th>
                                        <td>{{ $item->student->nsn }}</td>
                                        <td>{{ $item->student->name}}</td>
                                        <td>
                                            <form action="{{ route('ManageSubject.studentDestroy', $item->id) }}" method="POST" class="d-inline-block">
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
