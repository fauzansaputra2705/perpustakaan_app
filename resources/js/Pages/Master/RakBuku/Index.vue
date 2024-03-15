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
    { data: 'nama', name: 'nama', title: 'Nama' },
    { data: 'lokasi', name: 'lokasi', title: 'Lokasi' },
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
        // { orderable: false, searchable: false, targets: 7,
        //     render: function (data, type, row, meta) {
        //         // console.log({data, type, row, meta})
        //     }
        // }
    ],
}

let dt
const tableRakBuku = ref()

const page = usePage()
const user = computed(() => page.props.auth.user)
const permission = computed(() => page.props.user.permissions)

const ajaxDatatables = () => {
    const url = {
        url: route('master.rak_buku.data'),
        dataType: 'JSON',
        data: function (d) {},
    }
    return url
}

const form = useForm({
    id: '',
    nama: '',
    lokasi: '',
})

onMounted(() => {
    dt = tableRakBuku.value.dt

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
    titleModal.value = 'Tambah Data Rak Buku'
    isEdit.value = false
    form.reset()
}

const edit = (id) => {
    form.reset()
    form.clearErrors()
    isEdit.value = true
    $.get(route('master.rak_buku.edit', { id: id }))
        .done((response) => {
            showModal.value = true
            titleModal.value = 'Edit Data Rak Buku'

            let data = response.data

            form.id = data.id
            form.nama = data.nama
            form.lokasi = data.lokasi
        })
        .fail((errors) => {
            Alert('error', errors.responseJSON.message)
        })
}

const hapus = (id) => {
    showModalDelete.value = true
    urlDelete.value = route('master.rak_buku.destroy', { id: id })
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
    })).post(route('master.rak_buku.store'), {
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
    })).put(route('master.rak_buku.update', { id: id }), {
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
    <AuthenticatedLayout head-title="Data Rak Buku">
        <CardHeaderBreadcrumb
            title="Data Rak Buku"
            :breadcrumb="[
                { nameMenu: 'Dashboard', urlMenu: user.role + '.dashboard' },
                { nameMenu: 'Data Rak Buku', urlMenu: 'master.rak_buku.index' },
            ]"
        />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">List Data Rak Buku</h4>
                        <p>Berisikan semua data rak buku yang ada.</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <button
                                v-show="permission.includes('create data rak buku')"
                                type="button"
                                class="btn btn-primary btn-rounded m-t-10 mb-2"
                                @click="create"
                            >
                                Tambah
                            </button>
                        </div>

                        <DataTable
                            ref="tableRakBuku"
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
        id-modal="modalFormRak Buku"
        :title-modal="titleModal"
        :show-modal="showModal"
        max-width="md"
        @close-modal="closeModalForm"
    >
        <div class="container-fluid">
            <FormInput
                v-model="form.nama"
                type="text"
                label="Nama Rak Buku"
                required
                :error-message="form.errors.nama"
            />
            <FormInput
                v-model="form.lokasi"
                type="text"
                label="Lokasi Rak Buku"
                :required="false"
                :error-message="form.errors.lokasi"
            />
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
        id-modal="modalDeleteRak Buku"
        :show-modal="showModalDelete"
        :url="urlDelete"
        @is-close-modal="closeModalDelete"
    />
</template>
