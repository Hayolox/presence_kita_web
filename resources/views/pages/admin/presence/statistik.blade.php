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
                        <h6 class="m-0 font-weight-bold text-primary">Statistika Kelas</h6>
                    </div>
                    <div>
                        <canvas id="myChart"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Hadir', 'Izin', 'Alpha'],
            datasets: [{
              label: 'PRESENSI',
              data: [
                {{ $data['countPresent'] }},
                {{ $data['countIzin'] }},
                {{ $data['countAlpha'] }},
              ],
              borderWidth: 1
            }]
          },
          options: {
                scales: {
                    y: {
                    beginAtZero: true,
                    max: {{ $data['countAction'] }}
                    }
                }
                }
        });
      </script>

@endsection
