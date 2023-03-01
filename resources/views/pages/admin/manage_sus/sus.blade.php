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
                        <h6 class="m-0 font-weight-bold text-primary">System Usability Scale </h6>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                            <div class="col-12  d-flex  d-inline d-flex justify-content-end">
                                {{-- <form action="">
                                    <div class="input-group col-12 mb-4 mt-2">
                                        <input type="search" name="search" class="form-control rounded" placeholder="Search Username" aria-label="Search"
                                          aria-describedby="search-addon" />
                                        <button type="submit" class="btn btn-outline-primary">search</button>
                                      </div>
                                </form> --}}
                            </div>
                            <div class='col-12'>
                                    <div class="row">
                                        <div class="col-sm-4">
                                             <h6> STS = Sangat Tidak Setuju</h6>
                                        </div>
                                        <div class="col-sm-4">  <h6> Nilai Aplikasi Ini Adalah {{ $description }}</h6></div>

                                    </div>
                                      <h6> TS  = Tidak Setuju</h6>
                                      <h6> RR  = Ragu Ragu</h6>
                                      <h6> S  = Setuju</h6>
                                      <h6> SS  = Sangat Setuju</h6>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Q1</th>
                                            <th>Q2</th>
                                            <th>Q3</th>
                                            <th>Q4</th>
                                            <th>Q5</th>
                                            <th>Q6</th>
                                            <th>Q7</th>
                                            <th>Q8</th>
                                            <th>Q9</th>
                                            <th>Q10</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                STS = {{ $Q1CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q1CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q1CountAnswerThree}}
                                                <br>
                                                S = {{ $Q1CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q1CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q2CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q2CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q2CountAnswerThree}}
                                                <br>
                                                S = {{ $Q2CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q2CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q3CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q3CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q3CountAnswerThree}}
                                                <br>
                                                S = {{ $Q3CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q3CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q4CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q4CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q4CountAnswerThree}}
                                                <br>
                                                S = {{ $Q4CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q4CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q5CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q5CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q5CountAnswerThree}}
                                                <br>
                                                S = {{ $Q5CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q5CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q6CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q6CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q6CountAnswerThree}}
                                                <br>
                                                S = {{ $Q6CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q6CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q7CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q7CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q7CountAnswerThree}}
                                                <br>
                                                S = {{ $Q7CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q7CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q8CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q8CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q8CountAnswerThree}}
                                                <br>
                                                S = {{ $Q8CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q8CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q9CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q9CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q9CountAnswerThree}}
                                                <br>
                                                S = {{ $Q9CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q9CountAnswerFive }}
                                            </td>

                                            <td>
                                                STS = {{ $Q10CountAnswerOne}}
                                                <br>
                                                TS = {{ $Q10CountAnswerTwo}}
                                                <br>
                                                RR = {{ $Q10CountAnswerThree}}
                                                <br>
                                                S = {{ $Q10CountAnswerFour}}
                                                <br>
                                                SS = {{ $Q10CountAnswerFive }}
                                            </td>

                                            <td>
                                               {{ $total }}
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>



                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q3</th>
                                        <th>Q4</th>
                                        <th>Q5</th>
                                        <th>Q6</th>
                                        <th>Q7</th>
                                        <th>Q8</th>
                                        <th>Q9</th>
                                        <th>Q10</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                @foreach ( $students  as $data => $item )
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $students->firstItem() + $data }}</th>
                                        <td>{{ $item->student_nsn }}</td>
                                        <td>{{ $item->student->name }}</td>
                                        <td>{{ $item->Q1 }}</td>
                                        <td>{{ $item->Q2 }}</td>
                                        <td>{{ $item->Q3 }}</td>
                                        <td>{{ $item->Q4 }}</td>
                                        <td>{{ $item->Q5 }}</td>
                                        <td>{{ $item->Q6 }}</td>
                                        <td>{{ $item->Q7 }}</td>
                                        <td>{{ $item->Q8 }}</td>
                                        <td>{{ $item->Q9 }}</td>
                                        <td>{{ $item->Q10 }}</td>
                                        <td>{{ $item->amount }}</td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

@endsection
