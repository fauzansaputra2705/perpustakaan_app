<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import PermissionMenu from './PermissionMenu.vue'

const linkActiveMaster = ref(false)
const linkActiveManajemenAkun = ref(false)
const linkActiveManajemenPengawas = ref(false)

linkActiveMaster.value = route().current('master.example.index')

linkActiveManajemenAkun.value =
    route().current('superadmin.manajemen_user.user.index') || route().current('superadmin.role.index')
</script>

<template>
    <!-- ============================= -->
    <!-- Main Menu -->
    <!-- ============================= -->
    <ul id="sidebarnav">
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Main Menu</span>
        </li>

        <li class="sidebar-item">
            <Link
                class="sidebar-link"
                :class="{ active: route().current('superadmin.dashboard') }"
                :href="route('superadmin.dashboard')"
                aria-expanded="false"
            >
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
            </Link>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" :class="{ active: linkActiveMaster }" href="#" aria-expanded="false">
                <span class="d-flex">
                    <i class="ti ti-database"></i>
                </span>
                <span class="hide-menu">Data Master</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level" :class="{ in: linkActiveMaster }">
                <li class="sidebar-item" :class="{ active: route().current('master.example.index') }">
                    <Link
                        :href="route('master.example.index')"
                        class="sidebar-link"
                        :class="{ active: route().current('master.example.index') }"
                    >
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-circle"></i>
                        </div>
                        <span class="hide-menu">Data Example</span>
                    </Link>
                    <PermissionMenu name-menu="kategori" :is-sub-menu="true" />
                    <PermissionMenu name-menu="rak_buku" :is-sub-menu="true" />
                    <PermissionMenu name-menu="tarif_denda" :is-sub-menu="true" />
                    <PermissionMenu name-menu="kelas" :is-sub-menu="true" />
                    <PermissionMenu name-menu="buku" :is-sub-menu="true" />
                    <PermissionMenu name-menu="petugas" :is-sub-menu="true" />
                </li>
            </ul>
        </li>

        <li class="sidebar-item">
            <a
                class="sidebar-link has-arrow"
                :class="{ active: linkActiveManajemenAkun }"
                href="#"
                aria-expanded="false"
            >
                <span class="d-flex">
                    <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Manajemen Akun</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level" :class="{ in: linkActiveManajemenAkun }">
                <li class="sidebar-item" :class="{ active: route().current('master.example.index') }">
                    <Link
                        :href="route('superadmin.manajemen_user.user.index')"
                        class="sidebar-link"
                        :class="{ active: route().current('superadmin.manajemen_user.user.index') }"
                    >
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-circle"></i>
                        </div>
                        <span class="hide-menu">Data Akun</span>
                    </Link>
                </li>
                <li class="sidebar-item">
                    <Link
                        :href="route('superadmin.role.index')"
                        class="sidebar-link"
                        :class="{ active: route().current('superadmin.role.index') }"
                    >
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-circle"></i>
                        </div>
                        <span class="hide-menu">Hak Akses</span>
                    </Link>
                </li>
            </ul>
        </li>
    </ul>
</template>
