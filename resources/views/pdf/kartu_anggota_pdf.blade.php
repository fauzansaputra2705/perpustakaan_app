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
                        <img src="{{ public_path('image/logo.png') }}" height="100px" width="100px"
                        alt="logo"
                        />
                    </div>
                </td>
                <td style="width: 375px;">
                    <span class="bold" style="font-size: 20px;">ScholsLibris </span>
                    <br />
                    <span style="font-size: 16px; margin-top: 50px;">
                        Kartu Anggota Perpustakaan
                    </span>
                </td>
                <td style="text-align: center; width: 200px;">
                    <span class="bold" style="font-size: 16px;">KARTU PENDAFTARAN</span>
                    <br />
                    <span class="bold">
                        <span>
                            <?php
                            echo DNS2D::getBarcodeHTML(
                                route('download_kartu_anggota', ['anggotaId' => Crypt::encryptString($anggota->id)]),
                                'QRCODE',
                                3,
                                3
                            );
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
                                <td>ID Anggota</td>
                                <td>: <span>{!! $anggota->kode_anggota !!}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama </td>
                                <td>: <span>{!! $anggota->nama !!}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin </td>
                                <td>: <span>{!! $anggota->jenis_kelamin !!}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tempat, Tanggal Lahir </td>
                                <td>:
                                    <span>
                                        {!! $anggota->tempat_lahir !!} ,
                                        {!! formatTanggal($anggota->tanggal_lahir) !!}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Alamat </td>
                                <td>:
                                    <span>
                                        {!! $anggota->alamat !!}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Bergabung</td>
                                <td>:
                                    <span>
                                        {!! formatTanggal($anggota->created_at) !!}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td style="width: 30%;">
                    <div style="width: 100%;">
                        <img
                            src="{{ base_path('public/storage/'.$anggota->foto) }}"
                            alt=""
                            style="width: 150px; height: 200px; object-fit: cover; margin-left: 35px;"
                        />
                        <p class="text-center">
                            ID Anggota
                            <br/>
                            <span class="bold">
                                {{ $anggota->kode_anggota }}
                            </span>
                        </p>
                    </div>
                </td>
            </tr>
        </table>


        <table>
            <caption></caption>
            <thead><th></th></thead>
            <tr>
                <td style="width: 520px">

                </td>
                <td>
                    <p>
                        <span class="bold">Dicetak Aplikasi ScholsLibris</span> <br>
                        Pada tanggal {{ formatTanggal(Date('Y-m-d')) }}
                    </p>

                    <br>

                    ttd

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
