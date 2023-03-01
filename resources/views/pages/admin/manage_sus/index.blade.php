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
                        <h6 class="m-0 font-weight-bold text-primary">Soal SUS</h6>
                    </div>
                    <div class="card-body">

                        <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                            <a href="{{ route('ManageSUS.detail') }}" class="btn btn-primary mb-4">Detail SUS</a>

                        </div>

                        <div class="table-responsive">
                            <form action="" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label  class="form-label">Q1</label>
                                    <input type="text" value="{{ $sus->Q1 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q2</label>
                                    <input type="text" value="{{ $sus->Q3 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q3</label>
                                    <input type="text" value="{{ $sus->Q3 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q4</label>
                                    <input type="text" value="{{ $sus->Q4 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q5</label>
                                    <input type="text" value="{{ $sus->Q5 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q6</label>
                                    <input type="text" value="{{ $sus->Q6 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q7</label>
                                    <input type="text" value="{{ $sus->Q7 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q8</label>
                                    <input type="text" value="{{ $sus->Q8 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q9</label>
                                    <input type="text" value="{{ $sus->Q9 }}" name="course_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label  class="form-label">Q10</label>
                                    <input type="text" value="{{ $sus->Q10 }}" name="course_code" class="form-control">
                                </div>


                                <button type="submit" class="btn btn-primary">Edit</button>
                              </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
    </div>
    <!-- End of Content Wrapper -->

@endsection
