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
                        @if ($count < 1)
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Sistem</h6>
                        @else
                            <h6 class="m-0 font-weight-bold text-primary">Edit Sistem</h6>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($count < 1)
                            <form action="{{ route('ManageSystem.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <select class="form-select" name="year" aria-label="Default select example">
                                        <option selected>Pilih Tahun</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                      </select>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="semester_id" aria-label="Default select example">
                                        <option selected>Pilih Semester</option>
                                        @foreach ($semesters as $item )
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="sus" aria-label="Default select example">
                                        <option value="" selected>SUS</option>
                                        <option value="0">false</option>
                                        <option value="1">true</option>
                                      </select>
                                </div>


                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                            @else
                            <form action="{{ route('ManageSystem.update', $setting->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <p>Year</p>
                                    <select class="form-select" name="year" aria-label="Default select example">
                                        <option {{ $setting->year == 2023 ? 'selected' : '' }} value="2023">2023</option>
                                        <option {{ $setting->year == 2024 ? 'selected' : '' }} value="2024">2024</option>
                                        <option {{ $setting->year == 2025 ? 'selected' : '' }} value="2025">2025</option>
                                        <option {{ $setting->year == 2026 ? 'selected' : '' }} value="">2026</option>
                                        <option {{ $setting->year == 2027 ? 'selected' : '' }} value="2027">2027</option>
                                      </select>
                                </div>

                                <div class="mb-3">
                                    <p>Semester</p>
                                    <select class="form-select" name="semester_id" aria-label="Default select example">
                                        @foreach ($semesters as $item )
                                        <option {{ $setting->semester_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                      </select>
                                </div>

                                <div class="mb-3">
                                    <p>SUS</p>
                                    <select class="form-select" name="sus" aria-label="Default select example">
                                        <option {{ $setting->SUS == 0 ? 'selected' : '' }} value="0">False</option>
                                        <option {{ $setting->SUS == 1 ? 'selected' : '' }} value="1">True</option>
                                      </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Edit</button>
                              </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
    </div>
    <!-- End of Content Wrapper -->

@endsection
