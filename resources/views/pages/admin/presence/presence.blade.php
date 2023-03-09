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
                        <h6 class="m-0 font-weight-bold text-primary">presensi</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                            <a href="{{ url()->previous() }}">  <div class=" btn btn-primary mb-2 mr-2">Kembali</div></a>
                            <a href="{{ route('ManagePresence.presence.add.student', [$session_id, $course_code]) }}" class="btn btn-secondary mb-4">Tambah Data</a>
                            </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Status</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ( $students  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $students->firstItem() + $data }}</th>
                                        <td>{{ $item->student_nsn }}</td>
                                        <td>{{ $item->student->name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="" class="btn btn-info btn-circle btn-lg"><i class="fas fa-pencil-ruler"></i></a>
                                        </td>
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
