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
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Kuliah Tahun Ajaran {{ $setting->year }}
                        </h6>
                    </div>
                    <div class="card-body">


                        <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                            {{-- <div>
                                <h4></h4>
                            </div> --}}
                            <form action="{{ route('ManageSubject.index') }}">
                                <div class="input-group col-12 mb-3">
                                    <input type="search" name="search" class="form-control rounded"
                                        placeholder="Search Nama Panjang" aria-label="Search"
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
                                        <th>Kode Mata Kuliah</th>
                                        <th>Nama Panjang</th>
                                        <th>Nickname</th>
                                        <th>Mahasiswa</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                @foreach ($subjects as $data => $item)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $subjects->firstItem() + $data }}</th>
                                            <td>{{ $item->course_code }}</td>
                                            <td>{{ $item->major->name . ' - ' . $item->full_name . ' (' . $item->sks . ' SKS) (' . $item->semester->name . ')' }}
                                            </td>
                                            <td>{{ $item->nickname }}</td>
                                            <td>{{ $item->jumlah }}</td>

                                            <td>
                                                <a href="{{ route('ManageSubject.classroom', $item->course_code) }}"
                                                    class="btn btn-primary">Kelas</a>
                                                <a href="{{ route('ManageSubject.edit', $item->course_code) }}"
                                                    class="btn btn-info btn-circle btn-lg"><i
                                                        class="fas fa-pencil-ruler"></i></a>
                                        </tr>
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
