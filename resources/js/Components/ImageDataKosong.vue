/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<script setup>
const props = defineProps({
    desc: {
        type: String,
        required: false,
        default: '',
    },
})
</script>

<template>
    <div class="text-center">
        <img src="/image/data-kosong.svg" class="img-fluid" alt="data kosong" />
        <h5 class="mt-3">Belum Memiliki Data!</h5>
        <p>
            {{ props.desc }}
        </p>
    </div>
</template>
