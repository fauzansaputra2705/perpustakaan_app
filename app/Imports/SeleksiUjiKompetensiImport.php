<?php

namespace App\Imports;

use App\Http\Constant\StatusPengajuan;
use App\Models\t_pengajuan;
use App\Repositories\Pengajuan\LogPengajuan\LogPengajuanRepositoryInterface;
use App\Repositories\Pengajuan\PengajuanRepositoryInterface;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SeleksiUjiKompetensiImport implements ToCollection, SkipsEmptyRows, WithHeadingRow
{
    use Importable;

    /**
     *
     * @var array<array<mixed>>
     */
    protected $dataError = [];

    /**
     *
     * @var String
     */
    public $error = '';

    /**
     *
     * @var int
     */
    protected $pendaftaranId;

    /**
     *
     * @var int
     */
    protected $jmlSuccess;

    /**
     *
     * @var int
     */
    protected $jmlError;

    /**
     *
     * @var PengajuanRepositoryInterface
     */
    protected $pengajuan;

    /**
     *
     * @var LogPengajuanRepositoryInterface
     */
    protected $logPengajuan;

    public function __construct(
        int $pendaftaranId,
        PengajuanRepositoryInterface $pengajuan,
        LogPengajuanRepositoryInterface $logPengajuan
    ) {
        $this->pengajuan = $pengajuan;
        $this->logPengajuan = $logPengajuan;
        $this->pendaftaranId = $pendaftaranId;
    }

    /**
     * @param Collection<int,array> $rows
     */
    // @phpstan-ignore-next-line
    public function collection(Collection $rows)
    {
        $jmlSuccess = 0;
        $jmlError = 0;

        $this->error = '';


        foreach ($rows as $row) {
            if ($this->cekHeader($row)) {
                break;
            }

            // @phpstan-ignore-next-line
            $validator = Validator::make($row->toArray(), [
                'no_registrasi' => [
                    'required',
                    'exists:t_pengajuan,no_registrasi',
                    function (string $attribute, mixed $value, Closure $fail) {
                        /**
                         * @var ?t_pengajuan $cek
                         */
                        $cek = DB::table('t_pengajuan')->where('pendaftaran_id', $this->pendaftaranId)
                            ->where('no_registrasi', '=', $value)
                            ->whereIn('status_pengajuan', StatusPengajuan::statusPengajuanAdministrasi())
                            ->where('status_pengajuan', '!=', StatusPengajuan::LOLOS_ADMINISTRASI)
                            ->first();
                        if (isset($cek)) {
                            $fail(
                                ucwords($attribute) .
                                    ' Status Pengajuan belum Lolos Administrasi, pengajuan masih di tahap '
                                    . StatusPengajuan::statusPengajuan($cek->status_pengajuan)
                            );
                        }
                    },
                    function (string $attribute, mixed $value, Closure $fail) {
                        /**
                         * @var ?t_pengajuan $cek
                         */
                        $cek = DB::table('t_pengajuan')->where('pendaftaran_id', $this->pendaftaranId)
                            ->where('no_registrasi', '=', $value)
                            ->whereIn('status_pengajuan', StatusPengajuan::statusPengajuanUjiKompetensi())
                            ->first();
                        if (isset($cek)) {
                            $fail(
                                ucwords($attribute) . ' Sudah dimasukkan, pengajuan di tahap ' .
                                    StatusPengajuan::statusPengajuan($cek->status_pengajuan)
                            );
                        }
                    },
                ],
                'nama_lengkap' => [
                    'required',
                    'string',
                ],
                'status' => ['required', Rule::in(['Tidak Lulus', 'Lulus'])],
            ], [
                'no_registrasi.exists' => 'Nomor registrasi tidak cocok',
                'status.in' => 'Status harus berupa Lulus/Tidak Lulus'
            ]);

            if ($validator->fails()) {
                $this->dataError[] = [
                    'no_registrasi' => $row['no_registrasi'],
                    'nama_lengkap' => $row['nama_lengkap'],
                    'status' => $row['status'],
                    'alasan' => implode(",", $validator->messages()->all()),
                ];
                $jmlError++;
                continue;
            }

            try {
                $statusPengajuan =
                    $row['status'] == 'Lulus' ?
                    StatusPengajuan::LULUS_SELEKSI_PENGAWAS
                    :
                    StatusPengajuan::TIDAK_LULUS_SELEKSI_PENGAWAS;
                $data = [
                    'status_pengajuan' => $statusPengajuan,
                ];

                /** @var t_pengajuan $pengajuan */
                $pengajuan = $this->pengajuan->queryWhere([
                    ['t_pengajuan.pendaftaran_id', '=', $this->pendaftaranId],
                    ['t_pengajuan.no_registrasi', '=', "'" . $row['no_registrasi'] . "'"],
                ], [])->first();

                $pengajuan->update($data);

                $this->logPengajuan->create([
                    'pengajuan_id' => $pengajuan->id,
                    // 'verifikator_id' => ,
                    'status_pengajuan' => $statusPengajuan,
                    // 'catatan' => ,
                ]);
                $jmlSuccess++;
            } catch (\Throwable $th) {
                $this->dataError[] = [
                    'no_registrasi' => $row['no_registrasi'],
                    'nama_lengkap' => $row['nama_lengkap'],
                    'status' => $row['status'],
                    'alasan' => $th->getMessage(),
                ];
                $jmlError++;
            }
        }

        $this->jmlSuccess = $jmlSuccess;
        $this->jmlError = $jmlError;
    }

    /**
     * @param array<mixed,mixed> $row
     *
     * @return boolean
     */
    private function cekHeader($row)
    {
        $e = false;
        $cekTemplateHeader = (isset($row['no_registrasi']) &&
            isset($row['nama_lengkap']) &&
            isset($row['status']));

        if (!$cekTemplateHeader) {
            $this->error = 'Template yang diImport tidak sesuai';
            $e = true;
        }
        return $e;
    }

    /**
     *
     * @return array<array<mixed>>
     */
    public function showError(): array
    {
        return $this->dataError;
    }

    /**
     *
     * @return string
     */
    public function showMessageError()
    {
        return "Data yg Berhasil $this->jmlSuccess, Data yg Gagal $this->jmlError";
    }
}
