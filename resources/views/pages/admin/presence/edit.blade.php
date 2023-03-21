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
                        <h6 class="m-0 font-weight-bold text-primary">Edit Session</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ url()->previous() }}"> <div class=" btn btn-primary mb-2">Kembali</div></a>
                        <div class="table-responsive">
                            <form action="{{ route('ManagePresence.session.update', [$session->id, $classrooms_id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label  class="form-label">Judul</label>
                                    <input type="text" value="{{ $session->title }}" name="title" class="form-control">
                                </div>

                                <div class="mb-3">
                                  <label  class="form-label">Mulai</label>
                                  <input type="time" value="{{ $session->start }}"   name="start" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Selesai</label>
                                    <input type="time" value="{{ $session->finish }}"  name="finish" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Tanggal</label>
                                    <input type="date" value="{{ $session->date }}" name="date" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="room_id" aria-label="Default select example">
                                        <option value="" selected>Pilih Ruangan</option>
                                        @foreach ($rooms as $item )
                                        <option {{ $item->id == $session->room_id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="lecturer_nip" aria-label="Default select example">

                                        @foreach ($lecturers as $item )
                                        <option {{ $item->lecturer_nip == $session->lecturer_nip ? 'selected' : '' }} value="{{ $item->lecturer_nip }}">{{ $item->lecturer->full_name }}</option>
                                        @endforeach
                                      </select>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="geolocation" aria-label="Default select example">

                                        <option {{ $session->geolocation == 0 ? 'selected' : '' }} value="0">False</option>
                                        <option  {{ $session->geolocation == 1 ? 'selected' : '' }} value="1">True</option>
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
