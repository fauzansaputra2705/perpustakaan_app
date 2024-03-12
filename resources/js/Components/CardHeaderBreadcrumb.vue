/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    title: {
        type: String,
        required: false,
        default: '',
    },
    breadcrumb: {
        type: Array, //[{nameMenu : String, urlMenu: String, urlMenuParams: Object}]
        required: true,
    },
})
</script>

<template>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ props.title }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li
                                v-for="(value, index) in props.breadcrumb"
                                :key="index"
                                class="breadcrumb-item"
                                :aria-current="props.breadcrumb.length - 1 === index ? 'page' : null"
                            >
                                <span v-if="value.urlMenu == ''" class="text-muted">{{ value.nameMenu }}</span>
                                <span v-else>
                                    <Link
                                        v-if="typeof value.urlMenuParams == 'object'"
                                        class="text-muted"
                                        :href="route(value.urlMenu, { ...value.urlMenuParams })"
                                    >
                                        {{ value.nameMenu }}
                                    </Link>
                                    <Link v-else class="text-muted" :href="route(value.urlMenu)">
                                        {{ value.nameMenu }}
                                    </Link>
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="" alt="" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
