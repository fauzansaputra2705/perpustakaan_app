<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import CardHeaderBreadcrumb from '@/Components/CardHeaderBreadcrumb.vue'
import { Alert } from '@/constant/Alert.vue'

const props = defineProps({
    requestName: {
        type: String,
        required: false,
    },
    usersByRoles: {
        type: Array,
        required: true,
    },
    countAllUsersByRoles: {
        type: Number,
        required: true,
    },
    namePermissions: {
        type: Array,
        required: true,
    },
    permissions: {
        type: Array,
        required: true,
    },
    roleName: {
        type: String,
        required: true,
    },
    roleSelected: {
        type: Object,
        required: false,
    },
    hasPermissions: {
        type: Array,
        required: false,
    },
})

const listPermission = (group) => props.permissions.filter((p) => p.group == group)

const form = useForm({
    permissions: props.hasPermissions,
})

const submit = () => {
    form.transform((data) => ({
        ...data,
    })).post(route('superadmin.role.set_permissions', { role: props.roleName }), {
        preserveScroll: true,
        onSuccess: () => {
            Alert('success', 'Berhasil disimpan')
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
                { nameMenu: 'Hak Akses', urlMenu: 'superadmin.role.index' },
            ]"
        />
        <div class="row">
            <div class="col-3">
                <div class="card text-center" style="border: 1px solid #d0d0d0">
                    <div class="card-body" style="padding: 20px">
                        <h2 class="card-title" style="font-size: 30px; font-weight: bold; color: #2b4abe">
                            {{ props.countAllUsersByRoles }}
                        </h2>
                        <h6 class="card-subtitle mb-2 text-muted text-center">JUMLAH USER</h6>
                    </div>
                </div>
            </div>

            <div v-for="(role, i) in props.usersByRoles" :key="i" class="col-3">
                <div class="card text-center" style="border: 1px solid #d0d0d0">
                    <div class="card-body" style="padding: 20px">
                        <h2 class="card-title" style="font-size: 30px; font-weight: bold; color: #2b4abe">
                            {{ role.users_count }}
                        </h2>
                        <h6 class="card-subtitle mb-2 text-muted text-center">{{ role.name.toUpperCase() }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">Roles</h4>
                    </div>
                    <div class="card-body">
                        <ul class="pl-0" style="list-style-type: none">
                            <div v-for="(item, key) in props.usersByRoles" :key="key">
                                <div v-if="props.requestName == item.name">
                                    <Link href="" class="text-decoration-none text-white text-capitalize">
                                        <li
                                            class="border rounded mb-1 border-primary text-center py-2 font-weight-bold bg-primary"
                                        >
                                            {{ item.name }}
                                        </li>
                                    </Link>
                                </div>
                                <div v-else-if="!props.requestName && item.name == 'superadmin'">
                                    <Link
                                        :href="route('superadmin.role.index', { name: item.name })"
                                        class="text-decoration-none text-white text-capitalize"
                                    >
                                        <li
                                            class="border rounded mb-1 border-primary text-center py-2 font-weight-bold bg-primary"
                                        >
                                            {{ item.name }}
                                        </li>
                                    </Link>
                                </div>
                                <div v-else>
                                    <Link
                                        :href="route('superadmin.role.index', { name: item.name })"
                                        class="text-decoration-none text-dark text-capitalize"
                                    >
                                        <li class="border rounded mb-1 text-center py-2 font-weight-bold">
                                            {{ item.name }}
                                        </li>
                                    </Link>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-9">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">Permission</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div v-for="(d, key) in props.namePermissions" :key="key" class="col-lg-4">
                                <div class="card">
                                    <div class="border-bottom title-part-padding">
                                        <h4 class="card-title mb-0 text-capitalize">
                                            {{ d.group }}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div
                                            v-for="(item1, key1) in listPermission(d.group)"
                                            :key="key1"
                                            class="form-group mb-0 d-flex justify-content-between align-items-center"
                                        >
                                            <label :for="'customCheck' + key1" class="text-capitalize">{{
                                                item1.name.replace(d.group, '')
                                            }}</label>
                                            <div class="custom-control custom-control-inline custom-checkbox mr-0">
                                                <input
                                                    :id="'customCheck' + key1"
                                                    v-model="form.permissions"
                                                    type="checkbox"
                                                    class="custom-control-input"
                                                    :value="item1.name"
                                                    @change="submit"
                                                />
                                                <label class="custom-control-label" :for="'customCheck' + key"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
