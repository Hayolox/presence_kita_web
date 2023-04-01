@php
    // dd($pertemuan);
@endphp


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
    <div style="background-color: #A9A9A9;">

        <div style="display: flex; justify-content: end;">
            <p class="btn btn-primary text-nowarp mt-4 mr-4" onclick="downloadPdf()">
                Download Pdf
            </p>
        </div>
        <div id="wrapper">


            <div style=" display: flex; justify-content: center; width: 100%;  ">
                <div id="pdf-content" style="background-color: white; width: 1100px;  padding: 40px 38px">
                    <div>
                        <table style="width: 100%;" id="list-header">
                            <tr>
                                <td rowspan="2" style="width: 120px; vertical-align: top;" class="logo-pdf">
                                    <img width=" 100px" src="{{ asset('/assets/img/newLogo.png') }}" alt="">
                                </td>
                                <td style="text-align: center; font-size: 22px; line-height: 100%"> KEMENTERIAN
                                    PENDIDIKAN,
                                    KEBUDAYAAN, <br>
                                    RISET, DAN TEKNOLOGI <br>
                                    UNIVERSITAS PALANGKA RAYA <br>
                                    FAKULTAS TEKNIK
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; vertical-align: top;"> Alamat : Kampus
                                    UPR Tunjung Nyaho
                                    Jalan Yos Sudarso Kotak Pos 2/PLKUP Palangka Raya 73112
                                    Kalimantan Tengah - INDONESIA<br>
                                    Telepon/Fax: +62 536-3226487 ; laman: www.upr.ac.id E-Mail:
                                    fakultas_teknik@eng.upr.ac.id
                                </td>
                            </tr>
                        </table>

                        <hr style="margin-top: 0.4rem; border-width: 2px; border-color: #808080;">
                        {{-- <td colspan="2" style="border: 1px solid #808080;">
                    </td> --}}
                        <table id="daftar-kuliah" style="width: 100%; margin: 0 0 8px 0;" id="list-header">

                            <tr>
                                <td style="width: 120px;">
                                </td>
                                <td style="text-align: center; vertical-align: top; font-size: 16px; ">
                                    DAFTAR HADIR KULIAH
                                </td>
                            </tr>
                        </table>
                    </div>


                    <div>
                        {{-- <div style="display: flex; width: 100%;">
                        <div style="width: 120px;"></div>
                        <p style="text-align: center; font-size: 14px;  width: 100%;">DAFTAR HADIR KULIAH</p>
                    </div> --}}

                        <div style="margin-bottom: 20px;">
                            <table id="list-info" class="list-info ">
                                {{-- <tr>
                                    <td colspan="100" style="text-align: center;">DAFTAR HADIR KULIAH</td>
                                </tr> --}}
                                <tr>
                                    <td>Mata Kuliah</td>
                                    <td>:</td>
                                    <td colspan="2">{{ $classroom->subject->full_name }}
                                        ({{ $classroom->subject->nickname }})
                                        ({{ $classroom->subject->course_code }})</td>
                                    <td>Jurusan/Program Studi</td>
                                    <td>:</td>
                                    <td>TEKNIK INFORMATIKA</td>
                                </tr>
                                <tr>
                                    <td>Jumlah SKS</td>
                                    <td>:</td>
                                    <td colspan="2">{{ $classroom->subject->sks }}</td>
                                    <td>Jenjang</td>
                                    <td>:</td>
                                    <td>S1. TEKNIK INFORMATIKA</td>
                                </tr>
                                <tr>
                                    <td>Ruang/Kelas</td>
                                    <td>:</td>
                                    <td colspan="2">{{ $classroom->name }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Mahasiswa</td>
                                    <td>:</td>
                                    <td colspan="2">{{ count($studentsList) }}</td>
                                </tr>
                                <tr>
                                    <td>Dosen</td>
                                    <td>:</td>
                                    <td>
                                        1. {!! isset($lecturer[0]->lecturer->full_name)
                                            ? $lecturer[0]->lecturer->full_name . $lecturer[0]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                    <td style="min-width: 200px;">
                                        5. {!! isset($lecturer[4]->lecturer->full_name)
                                            ? $lecturer[4]->lecturer->full_name . $lecturer[4]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        2. {!! isset($lecturer[1]->lecturer->full_name)
                                            ? $lecturer[1]->lecturer->full_name . $lecturer[1]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                    <td>
                                        6. {!! isset($lecturer[5]->lecturer->full_name)
                                            ? $lecturer[5]->lecturer->full_name . $lecturer[5]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        3. {!! isset($lecturer[2]->lecturer->full_name)
                                            ? $lecturer[2]->lecturer->full_name . $lecturer[2]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                    <td>
                                        7. {!! isset($lecturer[6]->lecturer->full_name)
                                            ? $lecturer[6]->lecturer->full_name . $lecturer[6]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        4. {!! isset($lecturer[3]->lecturer->full_name)
                                            ? $lecturer[3]->lecturer->full_name . $lecturer[3]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                    <td>
                                        8. {!! isset($lecturer[7]->lecturer->full_name)
                                            ? $lecturer[7]->lecturer->full_name . $lecturer[7]->lecturer_nip . ')'
                                            : '--' !!}
                                    </td>
                                </tr>

                            </table>
                        </div>


                        <div>
                            <table id="list-mahasiswa">
                                <thead>

                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>NAMA MAHASISWA</th>
                                        <th colspan="16">Paraf Kehadiran Tanggal</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($studentsList as $data => $item)
                                        <tr>
                                            <td>{{ $data + 1 }}</td>
                                            <td>{{ $item->student_nsn }}</td>
                                            <td>{{ $item->student->name }}</td>
                                            @foreach ($pertemuan as $i => $session)
                                                @php
                                                    // dd($i);
                                                    $index = explode('-', $i)[1];
                                                    // dd($index);
                                                @endphp

                                                @if ($item['pertemuan' . $index])
                                                    @if ($item['pertemuan' . $index] == 'hadir')
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
                                            @endforeach
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" style="text-align: left; padding-left: 25px;">Jumlah
                                            Mahasiswa
                                            Hadir</td>

                                        @foreach ($pertemuan as $i => $session)
                                            @php
                                                // dd($i);
                                                $index = explode('-', $i)[1];
                                                // dd($index);
                                            @endphp
                                            <td style="text-align: center; vertical-align: middle;">
                                                {{ $pertemuan['ke-' . $index] }}</td>
                                        @endforeach
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: left; padding-left: 25px;">Tandatangan
                                            Dosen
                                            Mata Kuliah</td>

                                        @for ($i = 0; $i < 16; $i++)
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

                    <div style="">
                        <table id="ttd-pdf" style="margin-top:  80px;  width: 100%;">
                            <tr>
                                <td style="padding-left: 120px;">Catatan : Bagi Mahasiswa yang Namanya tidak tercantum,
                                    segera menghubungi Bagian
                                    Akademik
                                    Fakultas</td>
                                <td style="padding-right: 200px;">Palangka Raya,<br>
                                    Dosen,</td>
                            </tr>
                            <tr>
                                <td style="padding-top: 60px;"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{!! isset($lecturer[0]->lecturer->full_name)
                                    ? $lecturer[0]->lecturer->full_name . '<br>' . $lecturer[0]->lecturer_nip . ')'
                                    : '' !!}</td>
                            </tr>
                        </table>

                    </div>
                </div>

            </div>


        </div>

        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
    <!-- Page Wrapper -->





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
                    startY: pdf.lastAutoTable.finalY,
                    html: '#list-header',
                    styles: {
                        cellPadding: 0,

                    },
                    // theme: 'plain',
                    columnStyles: {
                        0: {
                            minCellWidth: 20,
                        }
                    },
                    // styles: {
                    //     fontSize: 7.5,
                    //     cellPadding: 0,
                    //     fontStyle: 'bold'
                    useCss: true,
                    didDrawCell: (data) => {

                        if ((data.column.index == 0) && (data.cell.raw.className ==
                                "logo-pdf")) {
                            let td = data.cell.raw
                            let img = td.getElementsByTagName('img')[0]
                            let dim = data.cell.height
                            var textPos = data.cell
                            pdf.addImage(img, "PNG", textPos.x + 1, textPos.y, dim - 10, dim - 10);


                        }
                    }
                    // },


                    // verticalPageBreakRepeat: 'id',
                }

            );

            pdf.line(14, pdf.lastAutoTable.finalY + 0.6, 316, pdf.lastAutoTable.finalY + 0.6);


            pdf.autoTable({
                    startY: pdf.lastAutoTable.finalY + 3.5,
                    html: '#daftar-kuliah',
                    columnStyles: {
                        0: {
                            minCellWidth: 6,
                        }
                    },



                    useCss: true,

                    // verticalPageBreakRepeat: 'id',
                }

            );
            pdf.autoTable({
                    startY: pdf.lastAutoTable.finalY + 2,
                    html: '#list-info',
                    theme: 'plain',
                    styles: {
                        fontSize: 7.5,
                        cellPadding: 0,
                        fontStyle: 'bold'
                    },
                    columnStyles: {
                        2: {
                            minCellWidth: 50,
                        },
                        3: {
                            minCellWidth: 50,
                        }
                    },


                    // useCss: true,

                    // verticalPageBreakRepeat: 'id',
                }

            );



            pdf.autoTable({
                    startY: pdf.lastAutoTable.finalY + 4,
                    html: '#list-mahasiswa',
                    useCss: true,
                    styles: {
                        // fontSize: 7.5,
                        cellPadding: 20,
                        // fontStyle: 'bold'
                    },
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

            pdf.autoTable({
                    startY: pdf.lastAutoTable.finalY + 8,
                    html: '#ttd-pdf',
                    useCss: true,
                    styles: {
                        // fontSize: 7.5,

                        // fontStyle: 'bold'
                    },

                    // verticalPageBreakRepeat: 'id',
                }

            );

            pdf.save('table.pdf');


        }
        // $(() => {

        // })
    </script>
</body>

</html>
