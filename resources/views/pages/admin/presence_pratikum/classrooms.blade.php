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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas</h6>
                    </div>

                    @if (auth()->guard('web')->check())
                        <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                            <a href="{{ route('ManagePresence.classrooms.pratikum.create', $subject_course_code) }}">   <div class="btn btn-primary mt-1 mb-1 mr-3">Tambah Kelas</div></a>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kelas</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                @foreach ( $classrooms  as $data => $item )
                                <tbody>

                                @if (auth()->guard('web')->check())
                                    <tr>
                                        <th scope="row">{{ $classrooms->firstItem() + $data }}</th>
                                        <td>{{ $item->name}}</td>
                                        <td>
                                                @if ($item->asisten && $item->asisten->classroomspratikum_id == $item->id)
                                                <a href="{{ route('ManagePresence.classrooms.pratikum.session', $item->id) }}" class="btn btn-info">Session</a>
                                                @endif

                                                @if ($item->asisten && $item->asisten->classroomspratikum_id == $item->id)


                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $item->id }}">
                                                    Edit Asisten Pratikum
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $item->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('ManagePresence.classrooms.pratikum.editAsisten', $item->id) }}" method="POST">
                                                                <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label  class="form-label">Nim Asisten Pratikum</label>
                                                                            <input type="text" value="{{ $item->asisten->student_nsn }}" name="nim" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else


                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                    Tambah Asisten Pratikum
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <form action="{{ route('ManagePresence.classrooms.pratikum.addAsisten', $item->id) }}" method="POST">
                                                        <div class="modal-body">
                                                            <div class="table-responsive">

                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">Nim Asisten Pratikum</label>
                                                                        <input type="text"  name="nim" class="form-control">
                                                                    </div>


                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <!-- Button trigger modal -->

                                                <a href="{{ route('ManagePresence.classrooms.pratikum.student', $item->id) }}" class="btn btn-primary">Mahasiswa</a>
                                        </td>
                                    </tr>
                                @endif

                                @if (auth()->guard('student')->check())
                                        @if ($item->classroompratikum->subject_course_code == $subject_course_code)
                                            <tr>
                                                <th scope="row">{{ $classrooms->firstItem() + $data }}</th>
                                                <td>{{ $item->classroompratikum->name}}</td>
                                                <td>
                                                    <a href="{{ route('ManagePresence.classrooms.pratikum.session', $item->classroompratikum->id) }}" class="btn btn-info">Session</a>
                                                    <a href="{{ route('ManagePresence.classrooms.pratikum.student', $item->classroompratikum->id) }}" class="btn btn-primary">Mahasiswa</a>
                                                </td>
                                            </tr>
                                        @endif

                                @endif


                                </tbody>
                                @endforeach
                            </table>
                            {{ $classrooms->links() }}
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
