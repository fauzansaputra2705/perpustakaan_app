<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { Alert } from '@/constant/Alert.vue'
import { useRecaptcha } from '@/ReCaptcha'
import { ref } from 'vue'

const props = defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    showCaptcha: {
        type: Boolean,
    },
})

useRecaptcha()

const form = useForm({
    email: '',
    password: '',
    remember: false,
    'g-recaptcha-response': '',
})

const submit = (event) => {
    if (props.showCaptcha) {
        form['g-recaptcha-response'] = event.target['g-recaptcha-response'].value
    }

    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        onError: (er) => {
            if (er.messageFlash) {
                Alert(er.type, er.message)
            }
        },
    })
}

const showPassword = ref(false)
const toggleShowPassword = () => {
    showPassword.value = !showPassword.value
}
</script>

<template>
    <GuestLayout head-title="Log in">
        <h2 class="mb-3 fs-7 fw-bolder">MASUK</h2>
        <p class="mb-9">
            Menjadikan perpustakaan sekolah lebih mudah diakses dan digunakan. Dapatkan akses ke buku dan sumber belajar
            yang Anda butuhkan untuk sukses di sekolah.
        </p>

        <div v-if="props.status" class="alert alert-warning" role="alert">
            {{ props.status }}
        </div>

        <div v-if="$page.props.message_login" class="alert alert-warning" role="alert">
            {{ $page.props.message_login }}
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

            <div class="mb-4">
                <label for="exampleInputPassword1" class="form-label">Kata Sandi</label>

                <div class="input-group">
                    <input
                        v-if="showPassword"
                        v-model="form.password"
                        type="text"
                        class="form-control"
                        required
                        autocomplete="current-password"
                    />
                    <input
                        v-else
                        v-model="form.password"
                        type="password"
                        class="form-control"
                        aria-label="Text input with checkbox"
                        required
                        autocomplete="current-password"
                    />
                    <div class="input-group-text">
                        <button class="btn btn-outline-primary btn-sm" type="button" @click="toggleShowPassword">
                            <i v-if="showPassword" style="font-size: 16px" class="ti ti-eye-off"></i>
                            <i v-else style="font-size: 16px" class="ti ti-eye"></i>
                        </button>
                    </div>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div v-if="showCaptcha" class="g-recaptcha" :data-sitekey="$page.props.google_recaptcha_key"></div>

            <InputError class="mt-2" :message="form.errors['g-recaptcha-response']" />

            <Link
                v-if="props.canResetPassword"
                :href="route('password.request')"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Lupa Kata Sandi?
            </Link>

            <button
                class="btn btn-primary w-100 py-8 mb-4 rounded-2"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                <span v-if="form.processing">
                    <div class="spinner-border"></div>
                </span>
                <span v-else>Masuk</span>
            </button>

            <!-- <div class="d-flex align-items-center">
                <p class="fs-4 mb-0 fw-medium">Belum Memiliki akun?</p>
                <Link :href="route('register')" class="text-primary fw-medium ms-2"> Daftar disini </Link>
            </div> -->
        </form>
    </GuestLayout>
</template>
