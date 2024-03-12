<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
import FormInput from '@/Components/FormInput.vue'

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <GuestLayout head-title="Reset Password">
        <form @submit.prevent="submit">
            <div>
                <label for="email" class="form-label">Alamat Email</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <FormInput
                    v-model="form.password"
                    type="password"
                    label="Kata Sandi"
                    required
                    :error-message="form.errors.password"
                >
                    Kata sandi minimal 8 karakter temasuk huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan
                    karakter karakter khusus (@,!, ?, dll)
                </FormInput>
            </div>

            <div class="mt-4">
                <FormInput
                    v-model="form.password_confirmation"
                    type="password"
                    label="Konfirmasi Kata Sandi"
                    required
                    :error-message="form.errors.password_confirmation"
                >
                    Kata sandi minimal 8 karakter temasuk huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan
                    karakter karakter khusus (@,!, ?, dll)
                </FormInput>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button
                    class="btn btn-primary w-100 py-8 mb-4 rounded-2"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Kirim
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
