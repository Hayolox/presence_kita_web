{{-- @php
    dd($studentsList[0]->student->toArray());
@endphp --}}

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin-Presence Kita</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            color: black;
            font-size: 10px;
            font-weight: 900;
        }

        * {
            margin: 0;
            padding: 0;
        }

        #list-info {
            width: 100%;
        }

        .list-info tr td:nth-child(2) {

            padding: 0px 8px;

        }

        .list-info tr td {

            vertical-align: top;

        }

        #list-dosen li {
            padding-right: 8px;
        }

        #list-mahasiswa {
            border-collapse: collapse;
            width: 100%;
        }

        #list-mahasiswa th {
            text-align: center;
            padding: 4px 2px;
            font-weight: 900;
        }

        #list-mahasiswa td {
            padding: 4px 2px;
        }

        #list-mahasiswa td:nth-child(1) {
            text-align: center;
        }

        .absen-mark {
            text-align: center;
        }

        .ijin-mark {
            width: 10px;
            text-align: center;
            vertical-align: middle;
        }

        .alpha-mark {
            width: 10px;


            text-align: center;
            vertical-align: middle;
        }

        #list-mahasiswa,
        #list-mahasiswa td,
        #list-mahasiswa th {
            border: 0.1rem solid;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" style="background-color: #A9A9A9; ">
        {{-- <div>
            <button onclick="downloadPdf()">test</button>
        </div> --}}


        <div style=" display: flex; justify-content: center; width: 100%;  margin-top:80px; margin-bottom:80px;">
            <div id="pdf-content" style="background-color: white; width: 1100px;  padding: 40px 38px">

                <div style="display: flex">
                    <div><img width="120px" style="" src="{{ asset('/assets/img/newLogo.svg') }}" alt="logo"
                            srcset=""></div>
                    <div style="width: 100%; display: flex; align-items: center; flex-direction: column;">
                        <h1 style="color: black; font-size: 20px; font-weight: 900; text-align: center;">
                            KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, <br>
                            RISET, DAN TEKNOLOGI <br>
                            <span style=" font-size: 22px;"> UNIVERSITAS PALANGKA RAYA <br>
                                FAKULTAS TEKNIK</span>
                        </h1>
                        <p
                            style="color: black; font-size: 10px; font-weight: 900; text-align: center; margin-bottom: 0px;">
                            Alamat : Kampus
                            UPR Tunjung Nyaho
                            Jalan Yos Sudarso Kotak Pos 2/PLKUP Palangka Raya 73112
                            Kalimantan Tengah - INDONESIA<br>
                            Telepon/Fax: +62 536-3226487 ; laman: www.upr.ac.id E-Mail: fakultas_teknik@eng.upr.ac.id
                        </p>
                    </div>
                </div>
                <hr style="margin-top: 0.4rem; border-width: 2px; border-color: #808080;">
                <div>
                    <div style="display: flex; width: 100%;">
                        <div style="width: 120px;"></div>
                        <p style="text-align: center; font-size: 14px;  width: 100%;">DAFTAR HADIR KULIAH</p>
                    </div>
                    <div style="display: flex; justify-content: space-between">
                        <div>
                            <table id="list-info" class="list-info ">
                                {{-- <tr>
                                    <td colspan="100" style="text-align: center;">DAFTAR HADIR KULIAH</td>
                                </tr> --}}
                                <tr>
                                    <td>Mata Kuliah</td>
                                    <td>:</td>
                                    <td>ADMINISTRASI BASIS DATA - MATA KULIAH PILIHAN (REKAYASA PERANGKAT LUNAK)
                                        (1DCP738030)</td>
                                    <td>Jurusan/Program Studi</td>
                                    <td>:</td>
                                    <td>TEKNIK INFORMATIKA</td>
                                </tr>
                                <tr>
                                    <td>Jumlah SKS</td>
                                    <td>:</td>
                                    <td>3</td>
                                    <td>Jenjang</td>
                                    <td>:</td>
                                    <td>S1. TEKNIK INFORMATIKA</td>
                                </tr>
                                <tr>
                                    <td>Ruang/Kelas</td>
                                    <td>:</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Mahasiswa</td>
                                    <td>:</td>
                                    <td>65</td>
                                </tr>
                                <tr>
                                    <td>Dosen</td>
                                    <td>:</td>
                                    <td>
                                        <ol id="list-dosen"
                                            style="padding-left: 12px; -webkit-column-count: 2; -moz-column-count: 2; -o-column-count: 2; column-count: 2; width:600px;">
                                            <li>Efrans Christian., ST., MT. (199106302019031013)</li>
                                            <li>SEPTIAN GEGES, S.Kom., M.Kom. (199109172020121004)</li>
                                            <li>--</li>
                                            <li>--</li>
                                            <li>--</li>
                                            <li>--</li>
                                            <li>--</li>
                                            <li>--</li>
                                        </ol>
                                    </td>
                                </tr>

                            </table>
                        </div>

                    </div>
                    <div>
                        <table id="list-mahasiswa">
                            <thead>

                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>NAMA MAHASISWA</th>
                                    <th colspan="18">Paraf Kehadiran Tanggal</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($studentsList as $data => $item)
                                    <tr>
                                        <td>{{ $data + 1 }}</td>
                                        <td>{{ $item->student_nsn }}</td>
                                        <td>{{ $item->student->name }}</td>
                                        @for ($i = 0; $i < 18; $i++)
                                            @if ($item['pertemuan' . $i + 1])
                                                @if ($item['pertemuan' . $i + 1] == 'hadir')
                                                    <td class="absen-mark"><img width="20px" class="img-test"
                                                            src="{{ asset('/assets/img/checkicon.png') }}"
                                                            alt="" srcset=""></td>
                                                @else
                                                    <td class="ijin-mark"><span
                                                            style="text-align: center; font-size: 14px; font-weight: 600; padding: 0 9px;"
                                                            style="display: flex; justify-content: center;">i</span>
                                                    </td>
                                                @endif
                                            @else
                                                <td class="alpha-mark">
                                                    <span
                                                        style="text-align: center; font-size: 14px; font-weight: 600; padding: 0 9px;"
                                                        style="display: flex; justify-content: center;">X</span>
                                                </td>
                                            @endif
                                        @endfor
                                        <td></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">Jumlah Mahasiswa Hadir</td>

                                    @for ($i = 0; $i < 18; $i++)
                                        <td></td>
                                    @endfor
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Tandatangan Dosen Mata Kuliah</td>

                                    @for ($i = 0; $i < 18; $i++)
                                        <td></td>
                                    @endfor
                                    <td></td>
                                </tr>
                            </tbody>
                            {{-- @php
                                dd($studentsList);
                            @endphp --}}
                        </table>

                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 0 120px; margin: 50px 0;">
                    <div>Catatan : Bagi Mahasiswa yang Namanya tidak tercantum, segera menghubungi Bagian Akademik
                        Fakultas</div>
                    <div style="">
                        <p style="margin: 0 0 70px 0;">Palangka Raya,<br>
                            Dosen,</p>
                        <p>Efrans Christian., ST., MT.<br>
                            199106302019031013
                        </p>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>





    @include('includes.admin.scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.5.28/dist/jspdf.plugin.autotable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        window.jsPDF = window.jspdf.jsPDF;

        // const doc = new jsPDF()
        // doc.autoTable({
        //     html: '#my-table'
        // })
        // doc.save('table.pdf')
        // window.jsPDF = window.jspdf;
        // console.log(window.jspdf);

        const data = [
            @foreach ($studentsList as $data => $item)
                @php
                    echo '{' . 'nim : "' . $item->student->nsn . '",' . 'nama : "' . $item->student->name . '",' . '},';
                    
                @endphp
            @endforeach
        ];

        function downloadPdf() {

            let pdf = new jsPDF({
                orientation: "landscape",
                format: [210, 330]
            });

            var columns = [

                {
                    title: "No",
                    dataKey: "no"
                },
                {
                    title: "NIM",
                    dataKey: "nim"
                },
                {
                    title: "NAMA MAHASISWA",
                    dataKey: "nama"
                },
                {
                    title: "Paraf Kehadiran Tanggal",
                    dataKey: "paraf"
                },
                {
                    title: "Catatan",
                    dataKey: "catatan"
                },

            ];

            var generateData = function() {
                var result = [];

                data.map((d, i) => {
                    // console.log(d.nim, i);
                    template = {
                        nim: d.nim,
                        nama: d.nama,
                        paraf: " asd",
                        catatan: "sa",
                    }
                    template.no = (i + 1).toString();
                    result.push(Object.assign({}, template));
                })


                return result;
            };

            const check = document.querySelector(".img-test");

            // doc.addImage(check, "PNG", 0, 0, 20, 20);


            // html2canvas(check).then(function(canvas) {
            //     const img = canvas.toDataURL("image/jpg");
            //     console.log(img);


            // });
            // pdf.text(0, 20, 'Hello world!');
            // pdf.text(0, 30, 'This is client-side Javascript, pumping out a PDF.');

            pdf.autoTable({
                    startY: 20,
                    html: '#list-info',
                    useCss: true,

                    // verticalPageBreakRepeat: 'id',
                }

            );
            pdf.autoTable({
                    startY: 70,
                    html: '#list-mahasiswa',
                    useCss: true,
                    didDrawCell: (data) => {

                        if ((data.column.index >= 3) && (data.column.index <= 20) && (data.cell.raw.className ==
                                "absen-mark")) {
                            let td = data.cell.raw
                            let img = td.getElementsByTagName('img')[0]
                            let dim = data.cell.height
                            var textPos = data.cell
                            pdf.addImage(img, "PNG", textPos.x + 1, textPos.y, dim, dim);


                        }
                    }
                    // verticalPageBreakRepeat: 'id',
                }

            );
            // pdf.autoTable(columns, generateData(), {
            //     theme: 'grid',
            //     styles: {

            //     },
            //     columnStyles: {
            //         id: {

            //         }
            //     },
            //     margin: {
            //         top: 20
            //     },

            // });
            pdf.save('table.pdf');


        }
        // $(() => {

        // })
    </script>
</body>

</html>
