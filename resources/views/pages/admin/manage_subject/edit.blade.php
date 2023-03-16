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
                        <h6 class="m-0 font-weight-bold text-primary">Edit Mata Kuliah</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('ManageSubject.update',$subject->course_code) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label  class="form-label">Kode Mata kuliah</label>
                                    <input type="text" value="{{ $subject->course_code }}" name="course_code" class="form-control">
                                  </div>

                                <div class="mb-3">
                                    <label  class="form-label">Full Name</label>
                                    <input type="text" value="{{ $subject->full_name }}" name="full_name" class="form-control">
                                </div>

                                <div class="mb-3">
                                  <label  class="form-label">Nickname</label>
                                  <input type="text" value="{{ $subject->nickname }}"  name="nickname" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">SKS</label>
                                    <input type="text" value="{{ $subject->sks }}"  name="sks" class="form-control">
                                  </div>

                                {{-- <div class="mb-3">
                                    <select class="form-select" name="major_id" aria-label="Default select example">
                                        @foreach ($majors as $item )
                                        <option {{ $subject->major_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
                                </div> --}}

                                {{-- <div class="mb-3">
                                    <select class="form-select" name="semester_id" aria-label="Default select example">
                                        @foreach ($semesters as $item )
                                        <option {{ $subject->semester_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
                                </div> --}}

                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
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
