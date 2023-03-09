@extends('layouts.admin')
@section('content')
       <!-- Content Wrapper -->
       <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- DataTales Example -->
                <div class="card shadow mb-4 mt-2">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Mahasiswa Ke Session</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ url()->previous() }}"> <div class=" btn btn-primary mb-2">Kembali</div></a>
                        <div class="table-responsive">
                            <form action="{{ route('ManagePresence.presence.store.student', [$session_id, $course_code]) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label  class="form-label">nim</label>
                                    <input type="text" name="nim" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->



    </div>
    <!-- End of Content Wrapper -->

@endsection
