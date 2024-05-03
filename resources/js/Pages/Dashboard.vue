<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>

<template>
    <AuthenticatedLayout head-title="Dashboard">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center gap-4 mb-4">
                    <div class="position-relative">
                        <div class="border-2 border-primary rounded-circle">
                            <img
                                :src="$page.props.auth.user.full_url_path_image"
                                class="rounded-circle m-1"
                                alt="user1"
                                width="70"
                                height="70"
                                style="object-fit: cover"
                            />
                        </div>
                    </div>
                    <div>
                        <h3 class="fw-semibold">
                            Hi, <span class="text-dark">{{ $page.props.auth.user.name }}</span>
                        </h3>
                        <span>{{ $page.props.auth.user.role }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h2>Peminjaman Buku</h2>
            <div class="col-lg-3 p-3">
                <div class="card border-0 zoom-in bg-light-primary shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/icon/user.svg" width="80" height="80" class="mb-3" alt="" />
                            <p class="fw-semibold fs-3 mb-1">Anggota</p>
                            <h5 class="fw-semibold text-primary fs-10">0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-3">
                <div class="card border-0 zoom-in bg-light-primary shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/icon/approval.svg" width="80" height="80" class="mb-3" alt="" />
                            <p class="fw-semibold fs-3 mb-1">Total Buku</p>
                            <h5 class="fw-semibold text-primary fs-10">0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-3">
                <div class="card border-0 zoom-in bg-light-primary shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/icon/approval.svg" width="80" height="80" class="mb-3" alt="" />
                            <p class="fw-semibold fs-3 mb-1">Buku Dipinjam</p>
                            <h5 class="fw-semibold text-primary fs-10">0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-3">
                <div class="card border-0 zoom-in bg-light-primary shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/icon/approval.svg" width="80" height="80" class="mb-3" alt="" />
                            <p class="fw-semibold fs-3 mb-1">Buku Dikembalikan</p>
                            <h5 class="fw-semibold text-primary fs-10">0</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display: none">
            <div class="col-lg-8">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Pengajuan Pengawas</h5>
                                <p class="card-subtitle mb-0">Data pengajuan pengawas berdasarkan bulan</p>
                            </div>
                            <div>
                                <FormInput type="month" label="" required error-message="" />
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-8">
                                <!-- <VueApexCharts
                                    width="500"
                                    type="bar"
                                    :options="chartDashboard().option"
                                    :series="chartDashboard().series"
                                ></VueApexCharts> -->
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="d-flex align-items-center mb-4 pb-1">
                                    <div
                                        class="p-8 bg-light-primary rounded-1 me-3 d-flex align-items-center justify-content-center"
                                    >
                                        <i class="ti ti-grid-dots text-primary fs-6"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0 fs-7 fw-semibold">0</h4>
                                        <p class="fs-3 mb-0">Total Pengajuan</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-baseline mb-4">
                                        <span class="round-8 bg-success rounded-circle me-6"></span>
                                        <div>
                                            <p class="fs-3 mb-1">Lolos Administrasi</p>
                                            <h6 class="fs-5 fw-semibold mb-0">0</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-baseline mb-4 pb-1">
                                        <span class="round-8 bg-danger rounded-circle me-6"></span>
                                        <div>
                                            <p class="fs-3 mb-1">Tidak Lolos Administrasi</p>
                                            <h6 class="fs-5 fw-semibold mb-0">0</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </AuthenticatedLayout>
</template>
