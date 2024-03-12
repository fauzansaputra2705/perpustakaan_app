/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<script setup>
const props = defineProps({
    typeAlert: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <div class="col-lg-12">
        <div
            v-if="props.typeAlert == 'info'"
            class="card shadow-none position-relative overflow-hidden"
            style="
                background-image: url('/image/background-info.svg');
                background-repeat: no-repeat;
                background-size: cover;
            "
        >
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
        <div
            v-else-if="props.typeAlert == 'warning'"
            class="card shadow-none position-relative overflow-hidden"
            style="
                background-image: url('/image/background-warning.svg');
                background-repeat: no-repeat;
                background-size: cover;
            "
        >
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
        <div
            v-else-if="props.typeAlert == 'danger'"
            class="card shadow-none position-relative overflow-hidden"
            style="
                background-image: url('/image/background-danger.svg');
                background-repeat: no-repeat;
                background-size: cover;
            "
        >
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
