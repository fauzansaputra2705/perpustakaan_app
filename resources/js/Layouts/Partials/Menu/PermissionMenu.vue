<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    nameMenu: {
        type: String,
        required: true,
    },
    isSubMenu: {
        type: Boolean,
        required: false,
    },
})

const page = usePage()
const permission = computed(() => page.props.user.permissions)
</script>

<template>
    <div v-if="props.nameMenu == 'kategori'">
        <Link
            v-show="permission.includes('view data kategori')"
            :href="route('master.kategori.index')"
            class="sidebar-link"
            :class="{ active: route().current('master.kategori.index') }"
            aria-expanded="false"
        >
            <div v-if="props.isSubMenu" class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
            </div>
            <span v-else>
                <i class="ti ti-database"></i>
            </span>
            <span class="hide-menu">Kategori</span>
        </Link>
    </div>
    <div v-if="props.nameMenu == 'rak_buku'">
        <Link
            v-show="permission.includes('view data rak buku')"
            :href="route('master.rak_buku.index')"
            class="sidebar-link"
            :class="{ active: route().current('master.rak_buku.index') }"
            aria-expanded="false"
        >
            <div v-if="props.isSubMenu" class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
            </div>
            <span v-else>
                <i class="ti ti-database"></i>
            </span>
            <span class="hide-menu">Rak Buku</span>
        </Link>
    </div>
    <div v-if="props.nameMenu == 'tarif_denda'">
        <Link
            v-show="permission.includes('view data tarif denda')"
            :href="route('master.tarif_denda.index')"
            class="sidebar-link"
            :class="{ active: route().current('master.tarif_denda.index') }"
            aria-expanded="false"
        >
            <div v-if="props.isSubMenu" class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
            </div>
            <span v-else>
                <i class="ti ti-database"></i>
            </span>
            <span class="hide-menu">Tarif Denda</span>
        </Link>
    </div>
    <div v-if="props.nameMenu == 'kelas'">
        <Link
            v-show="permission.includes('view data kelas')"
            :href="route('master.kelas.index')"
            class="sidebar-link"
            :class="{ active: route().current('master.kelas.index') }"
            aria-expanded="false"
        >
            <div v-if="props.isSubMenu" class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
            </div>
            <span v-else>
                <i class="ti ti-database"></i>
            </span>
            <span class="hide-menu">Kelas</span>
        </Link>
    </div>
    <div v-if="props.nameMenu == 'buku'">
        <Link
            v-show="permission.includes('view data buku')"
            :href="route('master.buku.index')"
            class="sidebar-link"
            :class="{ active: route().current('master.buku.index') }"
            aria-expanded="false"
        >
            <div v-if="props.isSubMenu" class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
            </div>
            <span v-else>
                <i class="ti ti-database"></i>
            </span>
            <span class="hide-menu">Buku</span>
        </Link>
    </div>
</template>
