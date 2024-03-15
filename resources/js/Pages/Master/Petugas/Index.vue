<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, onMounted, computed } from 'vue'
import CardHeaderBreadcrumb from '@/Components/CardHeaderBreadcrumb.vue'
import Modal from '@/Components/Modal.vue'
import ModalDelete from '@/Components/ModalDelete.vue'
import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net-bs5'
import { useForm, usePage } from '@inertiajs/vue3'
import FormInput from '@/Components/FormInput.vue'
import { Alert } from '@/constant/Alert.vue'

DataTable.use(DataTablesCore)

let columnsDatatables = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', searchable: false, orderable: false },
    { data: 'kode_petugas', name: 'kode_petugas', title: 'Kode Petugas' },
    { data: 'email', name: 'email', title: 'Email' },
    { data: 'nama', name: 'nama', title: 'Nama' },
    { data: 'jenis_kelamin', name: 'jenis_kelamin', title: 'Jenis Kelamin' },
    { data: 'telpon', name: 'telpon', title: 'Telepon' },
    { data: 'alamat', name: 'alamat', title: 'Telepon' },
    { data: 'foto', title: 'Foto', searchable: false, orderable: false },
    { data: 'action', name: 'action', title: 'Opsi', searchable: false, orderable: false },
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
        {
            orderable: false,
            searchable: false,
            targets: 7,
            render: function (data, type, row, meta) {
                return `<img src="/${data}" style="max-width: 50px" />`
            },
        },
    ],
}

let dt
const tablePetugas = ref()

const page = usePage()
const user = computed(() => page.props.auth.user)
const permission = computed(() => page.props.user.permissions)

const ajaxDatatables = () => {
    const url = {
        url: route('master.petugas.data'),
        dataType: 'JSON',
        data: function (d) {},
    }
    return url
}

const form = useForm({
    id: '',
    kode_petugas: '',
    email: '',
    nama: '',
    jenis_kelamin: '',
    telpon: '',
    alamat: '',
    foto: '',
})

onMounted(() => {
    dt = tablePetugas.value.dt

    $(dt.table().body()).on('click', 'a.edit', function () {
        let id = $(this).data('id')
        edit(id)
    })

    $(dt.table().body()).on('click', 'a.delete', function () {
        let id = $(this).data('id')
        hapus(id)
    })
})

const showModal = ref(false)
const showModalDelete = ref(false)
const urlDelete = ref('')
const titleModal = ref('')
const isEdit = ref(false)

const create = () => {
    showModal.value = true
    titleModal.value = 'Tambah Data Petugas'
    isEdit.value = false
    form.reset()
}

const edit = (id) => {
    form.reset()
    form.clearErrors()
    isEdit.value = true
    $.get(route('master.petugas.edit', { id: id }))
        .done((response) => {
            showModal.value = true
            titleModal.value = 'Edit Data Petugas'

            let data = response.data

            form.id = data.id
            form.kode_petugas = data.kode_petugas
            form.email = data.email
            form.nama = data.nama
            form.jenis_kelamin = data.jenis_kelamin
            form.telpon = data.telpon
            form.alamat = data.alamat
            // form.foto = data.foto
        })
        .fail((errors) => {
            Alert('error', errors.responseJSON.message)
        })
}

const hapus = (id) => {
    showModalDelete.value = true
    urlDelete.value = route('master.petugas.destroy', { id: id })
}
const closeModalDelete = () => {
    showModalDelete.value = false
    dt.ajax.reload()
}

const closeModalForm = () => {
    showModal.value = false
    titleModal.value = ''

    form.reset()
    form.clearErrors()
}

const submitStore = () => {
    form.transform((data) => ({
        ...data,
    })).post(route('master.petugas.store'), {
        onSuccess: () => {
            closeModalForm()
            Alert('success', 'Berhasil ditambahkan')
            dt.ajax.reload()
        },
        onError: (er) => {
            if (er.messageFlash) {
                Alert(er.type, er.message)
            }
        },
    })
}

const submitUpdate = (id) => {
    form.transform((data) => ({
        ...data,
    })).put(route('master.petugas.update', { id: id }), {
        onSuccess: () => {
            closeModalForm()
            Alert('success', 'Berhasil diupdate')
            dt.ajax.reload()
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
    <AuthenticatedLayout head-title="Data Petugas">
        <CardHeaderBreadcrumb
            title="Data Petugas"
            :breadcrumb="[
                { nameMenu: 'Dashboard', urlMenu: user.role + '.dashboard' },
                { nameMenu: 'Data Petugas', urlMenu: 'master.petugas.index' },
            ]"
        />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">List Data Petugas</h4>
                        <p>Berisikan semua data petugas yang ada.</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <button
                                v-show="permission.includes('create data petugas')"
                                type="button"
                                class="btn btn-primary btn-rounded m-t-10 mb-2"
                                @click="create"
                            >
                                Tambah
                            </button>
                        </div>

                        <DataTable
                            ref="tablePetugas"
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

    <Modal
        id-modal="modalFormPetugas"
        :title-modal="titleModal"
        :show-modal="showModal"
        max-width="md"
        @close-modal="closeModalForm"
    >
        <div class="container-fluid">
            <FormInput
                v-model="form.kode_petugas"
                type="text"
                label="Kode Petugas"
                required
                :error-message="form.errors.kode_petugas"
            />

            <FormInput
                v-model="form.email"
                type="text"
                label="Email Petugas"
                required
                :error-message="form.errors.email"
            />

            <FormInput
                v-model="form.nama"
                type="text"
                label="Nama Petugas"
                required
                :error-message="form.errors.nama"
            />

            <FormInput
                v-model="form.jenis_kelamin"
                type="radio"
                label="Jenis Kelamin"
                :option="[
                    {
                        label: 'Laki-laki',
                        value: 'laki-laki',
                    },
                    {
                        label: 'Perempuan',
                        value: 'perempuan',
                    },
                ]"
                required
                :error-message="form.errors.jenis_kelamin"
            />

            <FormInput
                v-model="form.telpon"
                type="number"
                label="Telepon"
                required
                :error-message="form.errors.telpon"
            />

            <FormInput
                v-model="form.alamat"
                type="textarea"
                label="Alamat"
                required
                :error-message="form.errors.alamat"
            />

            <FormInput v-model="form.foto" type="upload_file" label="Foto" required :error-message="form.errors.foto" />
        </div>

        <template #footer>
            <button type="button" class="btn btn-outline-primary px-4" @click="closeModalForm">Batalkan</button>

            <button
                v-if="isEdit"
                type="button"
                class="btn btn-primary px-4"
                :disabled="form.processing"
                @click="submitUpdate(form.id)"
            >
                <span v-if="form.processing">
                    <div class="spinner-border"></div>
                </span>
                <span v-else>Simpan Data</span>
            </button>
            <button v-else type="button" class="btn btn-primary px-4" :disabled="form.processing" @click="submitStore">
                <span v-if="form.processing">
                    <div class="spinner-border"></div>
                </span>
                <span v-else>Simpan Data</span>
            </button>
        </template>
    </Modal>
    <ModalDelete
        id-modal="modalDeletePetugas"
        :show-modal="showModalDelete"
        :url="urlDelete"
        @is-close-modal="closeModalDelete"
    />
</template>
