/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<script setup>
import Modal from '@/Components/Modal.vue'
import { router } from '@inertiajs/vue3'
import { Alert } from '@/constant/Alert.vue'

const props = defineProps({
    idModal: {
        type: String,
        required: true,
        default: 'modalDelete',
    },
    showModal: {
        type: Boolean,
        required: true,
        default: false,
    },
    url: {
        type: String,
        required: true,
    },
})

const emit = defineEmits(['isCloseModal'])

const ok = () => {
    router.delete(props.url, {
        preserveScroll: true,
        onSuccess: () => {
            Alert('success', 'Berhasil dihapus')
            emit('isCloseModal', true)
        },
        onError: (er) => {
            if (er.messageFlash) {
                Alert(er.type, er.message)
            }
            emit('isCloseModal', true)
        },
    })
}

const closeModalForm = () => {
    emit('isCloseModal', true)
}
</script>

<template>
    <Modal :id-modal="idModal" :show-modal="props.showModal" max-width="md">
        <div class="text-center">
            <h4 class="mt-2">Yakin ingin menghapus?</h4>
            <p class="mt-3">Pastikan bahwa data yang ingin Anda hapus adalah benar dan akan dihapus secara permanen.</p>
            <button type="button" class="btn btn-outline-primary my-2 mx-2" @click="ok">Ya, Hapus</button>
            <button type="button" class="btn btn-danger my-2 mx-2" @click="closeModalForm">Batalkan</button>
        </div>
    </Modal>
</template>
