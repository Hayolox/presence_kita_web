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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Kecurangan</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                            <form action="{{ route('check.login') }}">
                                <div class="input-group col-12 mb-3">
                                    <input type="search" name="search" class="form-control rounded"
                                        placeholder="Search NIM" aria-label="Search" aria-describedby="search-addon" />
                                    <button type="submit" class="btn btn-outline-primary">search</button>
                                    <a type="submit" href="{{ route('check.history') }}"
                                        class="btn btn-primary ml-2">history</a>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                @foreach ($duplicateRecords as $data => $item)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $item->student_nsn }}</td>
                                            <td>{{ $item->student->name }}</td>
                                            <td>
                                                <form action="{{ route('check.login.destroy', $item->student_nsn) }}"
                                                    method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                        onclick="return confirm('Yakin untuk menghapus?')"
                                                        class="btn btn-danger btn-circle btn-lg"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            </td>

                                        </tr>
                                    </tbody>
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
