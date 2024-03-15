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
import _ from 'lodash'
import Select2 from '@/Components/Select2.vue'

DataTable.use(DataTablesCore)

let columnsDatatables = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', searchable: false, orderable: false },
    { data: 'nama_kategori', name: 'kategoris.nama', title: 'Nama Kategori' },
    { data: 'nama_rak', name: 'rak_bukus.nama', title: 'Nama Rak' },
    { data: 'title', name: 'title', title: 'Title' },
    { data: 'slug', name: 'slug', title: 'Slug' },
    { data: 'publish_date', name: 'publish_date', title: 'Tanggal Publish' },
    { data: 'sinopsis', name: 'sinopsis', title: 'Sinopsis' },
    { data: 'publisher', name: 'publisher', title: 'Publisher' },
    { data: 'author', name: 'author', title: 'Author' },
    { data: 'language', name: 'language', title: 'Language' },
    { data: 'isbn', name: 'isbn', title: 'ISBN' },
    { data: 'tahun_terbit', name: 'tahun_terbit', title: 'Tahun Terbit' },
    { data: 'jumlah_stok', name: 'jumlah_stok', title: 'Jumlah Stok' },
    { data: 'cover', title: 'Cover' },
    {
        data: 'name_status_publish',
        name: 'name_status_publish',
        title: 'Publish(?)',
        searchable: false,
        orderable: false,
    },
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
            targets: 13,
            render: function (data, type, row, meta) {
                return `<img src="/${data}" style="max-width: 50px" />`
            },
        },
    ],
}

let dt
const tableBuku = ref()

const page = usePage()
const user = computed(() => page.props.auth.user)
const permission = computed(() => page.props.user.permissions)

const ajaxDatatables = () => {
    const url = {
        url: route('master.buku.data'),
        dataType: 'JSON',
        data: function (d) {},
    }
    return url
}

const form = useForm({
    id: '',
    kategori_id: 0,
    rak_buku_id: 0,
    title: '',
    slug: '',
    publish_date: '',
    sinopsis: '',
    publisher: '',
    author: '',
    language: '',
    isbn: '',
    jumlah_stok: '',
    tahun_terbit: '',
    cover: '',
    status_publish: '',
})

onMounted(() => {
    dt = tableBuku.value.dt

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
    titleModal.value = 'Tambah Data Buku'
    isEdit.value = false
    form.reset()
}

const edit = (id) => {
    form.reset()
    form.clearErrors()
    isEdit.value = true
    $.get(route('master.buku.edit', { id: id }))
        .done((response) => {
            showModal.value = true
            titleModal.value = 'Edit Data Buku'

            let data = response.data

            form.id = data.id
            form.kategori_id = data.kategori_id
            form.rak_buku_id = data.rak_buku_id
            form.title = data.title
            // form.slug = data.slug
            form.publish_date = data.publish_date
            form.sinopsis = data.sinopsis
            form.publisher = data.publisher
            form.author = data.author
            form.language = data.language
            form.isbn = data.isbn
            form.jumlah_stok = data.jumlah_stok
            form.tahun_terbit = data.tahun_terbit
            form.cover = data.cover
            form.status_publish = data.status_publish
        })
        .fail((errors) => {
            Alert('error', errors.responseJSON.message)
        })
}

const hapus = (id) => {
    showModalDelete.value = true
    urlDelete.value = route('master.buku.destroy', { id: id })
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
        slug: _.kebabCase(data.title),
        status_publish: data.status_publish == '' ? 0 : 1,
    })).post(route('master.buku.store'), {
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
    })).put(route('master.buku.update', { id: id }), {
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
    <AuthenticatedLayout head-title="Data Buku">
        <CardHeaderBreadcrumb
            title="Data Buku"
            :breadcrumb="[
                { nameMenu: 'Dashboard', urlMenu: user.role + '.dashboard' },
                { nameMenu: 'Data Buku', urlMenu: 'master.buku.index' },
            ]"
        />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">List Data Buku</h4>
                        <p>Berisikan semua data buku yang ada.</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <button
                                v-show="permission.includes('create data buku')"
                                type="button"
                                class="btn btn-primary btn-rounded m-t-10 mb-2"
                                @click="create"
                            >
                                Tambah
                            </button>
                        </div>

                        <DataTable
                            ref="tableBuku"
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
        id-modal="modalFormBuku"
        :title-modal="titleModal"
        :show-modal="showModal"
        max-width="md"
        @close-modal="closeModalForm"
    >
        <div class="container-fluid">
            <Select2
                id="kategori_id"
                v-model="form.kategori_id"
                label="Kategori Buku"
                required
                :option="[]"
                :url="route('select_list.kategori')"
                :error-message="form.errors.kategori_id"
            />

            <Select2
                id="rak_buku_id"
                v-model="form.rak_buku_id"
                label="Rak Buku"
                required
                :option="[]"
                :url="route('select_list.rak_buku')"
                :error-message="form.errors.rak_buku_id"
            />

            <FormInput v-model="form.title" type="text" label="Nama Buku" required :error-message="form.errors.title" />

            <FormInput v-model="form.isbn" type="text" label="ISBN" required :error-message="form.errors.isbn" />

            <FormInput
                v-model="form.publish_date"
                type="date"
                label="Tanggal Publish"
                required
                :error-message="form.errors.publish_date"
            />

            <FormInput
                v-model="form.tahun_terbit"
                type="number"
                label="Tahun Terbit"
                required
                :error-message="form.errors.tahun_terbit"
            />

            <FormInput
                v-model="form.sinopsis"
                type="textarea"
                label="Sinopsis"
                required
                :error-message="form.errors.sinopsis"
            />

            <FormInput
                v-model="form.publisher"
                type="text"
                label="Publisher Buku"
                required
                :error-message="form.errors.publisher"
            />

            <FormInput
                v-model="form.author"
                type="text"
                label="Author Buku"
                required
                :error-message="form.errors.author"
            />

            <FormInput
                v-model="form.language"
                type="text"
                label="Bahasa Buku"
                required
                :error-message="form.errors.language"
            />

            <FormInput
                v-model="form.cover"
                type="upload_file"
                label="Cover"
                required
                :error-message="form.errors.cover"
            />

            <FormInput
                v-model="form.jumlah_stok"
                type="number"
                label="Stok buku"
                required
                :error-message="form.errors.jumlah_stok"
            />

            <FormInput
                v-model="form.status_publish"
                type="switch"
                label=""
                required
                :option="[{ label: 'Publish', value: 1 }]"
                :error-message="form.errors.status_publish"
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
        id-modal="modalDeleteBuku"
        :show-modal="showModalDelete"
        :url="urlDelete"
        @is-close-modal="closeModalDelete"
    />
</template>
