<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import PermissionMenu from './PermissionMenu.vue'

const linkActiveMaster = ref(false)

linkActiveMaster.value = route().current('master.')
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
                :class="{ active: route().current('petugas.dashboard') }"
                :href="route('petugas.dashboard')"
                aria-expanded="false"
            >
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
            </Link>
        </li>

        <li class="sidebar-item">
            <Link
                class="sidebar-link"
                :class="{ active: route().current('petugas.peminjam.index') }"
                :href="route('petugas.peminjam.index')"
                aria-expanded="false"
            >
                <span>
                    <i class="ti ti-database"></i>
                </span>
                <span class="hide-menu">Peminjam</span>
            </Link>
        </li>

        <li class="sidebar-item">
            <Link class="sidebar-link" href="" aria-expanded="false">
                <span>
                    <i class="ti ti-database"></i>
                </span>
                <span class="hide-menu">Pengembalian</span>
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
                <!-- <li class="sidebar-item" :class="{ active: route().current('master.example.index') }"> -->
                <!-- <Link
                        :href="route('master.example.index')"
                        class="sidebar-link"
                        :class="{ active: route().current('master.example.index') }"
                    >
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-circle"></i>
                        </div>
                        <span class="hide-menu">Data Example</span>
                    </Link> -->
                <!-- </li> -->
                <li class="sidebar-item" :class="{ active: route().current('master.kategori.index') }">
                    <PermissionMenu name-menu="kategori" :is-sub-menu="true" />
                </li>
                <li class="sidebar-item" :class="{ active: route().current('master.rak_buku.index') }">
                    <PermissionMenu name-menu="rak_buku" :is-sub-menu="true" />
                </li>
                <li class="sidebar-item" :class="{ active: route().current('master.tarif_denda.index') }">
                    <PermissionMenu name-menu="tarif_denda" :is-sub-menu="true" />
                </li>
                <li class="sidebar-item" :class="{ active: route().current('master.kelas.index') }">
                    <PermissionMenu name-menu="kelas" :is-sub-menu="true" />
                </li>
                <li class="sidebar-item" :class="{ active: route().current('master.buku.index') }">
                    <PermissionMenu name-menu="buku" :is-sub-menu="true" />
                </li>
                <li class="sidebar-item" :class="{ active: route().current('master.petugas.index') }">
                    <PermissionMenu name-menu="petugas" :is-sub-menu="true" />
                </li>
            </ul>
        </li>
    </ul>
</template>
