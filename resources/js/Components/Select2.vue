/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<template>
    <div class="mb-3 form-group">
        <label v-show="label">
            {{ label }}
        </label>
        <select
            :id="id"
            ref="selectElement"
            class="form-select2"
            :class="{ 'is-invalid': errorMessage }"
            v-bind="$attrs"
        ></select>
        <slot />
        <div v-show="errorMessage" class="invalid-feedback">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { Alert } from '@/constant/Alert.vue'

export default {
    props: {
        modelValue: [String, Array, Number],
        label: {
            type: String,
            // required: true
        },
        id: {
            type: String,
            required: true,
            default: '',
        },
        url: {
            type: String,
            //   required: true,
            default: '',
        },
        option: {
            type: Array,
            default: () => [],
        },
        settings: {
            type: Object,
            default: () => ({}),
        },
        errorMessage: {
            type: String,
        },
    },
    emits: ['update:modelValue', 'select'],
    setup(props, { emit }) {
        const selectElement = ref(null)

        router.on('finish', (event) => {
            let idModal = cekIdModal()
            if (props.option.length > 0) {
                setOption(props.option, idModal)
            } else {
                setOptionUrl(props.url, props.modelValue, idModal)
            }
        })

        const setOption = (val = [], idModal = '') => {
            if (!selectElement.value) return

            selectElement.value.innerHTML = '' // Clear the select option

            let list = []
            $.each(val, function (k, v) {
                list.push({ id: v.value, text: v.label })
            })

            let addSetings = {}
            if (idModal !== '') {
                addSetings['dropdownParent'] = $(`#${idModal}`)
            }

            $(selectElement.value).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: props.placeholder,
                ...props.settings,
                ...addSetings,
                data: list,
            })
            setValue(props.modelValue)
        }

        const setOptionUrl = (url, value = '', idModal = '') => {
            if (!selectElement.value) return

            selectElement.value.innerHTML = '' // Clear the select option
            if (url !== '' || url !== 0) {
                $.get(url)
                    .done((response) => {
                        let data = response.data

                        let list = []
                        list.push({ id: '', text: `Pilih ${props.label}` })
                        $.each(data, function (k, v) {
                            list.push({ id: k, text: v })
                        })

                        let addSetings = {}
                        if (idModal !== '') {
                            addSetings['dropdownParent'] = $(`#${idModal}`)
                        }

                        $(selectElement.value).select2({
                            theme: 'bootstrap-5',
                            width: '100%',
                            placeholder: props.placeholder,
                            ...props.settings,
                            ...addSetings,
                            data: list,
                        })

                        setValue(value)
                    })
                    .fail((errors) => {
                        Alert('error', errors.responseJSON.message)

                        let list = []
                        list.push({ id: '', text: `Pilih ${props.label}` })

                        let addSetings = {}
                        if (idModal !== '') {
                            addSetings['dropdownParent'] = $(`#${idModal}`)
                        }

                        $(selectElement.value).select2({
                            theme: 'bootstrap-5',
                            width: '100%',
                            placeholder: props.placeholder,
                            ...props.settings,
                            ...addSetings,
                            data: list,
                        })
                        setValue(value)
                    })
            } else {
                let list = []
                list.push({ id: '', text: `Pilih ${props.label}` })

                let addSetings = {}
                if (idModal !== '') {
                    addSetings['dropdownParent'] = $(`#${idModal}`)
                }

                $(selectElement.value).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: props.placeholder,
                    ...props.settings,
                    ...addSetings,
                    data: list,
                })
                setValue(value)
            }
        }

        const setValue = (val) => {
            if (!selectElement.value) return

            if (Array.isArray(val)) {
                $(selectElement.value).val([...val])
            } else if (val == '') {
                $(selectElement.value).val('')
                emit('update:modelValue', $(selectElement.value).val())
                emit('select', $(selectElement.value).val())
            } else {
                $(selectElement.value).val([val])
            }
            $(selectElement.value).trigger('change')
        }

        const cekIdModal = () => {
            let modal = $('.form-select2').parent().parent().parent().parent().parent().parent()
            let idModal = modal[0] ? modal[0].id : ''
            return idModal
        }

        onMounted(() => {
            if (props.option.length > 0) {
                setOption(props.option)
            } else {
                setOptionUrl(props.url, props.modelValue)
            }

            $(selectElement.value).on('select2:select select2:unselect', (ev) => {
                emit('update:modelValue', $(selectElement.value).val())
                emit('select', ev.params.data)
            })

            setValue(props.modelValue)
        })

        onBeforeUnmount(() => {})

        watch(
            () => props.option,
            (val) => {
                if (val.length > 0) {
                    let idModal = cekIdModal()
                    setOption(val, idModal)
                }
            },
            { deep: true },
        )

        watch(
            () => props.url,
            (newValue, oldValue) => {
                let idModal = cekIdModal()
                if ((oldValue != '' && newValue != oldValue) || newValue == '') {
                    setOptionUrl(newValue, '', idModal)
                } else {
                    setOptionUrl(newValue, props.modelValue, idModal)
                }
            },
            { deep: true },
        )

        watch(
            () => props.modelValue,
            (val) => {
                setValue(val)
            },
            { deep: true },
        )

        return {
            selectElement,
        }
    },
}
</script>

<style>
label:has(+ select[required])::after {
    content: ' *';
    color: #fa896b;
    font-weight: 600;
}

label {
    font-weight: 600;
}

.select2-container--bootstrap-5 .select2-selection--single {
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #5a6a85;
    background-color: transparent;
    background-clip: padding-box;
    border: var(--bs-border-width) solid #dfe5ef;
    appearance: none;
    border-radius: 7px;
    box-shadow: unset;
    transition:
        border-color 0.15s ease-in-out,
        box-shadow 0.15s ease-in-out;
}
</style>
