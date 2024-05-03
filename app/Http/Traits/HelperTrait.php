<?php

namespace App\Http\Traits;

use App\Models\Anggota;
use App\Models\m_pendaftaran;
use App\Models\m_pendidik;
use App\Models\m_periode;
use App\Models\ref_dokumen_pendaftaran;
use App\Models\t_pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;

trait HelperTrait
{
    /**
     * generate kartu anggota
     *
     * @param   Anggota  $anggota  [$anggota description]
     *
     * @return  [type]                   [return description]
     */
    public function generateKartuAnggota(Anggota $anggota)
    {
        $pdf = Pdf::loadView(
            'pdf.kartu_anggota_pdf',
            compact(
                'anggota'
            )
        )->setPaper('A4');
        return $pdf->stream('Kartu Anggota.pdf');
    }
}
