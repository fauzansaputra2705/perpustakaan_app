<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, onMounted } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import ModalDelete from '@/Components/ModalDelete.vue'
import CardHeaderBreadcrumb from '@/Components/CardHeaderBreadcrumb.vue'
import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net-bs5'
import FormInput from '@/Components/FormInput.vue'
import Select2 from '@/Components/Select2.vue'
import { ListJenisAkun } from '@/constant/ListSelect.vue'
import { Alert } from '@/constant/Alert.vue'

const props = defineProps({
    roles: Object,
    usersByRoles: Object,
    countAllUsersByRoles: Number,
})

let dt
const tableUsers = ref()

DataTable.use(DataTablesCore)

let columnsDatatables = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
    { data: 'name', name: 'name', title: 'Nama Pengguna' },
    { data: 'email', name: 'email', title: 'Email' },
    { data: 'role', name: 'role', title: 'Role', searchable: false, orderable: false },
    { data: 'action', name: 'action', title: 'Opsi' },
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
        // { orderable: false, searchable: false, targets: 4,
        //     render: function (data, type, row, meta) {
        //         // console.log({data, type, row, meta})
        //     }
        // }
    ],
}

const filterRole = ref('')

const ajaxDatatables = () => {
    const url = {
        url: route('superadmin.manajemen_user.user.data'),
        data: function (d) {
            d.role = filterRole.value
        },
    }

    return url
}

function reloadDatatable() {
    dt.ajax.reload()
}

onMounted(() => {
    dt = tableUsers.value.dt

    $(dt.table().body()).on('click', 'a.edit', function () {
        let id = $(this).data('id')
        edit(id)
    })

    $(dt.table().body()).on('click', 'a.delete', function () {
        let id = $(this).data('id')
        hapus(id)
    })

    $(dt.table().body()).on('click', 'a.login-as', function () {
        let id = $(this).data('id')
        router.visit(route('impersonate', id), {
            method: 'get',
            onError: (er) => {
                if (er.messageFlash) {
                    Alert(er.type, er.message)
                }
            },
        })
    })
})

const form = useForm({
    id: 0,
    jenis_akun: '',
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const showModal = ref(false)
const showModalDelete = ref(false)
const urlDelete = ref('')
const titleModal = ref('')
const isEdit = ref(false)

const create = () => {
    showModal.value = true
    titleModal.value = 'Tambah Data User'
    isEdit.value = false
    form.reset()
}

const edit = (id) => {
    form.reset()
    form.clearErrors()
    isEdit.value = true
    $.get(route('superadmin.manajemen_user.user.edit', { id: id }))
        .done((response) => {
            showModal.value = true
            titleModal.value = 'Edit Data User'

            let data = response.data

            form.id = data.id
            form.jenis_akun = data.role
            form.username = data.username
            form.name = data.name
            form.email = data.email
        })
        .fail((errors) => {
            Alert('error', errors.responseJSON.message)
        })
}

const hapus = (id) => {
    showModalDelete.value = true
    urlDelete.value = route('superadmin.manajemen_user.user.destroy', { id: id })
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
    })).post(route('superadmin.manajemen_user.user.store'), {
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
        status_publish: data.status_publish == '' ? 0 : 1,
    })).put(route('superadmin.manajemen_user.user.update', { id: id }), {
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
    <AuthenticatedLayout head-title="Data Akun">
        <CardHeaderBreadcrumb
            title="Data Akun"
            :breadcrumb="[
                { nameMenu: 'Dashboard', urlMenu: 'superadmin.dashboard' },
                { nameMenu: 'Data Akun', urlMenu: 'superadmin.manajemen_user.user.index' },
            ]"
        />

        <div class="row">
            <div class="col-lg-3">
                <div
                    class="card"
                    style="border: 1px solid #d0d0d0"
                    @click="
                        () => {
                            filterRole = ''
                            reloadDatatable()
                        }
                    "
                >
                    <div class="card-body" style="padding: 20px">
                        <h2 class="card-title" style="font-size: 30px; font-weight: bold; color: #2b4abe">
                            {{ countAllUsersByRoles }}
                        </h2>
                        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">JUMLAH USER</h6>
                    </div>
                </div>
            </div>
            <div
                v-for="(item, index) in props.usersByRoles"
                :key="index"
                :class="{
                    'col-md-12': props.usersByRoles.length == index,
                    'col-md-3': props.usersByRoles.length !== index,
                }"
            >
                <div
                    class="card"
                    style="border: 1px solid #d0d0d0"
                    @click="
                        () => {
                            filterRole = item.name
                            reloadDatatable()
                        }
                    "
                >
                    <div class="card-body" style="padding: 20px">
                        <h2 class="card-title" style="font-size: 30px; font-weight: bold; color: #2b4abe">
                            {{ item.users_count }}
                        </h2>
                        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
                            JUMLAH {{ item.name.toUpperCase() }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">List Data User</h4>
                        <p>Berisikan semua data User yang ada.</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2" @click="create">
                                Tambah
                            </button>
                        </div>

                        <DataTable
                            ref="tableUsers"
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
        id-modal="modalFormPeriode"
        :title-modal="titleModal"
        :show-modal="showModal"
        max-width="md"
        @close-modal="closeModalForm"
    >
        <div class="container-fluid">
            <Select2
                id="jenis_akun"
                v-model="form.jenis_akun"
                label="Jenis Akun"
                required
                :option="ListJenisAkun"
                :error-message="form.errors.jenis_akun"
            />
            <div v-if="form.jenis_akun != 'superadmin'">
                <FormInput
                    v-model="form.username"
                    type="text"
                    label="Username"
                    required
                    :error-message="form.errors.username"
                />
                <FormInput
                    v-model="form.name"
                    type="text"
                    label="Nama Pengguna"
                    required
                    :error-message="form.errors.name"
                />
                <FormInput
                    v-model="form.email"
                    type="email"
                    label="Email"
                    required
                    :error-message="form.errors.email"
                />
                <FormInput
                    v-model="form.password"
                    type="password"
                    label="Kata Sandi"
                    required
                    :error-message="form.errors.password"
                />
                <FormInput
                    v-model="form.password_confirmation"
                    type="password"
                    label="Konfirmasi Kata Sandi"
                    required
                    :error-message="form.errors.password_confirmation"
                >
                    Kata sandi minimal 8 karakter temasuk huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan
                    karakter khusus (@,!, ?, dll)
                </FormInput>
            </div>
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
        id-modal="modalDeleteUser"
        :show-modal="showModalDelete"
        :url="urlDelete"
        @is-close-modal="closeModalDelete"
    />
</template>
