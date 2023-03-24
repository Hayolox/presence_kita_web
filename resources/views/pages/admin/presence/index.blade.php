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
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Mata Kuliah</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @foreach ( $subjects  as $data => $item )
                                <tbody>
                                    @if (auth()->guard('web')->check())
                                        <tr>
                                            <th scope="row">{{ $subjects->firstItem() + $data }}</th>
                                            <td>{{ $item->course_code }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>
                                                <a href="{{ route('ManagePresence.classrooms', $item->course_code) }}" class="btn btn-info">Kelas</a>
                                            </td>

                                        </tr>
                                    @endif

                                    @if (auth()->guard('lecturer')->check())
                                        @if ($data == 0 || $item->classroom->subject->course_code != $subjects[$data-1]->classroom->subject->course_code)
                                            <tr>
                                                <th scope="row">{{ $subjects->firstItem() + $data }}</th>
                                                <td>{{ $item->classroom->name }}</td>
                                                <td>{{ $item->classroom->name }}</td>
                                                <td>
                                                    <a href="{{ route('ManagePresence.classrooms', $item->classroom->subject->course_code) }}" class="btn btn-info">Kelas</a>
                                                </td>
                                            </tr>
                                    @endif

                                @endif

                                </tbody>
                                @endforeach
                            </table>
                            {{ $subjects->links() }}
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
