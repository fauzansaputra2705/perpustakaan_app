/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<script setup>
import { watch, computed, onMounted } from 'vue'

const props = defineProps({
    idModal: {
        type: String,
        required: true,
        default: 'myModal',
    },
    titleModal: {
        type: String,
        required: false,
        default: '',
    },
    titleModalDeskripsi: {
        type: String,
        required: false,
        default: '',
    },
    showModal: {
        type: Boolean,
        required: true,
        default: false,
    },
    maxWidth: {
        type: String,
        required: false,
        default: 'xl',
    },
    // backdrop: {
    //     type: Boolean,
    //     required: false,
    //     default: false,
    // },
})

const emit = defineEmits(['closeModal'])

onMounted(() => {})

const open = () => {
    let myModal = new bootstrap.Modal(document.getElementById(props.idModal), {})
    myModal.show()
    //select2
    $('.form-select2').select2({
        theme: 'bootstrap-5',
        dropdownParent: $(`#${props.idModal}`),
        width: '100%',
    })
}

const close = () => {
    let myModal = bootstrap.Modal.getInstance(document.getElementById(props.idModal), {})
    myModal.hide()
    emit('closeModal')
    //select2
    $('.form-select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
    })
}

watch(
    () => props.showModal,
    () => {
        if (props.showModal) {
            open()
            console.log('modal open')
        } else {
            close()
            console.log('modal close')
        }
    },
)

const maxWidthClass = computed(() => {
    return {
        sm: 'modal-sm',
        md: 'modal-md',
        lg: 'modal-lg',
        xl: 'modal-xl',
    }[props.maxWidth]
})
</script>

<template>
    <div
        :id="props.idModal"
        class="modal fade in"
        role="dialog"
        data-bs-backdrop="static"
        :aria-labelledby="props.idModal + 'Label'"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" :class="maxWidthClass">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 v-show="props.titleModal != ''" :id="props.idModal + 'Label'" class="modal-title">
                        {{ props.titleModal }}
                        <div class="text-muted" style="font-size: 13px">{{ props.titleModalDeskripsi }}</div>
                    </h4>
                    <button
                        v-show="props.titleModal != ''"
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                        @click="close"
                    ></button>
                    <slot name="header"></slot>
                </div>
                <div class="modal-body">
                    <slot />
                </div>
                <div class="modal-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>
