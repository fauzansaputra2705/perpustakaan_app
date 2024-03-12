<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kartu Pendaftaran</title>

    <style type="text/css">

        @font-face {
            font-family: 'Plus Jakarta Sans Style';
            font-style: normal;
            src: url("{{ public_path('fonts/Plus_Jakarta_Sans/static/PlusJakartaSans-Regular.ttf') }}")
            format('truetype');
        }
        @font-face {
            font-family: 'Plus Jakarta Sans Bold Style';
            font-style: normal;
            src: url("{{ public_path('fonts/Plus_Jakarta_Sans/static/PlusJakartaSans-Bold.ttf') }}")
            format('truetype');
        }

        /* * {
            border: 1px solid black;
        } */

        .bold {
            font-family: 'Plus Jakarta Sans Bold Style', sans-serif !important;
        }

        html,
        body {
            font-family: 'Plus Jakarta Sans Style', sans-serif;
            height: 100%;
            margin: 5px;
            padding: 10px;
            border: 0;
            font-size: 14px;
        }

        div {
            margin: 0;
            border: 0;
        }

        .Col {
            display: table-cell;
            width: 30%;
            height: 30%;
        }

        td {
            vertical-align: top;
            position: relative;
        }

        table.fixed {
            table-layout: fixed;
            border-style: solid;
            border-color: white;
            width: 350px;
        }

        td .content {
            /*position: absolute;*/
            top: 0;
            bottom: 0;
            left: 60;
            right: 0;
            color: black;
            font-size: 80%;
            background: white;
            text-align: center;
            vertical-align: middle;
        }

        .text-center {
            text-align: center !important;
        }

        .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div id="header">
        <table aria-hidden="true">
            <tr>
                <td style="width: 100px">
                    <div style="margin-top: 15px">
                        <img src="{{ public_path('image/logo-kemenag.png') }}" height="50px" width="50px"
                        alt="logo kemenag">
                        <img src="{{ public_path('image/logo-gtk-madrasah.jpeg') }}" height="50px" width="50px"
                        alt="logo gtk madrasah"
                        />
                        <img src="{{ public_path('image/logo.png') }}"
                        alt="logo"
                        />
                    </div>
                </td>
                <td style="width: 375px;">
                    <span class="bold" style="font-size: 20px;">KEMENTERIAN AGAMA RI </span>
                    <br />
                    <span style="font-size: 16px; margin-top: 10px;">
                        Profil Calon Pengawas pada
                        <br /> {{ $periode->nama_periode }}
                        Tahun {{ explode('-', $periode->tahun)[0] }}
                    </span>
                </td>
                <td style="text-align: center; width: 200px;">
                    <span class="bold" style="font-size: 16px;">KARTU PENDAFTARAN</span>
                    <br />
                    <span class="bold">
                        <span>
                            <?php
                            echo DNS1D::getBarcodeHTML("$pengajuan->no_pendaftaran", 'C93', 1.6, 50);
                            ?>
                        </span>
                    </span>
                </td>
            </tr>
        </table>

        <hr style="color: #D0D0D0">

        <table style="width: 100%;">
            <caption></caption>
            <thead><th></th></thead>
            <tr>
                <td style="width: 70%">
                    <table>
                        <caption></caption>
                        <thead><th></th></thead>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <span class="bold" style="font-size: 17px">Informasi Pribadi</span>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>: <span>{!! $pendidik->nik !!}</span></td>
                            </tr>
                            <tr>
                                <td>Nama Calon Pengawas </td>
                                <td>: <span>{!! $pendidik->nama_lengkap !!}</span></td>
                            </tr>
                            <tr>
                                <td>Tempat, Tanggal Lahir </td>
                                <td>:
                                    <span>
                                        {!! $pendidik->tempat_lahir !!} /
                                        {!! formatTanggal($pendidik->tgl_lahir) !!}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Pangkat </td>
                                <td>:
                                    <span>
                                        {!! $pendidik->pangkat !!}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Golongan </td>
                                <td>:
                                    <span>
                                        {!! $pendidik->golongan !!}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <span class="bold" style="font-size: 17px">Detail Pendaftaran</span>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>Periode</td>
                                <td>:
                                    <span>{!! $periode->nama_periode !!} Tahun {!! explode('-', $periode->tahun)[0] !!}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Pendaftaran</td>
                                <td>: <span>{!! $pendaftaran->nama_program !!}</span></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengajuan</td>
                                <td>:
                                    <span>
                                        {!! formatTanggal($pengajuan->tgl_pengajuan) !!}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td style="width: 30%;">
                    <div style="width: 100%;">
                        <img
                            src="{{ public_path('storage/'.$pendidik->user->path_image) }}"
                            alt=""
                            style="width: 150px; height: 200px; object-fit: cover; margin-left: 35px;"
                        />
                        <p class="text-center">
                            Nomor Pendaftaran
                            <br/>
                            <span class="bold">
                                {{ $pengajuan->no_registrasi }}
                            </span>
                        </p>
                    </div>
                </td>
            </tr>
        </table>

        <hr style="color: #D0D0D0">
        <p class="bold" style="font-size: 17px">Kelengkapan Dokumen</p>
        <p>Saya menyatakan dengan sesungguhnya bahwa saya
            telah memenuhi kelengkapan dokumen sebagai <span class="bold">calon pengawas</span> yaitu:
        </p>
        <ol>
            @foreach ($berkas as $item)
            <li>{{ $item->nama_dokumen }}</li>
            @endforeach
        </ol>


        <table>
            <caption></caption>
            <thead><th></th></thead>
            <tr>
                <td style="width: 520px">

                </td>
                <td>
                    <p>
                        <span class="bold">Dicetak Aplikasi SIAAPP</span> <br>
                        Pada tanggal {{ formatTanggal(Date('Y-m-d')) }}
                    </p>

                    <br>

                    ttd dan Materai 10.000

                    <br>
                    <br>

                    <hr>
                    <p></p>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>
