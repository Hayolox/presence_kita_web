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
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Session</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ url()->previous() }}"> <div class=" btn btn-primary mb-2">Kembali</div></a>
                        <div class="table-responsive">
                            <form action="{{ route('ManagePresence.classrooms.pratikum.session.store',$classroomsPratikumId) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label  class="form-label">Judul</label>
                                    <input type="text" name="title" class="form-control">
                                </div>

                                <div class="mb-3">
                                  <label  class="form-label">Mulai</label>
                                  <input type="time" name="start" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Selesai</label>
                                    <input type="time" name="finish" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Tanggal</label>
                                    <input type="date" name="date" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="room_id" aria-label="Default select example">
                                        <option value="" selected>Pilih Ruangan</option>
                                        @foreach ($rooms as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
                                </div>


                                <div class="mb-3">
                                    <select class="form-select" name="geolocation" aria-label="Default select example">
                                        <option value="" selected>Aktifkan Geolocation</option>
                                        <option value="0">False</option>
                                        <option value="1">True</option>
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
