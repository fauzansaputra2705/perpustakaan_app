<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import SuperadminMenu from '@/Layouts/Partials/Menu/SuperadminMenu.vue'

import { onMounted, computed } from 'vue'

onMounted(() => {
    $('.light-logo').css('display', 'none')
})

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>

<template>
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <Link :href="route('dashboard')" class="text-nowrap logo-img">
                    <img src="/image/logo.svg" class="dark-logo" width="180" alt="" />
                    <img src="/image/logo.svg" class="light-logo" width="180" alt="" />
                </Link>
                <div id="sidebarCollapse" class="close-btn d-lg-none d-block sidebartoggler cursor-pointer">
                    <i class="ti ti-x fs-8 text-muted"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                <span v-show="user.role == 'superadmin'">
                    <SuperadminMenu />
                </span>
            </nav>

            <!-- End Sidebar navigation -->
            <!-- End Sidebar scroll-->
        </div>
    </aside>
    <!--  Sidebar End -->
</template>
