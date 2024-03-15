<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'

defineProps({
    status: {
        type: String,
    },
})

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('password.email'))
}
</script>

<template>
    <GuestLayout head-title="Forgot Password">
        <h2 class="mb-3 fs-7 fw-bolder">Lupa Kata Sandi</h2>
        <p class="mb-9">
            Lupa kata sandi? Harap masukan alamat email Anda yang terdaftar di Perpus. Anda akan menerima tautan melalui
            email untuk membuat kata sandi baru.
        </p>

        <div v-if="status" class="alert alert-success" role="alert">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Alamat Email</label>

                <input
                    id="exampleInputEmail1"
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    aria-describedby="emailHelp"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.email" />
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
