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
                        <h6 class="m-0 font-weight-bold text-primary">Edit Mahasiswa</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('ManageStudent.update', $student->nsn) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label  class="form-label">NIM</label>
                                    <input type="number" value="{{ $student->nsn }}" name="nsn" class="form-control">
                                </div>

                                <div class="mb-3">
                                  <label  class="form-label">Nama</label>
                                  <input type="text" value="{{ $student->name }}" name="name" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Angkatan</label>
                                    <input type="number" value="{{ $student->generation }}" name="generation" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">password</label>
                                    <input type="password"  name="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">IMEI</label>
                                    <input type="text"  name="imei" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="major_id" aria-label="Default select example">

                                        @foreach ($majors as $item )
                                        <option {{ $student->major_id == $item->major_id ? selected : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
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
