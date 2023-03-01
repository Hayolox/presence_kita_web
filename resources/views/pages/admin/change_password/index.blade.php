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
                        <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('change.password.admin.update') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label  class="form-label">Password Lama</label>
                                    <input type="password"  name="old_password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Password Baru</label>
                                    <input type="password"  name="new_password" class="form-control">
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
