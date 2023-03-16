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
                    <div class="card-body">
                            <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                                <a href="{{ route('ManageSubject.create.classroom', $subject_course_code) }}">   <div class="btn btn-primary mt-1 mb-4 mr-3">Tambah Kelas</div></a>
                            </div>


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
                                    <tr>
                                        <th scope="row">{{ $classrooms->firstItem() + $data }}</th>
                                        <td>{{ $item->name}}</td>
                                        <td>
                                            <a href="{{ route('ManageSubject.student',$item->id) }}" class="btn btn-primary">Mahasiswa</a>
                                            <a href="{{ route('ManageSubject.lecturer', $item->id) }}" class="btn btn-primary">Dosen</a>
                                            <form action="{{ route('ManageSubject.destroy.classroom', $item->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?')" class="btn btn-danger btn-circle btn-lg"><i class="fas fa-trash"></i></button>
                                            </form>
                                            <td>
                                    </tr>
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
