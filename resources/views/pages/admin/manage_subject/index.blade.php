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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Kuliah</h6>
                    </div>
                    <div class="card-body">
                        <div class="btn btn-primary mb-4">Tambah Matakuliah</div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Matakuliah</th>
                                        <th>Nama Matakuliah</th>
                                        <th>Semester</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                @foreach ( $subjects  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $subjects->firstItem() + $data }}</th>
                                        <td>{{ $item->course_code }}</td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->semester_id }}</td>
                                        <td>  <a href="" class="btn btn-info btn-circle btn-lg"><i class="fas fa-pencil-ruler"></i></a>
                                            <form action="{{ route('lecturer-delete',$item->nip) }}" method="POST" class="d-inline-block">
                                              @csrf
                                              @method('delete')
                                                <button type="submit" onclick="return confirm('Yakin untuk menghapus?')" class="btn btn-danger btn-circle btn-lg"><i class="fas fa-trash"></i></button>
                                            </form></td>

                                    </tr>
                                </tbody>
                                {{ $subjects->links() }}
                                @endforeach
                            </table>
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
