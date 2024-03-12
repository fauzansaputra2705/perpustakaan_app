/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<script setup>
import { ref, toRef } from 'vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const props = defineProps({
    label: {
        type: String,
        // required: true
    },
    type: {
        type: String,
        required: true,
    },
    option: {
        type: Object,
    },
    modelValue: {
        type: [String, Number, Boolean, Array, File],
        required: false,
    },
    linkPath: {
        type: String,
        required: false,
    },
    errorMessage: {
        type: String,
    },
})
const emit = defineEmits(['update:modelValue'])

const input = ref(null)

const multipleValues = toRef(props.modelValue)
const singleValue = (event) => {
    let val = event.target.value
    if (event.target.checked) {
        emit('update:modelValue', val)
    } else {
        emit('update:modelValue', '')
    }
}
const multipleValue = (event) => {
    let val = event.target.value
    //checked
    if (event.target.checked) {
        if (multipleValues.value.includes(val)) {
            //delete
            multipleValues.value = multipleValues.value.filter((item) => item !== val)
        } else {
            //push
            multipleValues.value.push(val)
        }
    } else {
        if (multipleValues.value.includes(val)) {
            //delete
            multipleValues.value = multipleValues.value.filter((item) => item !== val)
        }
    }
    emit('update:modelValue', multipleValues.value)
}

const showPassword = ref(false)
const toggleShowPassword = () => {
    showPassword.value = !showPassword.value
}
</script>

<template>
    <div
        v-if="['text', 'date', 'email', 'number', 'time', 'search', 'month'].includes(props.type)"
        class="mb-3 form-group"
    >
        <label v-show="props.label">
            {{ props.label }}
        </label>
        <input
            v-bind="$attrs"
            ref="input"
            class="form-control"
            :class="{ 'is-invalid': props.errorMessage }"
            :value="modelValue"
            :type="props.type"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <slot />
        <div v-show="props.errorMessage" class="invalid-feedback">
            {{ props.errorMessage }}
        </div>
    </div>
    <div v-else-if="props.type == 'password'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>

            <div class="input-group">
                <input
                    v-bind="$attrs"
                    ref="input"
                    class="form-control"
                    :class="{ 'is-invalid': props.errorMessage }"
                    :value="modelValue"
                    :type="showPassword ? 'text' : 'password'"
                    @input="$emit('update:modelValue', $event.target.value)"
                />
                <div class="input-group-text">
                    <button class="btn btn-outline-primary btn-sm" type="button" @click="toggleShowPassword">
                        <i v-if="showPassword" style="font-size: 16px" class="ti ti-eye-off"></i>
                        <i v-else style="font-size: 16px" class="ti ti-eye"></i>
                    </button>
                </div>
            </div>
            <div v-show="props.errorMessage" class="text-danger">
                {{ props.errorMessage }}
            </div>
            <slot />
        </div>
    </div>
    <div v-else-if="props.type == 'textarea'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>
            <textarea
                v-bind="$attrs"
                ref="input"
                class="form-control"
                :class="{ 'is-invalid': props.errorMessage }"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            >
            </textarea>
            <slot />
            <div v-show="props.errorMessage" class="invalid-feedback">
                {{ props.errorMessage }}
            </div>
        </div>
    </div>
    <div v-else-if="props.type == 'editor'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>
            <QuillEditor
                ref="input"
                v-bind="$attrs['required']"
                theme="snow"
                toolbar="full"
                :read-only="$attrs['readonly']"
                content-type="html"
                :content="modelValue"
                @update:content="(content) => $emit('update:modelValue', content)"
            />
            <slot />
            <div v-show="props.errorMessage" class="invalid-feedback">
                {{ props.errorMessage }}
            </div>
        </div>
    </div>
    <div v-else-if="props.type == 'select'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>
            <select
                v-bind="$attrs"
                ref="input"
                class="form-control"
                :class="{ 'is-invalid': props.errorMessage }"
                @change="$emit('update:modelValue', $event.target.value)"
            >
                <option
                    v-for="(value, key) in props.option"
                    :key="key"
                    :value="value.value"
                    :selected="value.value === modelValue"
                >
                    {{ value.label }}
                </option>
            </select>
            <slot />
            <div v-show="props.errorMessage" class="invalid-feedback">
                {{ props.errorMessage }}
            </div>
        </div>
    </div>
    <div v-else-if="props.type == 'radio'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>
            <div class="controls">
                <fieldset v-for="(value, key) in props.option" :key="key">
                    <legend></legend>
                    <div class="form-check">
                        <input
                            :id="'radio' + key"
                            type="radio"
                            :value="value.value"
                            class="form-check-input secondary"
                            :class="{ 'is-invalid': props.errorMessage }"
                            :checked="value.value === modelValue"
                            v-bind="$attrs"
                            @change="$emit('update:modelValue', $event.target.value)"
                        />
                        <label class="form-check-label">{{ value.label }}</label>
                        <div v-show="props.errorMessage" class="invalid-feedback">
                            {{ props.errorMessage }}
                        </div>
                    </div>
                </fieldset>
                <div class="help-block">
                    <slot />
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="props.type == 'checkbox'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>
            <div class="controls">
                <fieldset v-for="(value, key) in props.option" :key="key">
                    <legend></legend>
                    <div class="form-check">
                        <input
                            :id="'checkbox' + key"
                            type="checkbox"
                            :value="value.value"
                            class="form-check-input secondary"
                            :class="{ 'is-invalid': props.errorMessage }"
                            :checked="
                                props.option.length == 1 ? modelValue == value.value : modelValue.includes(value.value)
                            "
                            v-bind="$attrs"
                            @input="
                                (event) => {
                                    props.option.length == 1 ? singleValue(event) : multipleValue(event)
                                }
                            "
                        />
                        <label class="form-check-label">{{ value.label }}</label>
                        <div v-show="props.errorMessage" class="invalid-feedback">
                            {{ props.errorMessage }}
                        </div>
                    </div>
                </fieldset>
                <div class="help-block">
                    <slot />
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="props.type == 'switch'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>
            <div class="controls">
                <div v-for="(value, key) in props.option" :key="key" class="form-check form-switch">
                    <input
                        :id="'switch_check' + key"
                        class="form-check-input"
                        type="checkbox"
                        :value="value.value"
                        :class="{ 'is-invalid': props.errorMessage }"
                        :checked="
                            props.option.length == 1 ? modelValue == value.value : modelValue.includes(value.value)
                        "
                        v-bind="$attrs"
                        @input="
                            (event) => {
                                props.option.length == 1 ? singleValue(event) : multipleValue(event)
                            }
                        "
                    />
                    <label class="form-check-label">{{ value.label }}</label>
                    <div v-show="props.errorMessage" class="invalid-feedback">
                        {{ props.errorMessage }}
                    </div>
                </div>
                <div class="help-block">
                    <slot />
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="props.type == 'upload_file'">
        <div class="mb-3 form-group">
            <label v-show="props.label">
                {{ props.label }}
            </label>
            <div class="input-group flex-nowrap">
                <div class="custom-file">
                    <input
                        v-bind="$attrs"
                        ref="input"
                        class="form-control"
                        :class="{ 'is-invalid': props.errorMessage }"
                        type="file"
                        @input="$emit('update:modelValue', $event.target.files[0])"
                    />
                    <div v-show="props.errorMessage" class="invalid-feedback">
                        {{ props.errorMessage }}
                    </div>
                </div>
                <a
                    v-if="props.linkPath"
                    :href="props.linkPath"
                    target="_blank"
                    class="btn btn-light-info text-info font-medium"
                >
                    Lihat
                </a>
            </div>
            <slot />
        </div>
    </div>
</template>

<style>
label:has(+ input[required])::after {
    content: ' *';
    color: #fa896b;
    font-weight: 600;
}
label:has(+ select[required])::after {
    content: ' *';
    color: #fa896b;
    font-weight: 600;
}
label:has(+ textarea[required])::after {
    content: ' *';
    color: #fa896b;
    font-weight: 600;
}

label:has(+ .v-select.vs--single.vs--searchable)::after {
    content: ' *';
    color: #fa896b;
    font-weight: 600;
}

label:has(+ .input-group)::after {
    content: ' *';
    color: #fa896b;
    font-weight: 600;
}

label:has(+ div)::after {
    content: ' *';
    color: #fa896b;
    font-weight: 600;
}

label {
    font-weight: 600;
}
</style>
