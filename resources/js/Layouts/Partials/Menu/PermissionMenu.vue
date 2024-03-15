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
</template>
