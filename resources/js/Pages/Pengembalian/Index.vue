<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, onMounted, computed } from 'vue'
import CardHeaderBreadcrumb from '@/Components/CardHeaderBreadcrumb.vue'
import ModalDelete from '@/Components/ModalDelete.vue'
import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net-bs5'
import { useForm, usePage } from '@inertiajs/vue3'
import FormInput from '@/Components/FormInput.vue'
import { Alert } from '@/constant/Alert.vue'
import { ListKondisiBuku } from '@/constant/ListSelect.vue'
import Select2 from '@/Components/Select2.vue'

DataTable.use(DataTablesCore)

let columnsDatatables = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', searchable: false, orderable: false },
    { data: 'kode_anggota', name: 'anggotas.kode_anggota', title: 'Kode Anggota' },
    { data: 'nama_anggota', name: 'anggotas.nama', title: 'Nama' },
    { data: 'nama_kelas', name: 'kelas.nama', title: 'Nama Kelas' },
    { data: 'title', name: 'bukus.title', title: 'Nama Buku' },
    { data: 'isbn', name: 'bukus.isbn', title: 'ISBN' },
    { data: 'tanggal_pinjam', name: 'tanggal_pinjam', title: 'Tanggal Pinjam' },
    { data: 'tanggal_kembali', name: 'tanggal_kembali', title: 'Tanggal Kembali' },
    { data: 'lama_telat', name: 'lama_telat', title: 'Lama Telat', searchable: false, orderable: false },
    // { data: 'action', name: 'action', title: 'Opsi', searchable: false, orderable: false },
]

const optionsDatatables = {
    responsive: true,
    scrollX: true,
    // select: true,
    processing: true,
    serverSide: true,
    language: {
        processing: `<button class="btn btn-light" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Processing...
                    </button>`,
    },
    columnDefs: [
        //custom column
        // { orderable: false, searchable: false, targets: 7,
        //     render: function (data, type, row, meta) {
        //         // console.log({data, type, row, meta})
        //     }
        // }
    ],
}

let dt
const tablePengembalian = ref()

const page = usePage()
const user = computed(() => page.props.auth.user)
const permission = computed(() => page.props.user.permissions)

const ajaxDatatables = () => {
    const url = {
        url: route('petugas.pengembalian.data'),
        dataType: 'JSON',
        data: function (d) {},
    }
    return url
}

const form = useForm({
    anggota_id: '',
    buku_id: '',
    tanggal_kembali: '',
    keterangan: '',
    kondisi_buku_kembali: '',
})

onMounted(() => {
    dt = tablePengembalian.value.dt

    $(dt.table().body()).on('click', 'a.delete', function () {
        let id = $(this).data('id')
        hapus(id)
    })
})

const showModalDelete = ref(false)
const urlDelete = ref('')

const hapus = (id) => {
    showModalDelete.value = true
    urlDelete.value = route('master.kategori.destroy', { id: id })
}
const closeModalDelete = () => {
    showModalDelete.value = false
    dt.ajax.reload()
}

const submitStore = () => {
    form.transform((data) => ({
        ...data,
        status: 'dikembalikan',
    })).post(route('petugas.pengembalian.store'), {
        onSuccess: () => {
            Alert('success', 'Berhasil ditambahkan')
            dt.ajax.reload()
            form.reset()
        },
        onError: (er) => {
            if (er.messageFlash) {
                Alert(er.type, er.message)
            }
        },
    })
}
</script>

<template>
    <AuthenticatedLayout head-title="Data Pengembalian">
        <CardHeaderBreadcrumb
            title="Data Pengembalian"
            :breadcrumb="[
                { nameMenu: 'Dashboard', urlMenu: user.role + '.dashboard' },
                { nameMenu: 'Data Pengembalian', urlMenu: 'petugas.pengembalian.index' },
            ]"
        />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">Create Data Pengembalian</h4>
                        <p>Berisikan semua data pengembalian yang ada.</p>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <Select2
                                id="anggota_id"
                                v-model="form.anggota_id"
                                label="Anggota"
                                required
                                :option="[]"
                                :url="route('select_list.anggota')"
                                :error-message="form.errors.anggota_id"
                            />

                            <Select2
                                id="buku_id"
                                v-model="form.buku_id"
                                label="Buku"
                                required
                                :option="[]"
                                :url="route('select_list.buku_peminjam', { anggotaId: form.anggota_id ?? 0 })"
                                :error-message="form.errors.buku_id"
                            />

                            <FormInput
                                v-model="form.tanggal_kembali"
                                type="date"
                                label="Tanggal Kembali"
                                required
                                :error-message="form.errors.tanggal_kembali"
                            />

                            <Select2
                                id="kondisi_buku_kembali"
                                v-model="form.kondisi_buku_kembali"
                                label="Kondisi Buku"
                                required
                                :option="ListKondisiBuku"
                                url=""
                                :error-message="form.errors.kondisi_buku_kembali"
                            />

                            <FormInput
                                v-model="form.keterangan"
                                type="textarea"
                                label="Keterangan"
                                required
                                :error-message="form.errors.keterangan"
                            />
                        </div>

                        <button
                            type="button"
                            class="btn btn-primary px-4"
                            :disabled="form.processing"
                            @click="submitStore"
                        >
                            <span v-if="form.processing">
                                <div class="spinner-border"></div>
                            </span>
                            <span v-else>Simpan Data</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">List Data Pengembalian</h4>
                        <p>Berisikan semua data pengembalian yang ada.</p>
                    </div>
                    <div class="card-body">
                        <!-- <div class="d-flex justify-content-end">
                            <button
                                v-show="permission.includes('create data kategori')"
                                type="button"
                                class="btn btn-primary btn-rounded m-t-10 mb-2"
                                @click="create"
                            >
                                Tambah
                            </button>
                        </div> -->

                        <DataTable
                            ref="tablePengembalian"
                            :columns="columnsDatatables"
                            :options="optionsDatatables"
                            :ajax="ajaxDatatables()"
                            class="table border table-striped table-bordered display nowrap"
                        >
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <ModalDelete
        id-modal="modalDeletePengembalian"
        :show-modal="showModalDelete"
        :url="urlDelete"
        @is-close-modal="closeModalDelete"
    />
</template>
