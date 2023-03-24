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
                        <h6 class="m-0 font-weight-bold text-primary">Session</h6>
                    </div>
                    <div class="card-body">
                      <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                        <a href="{{ route('ManagePresence') }}">  <div class=" btn btn-primary mb-2 mr-2">Kembali</div></a>
                        <a href="{{ route('ManagePresence.session.izin',  $classrooms_id) }}">  <div class=" btn btn-info mb-2 mr-2">Izin : {{ $countIzin }}</div></a>
                        @if ($countSession == 0)
                        <a href="{{ route('ManagePresence.session.create',$classrooms_id) }}" class="btn btn-secondary mb-4">Tambah Data</a>
                        @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Mulai</th>
                                        <th>Berakhir</th>
                                        <th>Tanggal</th>
                                        <th>Geolocation</th>
                                        <th>Nama Dosen</th>
                                        <th>QrCode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ( $session  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $session->firstItem() + $data }}</th>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->start }}</td>
                                        <td>{{ $item->finish }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->geolocation == 1 ? 'true' : 'false' }}</td>
                                        <td>{{ $item->lecturer->full_name  }}</td>
                                        <td>
                                            <a href="{{ route('ManagePresence.QrCode',[$item->id, $item->QrCode]) }}" target="_blank" class="btn btn-secondary">Qr-Code</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('ManagePresence.presence', [$item->id, $classrooms_id]) }}" class="btn btn-primary">Mahasiswa</a>
                                            <a href="{{ route('ManagePresence.session.edit', [$item->id, $classrooms_id]) }}" class="btn btn-info mt-1">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            {{ $session->links() }}
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
