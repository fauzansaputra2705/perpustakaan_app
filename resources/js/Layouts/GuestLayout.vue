<script setup>
import { Head as IHead } from '@inertiajs/vue3'

const props = defineProps({
    headTitle: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <IHead :title="props.headTitle"></IHead>
    <div
        id="main-wrapper"
        class="page-wrapper"
        data-layout="vertical"
        data-sidebartype="full"
        data-sidebar-position="fixed"
        data-header-position="fixed"
    >
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row" style="min-height: 100vh">
                    <div class="col-xl-7 col-xxl-8">
                        <div
                            class="authentication-login bg-body row justify-content-center align-items-center p-4"
                            style="height: 100%"
                        >
                            <div class="col-sm-8 col-md-6 col-xl-9">
                                <div class="mb-4">
                                    <div style="font-weight: bold; font-size: 50px">ScholaLibris</div>
                                </div>
                                <slot />
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-xl-5 col-xxl-4"
                        style="background-image: linear-gradient(rgba(43, 74, 190, 1), rgba(46, 169, 95, 1))"
                    >
                        <div
                            class="d-none d-xl-flex align-items-center justify-content-center"
                            style="position: absolute; top: 30%"
                        >
                            <img src="/image/logo-auth.svg" alt="" class="img-fluid" width="500" />
                        </div>
                        <div
                            class="informasi"
                            style="padding-left: 30px; padding-right: 30px; position: absolute; bottom: 0"
                        >
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="font-weight: 600; font-size: 16px; color: white">Kontak Kami</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="font-weight: 500; font-size: 14px; color: white">
                                        <!-- <i class="ti ti-phone"></i> 021 12345678 -->
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <span style="font-weight: 500; font-size: 14px; color: white">
                                        <!-- <i class="ti ti-mail"></i> gtkmadrasah@kemenag.go.id -->
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <!-- <div style="float: right">
                                        <a href="https://www.facebook.com/gtkmadrasah17/" _target="blank">
                                            <i
                                                class="ti ti-brand-facebook"
                                                style="color: white; font-size: 25px; margin-left: 20px"
                                            ></i>
                                        </a>
                                        <a href="https://twitter.com/gtk_madrasah?lang=en" _target="blank">
                                            <i
                                                class="ti ti-brand-twitter"
                                                style="color: white; font-size: 25px; margin-left: 20px"
                                            ></i>
                                        </a>
                                        <a href="https://www.instagram.com/gtkmadrasah/" _target="blank">
                                            <i
                                                class="ti ti-brand-instagram"
                                                style="color: white; font-size: 25px; margin-left: 20px"
                                            ></i>
                                        </a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
