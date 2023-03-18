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
                        <h6 class="m-0 font-weight-bold text-primary">Izin</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                            <a href="{{ url()->previous() }}">  <div class=" btn btn-primary mb-2 mr-2">Kembali</div></a>
                            </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @foreach ( $presence  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $presence->firstItem() + $data }}</th>
                                        <td>{{ $item->student_nsn }}</td>
                                        <td>{{ $item->student->name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="" target="_blank" class="btn btn-info">PDF</a>
                                            <a href="" target="_blank" class="btn btn-success">Terima</a>
                                            <a href="" target="_blank" class="btn btn-danger">Tidak</a>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            {{ $presence->links() }}
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
