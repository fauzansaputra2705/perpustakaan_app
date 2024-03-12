<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import FormInput from '@/Components/FormInput.vue'
import { Alert } from '@/constant/Alert.vue'

const props = defineProps({
})

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('register.store'), {
        onSuccess: () => {
            Alert('success', 'Berhasil ditemukan')
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
    <GuestLayout head-title="Register">
        <h2 class="mb-3 fs-7 fw-bolder">Buat Akun</h2>
        <p class="mb-9">Untuk membuat akun silahkan lengkapi data dibawah ini.</p>

        <form @submit.prevent="submit">
            <FormInput
                v-model="form.username"
                type="text"
                label="Alamat username"
                required
                :error-message="form.errors.username"
            >
            </FormInput>

            <FormInput
                v-model="form.email"
                type="email"
                label="Alamat Email"
                required
                :error-message="form.errors.email"
            >
                Pastikan email Anda adalah email aktif
            </FormInput>

            <FormInput
                v-model="form.password"
                type="password"
                label="Kata Sandi"
                required
                :error-message="form.errors.password"
            >
                Kata sandi minimal 8 karakter temasuk huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan karakter
                karakter khusus (@,!, ?, dll)
            </FormInput>

            <FormInput
                v-model="form.password_confirmation"
                type="password"
                label="Konfirmasi Kata Sandi"
                required
                :error-message="form.errors.password_confirmation"
            >
                Kata sandi minimal 8 karakter temasuk huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan karakter
                karakter khusus (@,!, ?, dll)
            </FormInput>

            <div class="flex items-center justify-end mt-4">
                Sudah memiliki akun?
                <Link :href="route('login')" class="underline text-sm focus:ring-indigo-500"> Masuk disini? </Link>

                <button
                    class="btn btn-primary w-100 py-8 mb-4 rounded-2"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    BUAT AKUN
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
