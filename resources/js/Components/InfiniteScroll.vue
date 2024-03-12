/**
 * @author Muhammad Fauzan Saputra
 * @email fauzansaputra2705@gmail.com
 * @desc [description]
 */

<script setup>
import { ref, watch } from 'vue'
import InfiniteLoading from 'v3-infinite-loading'
import 'v3-infinite-loading/lib/style.css'

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
})

const emit = defineEmits(['data'])

let data = ref([])
let resetData = ref(false)
let page = ref(1)
let nextUrl = ref(null)
let search = ref('')

const refresh = () => {
    page.value = 1
    data.value = []
    nextUrl.value = null
    resetData.value = !resetData.value
    console.log('refresh')
}

const load = async ($state) => {
    console.log('loading data scroll...')

    try {
        let response = {}
        if (nextUrl.value == null && page.value == 1) {
            const separator = props.url?.includes('?') ? '&' : '?'
            const updatedUrl = `${props.url}${separator}search=${search.value}`
            response = await fetch(updatedUrl)
        } else {
            const separator = nextUrl.value?.includes('?') ? '&' : '?'
            const updatedUrl = `${nextUrl.value}${separator}search=${search.value}`
            response = await fetch(updatedUrl)
        }

        if (response.ok) {
            let json = await response.json()
            if (json?.data?.length < 1 && nextUrl.value == null) $state.complete()
            else {
                data.value.push(...json.data)
                $state.loaded()
            }
            nextUrl.value = json?.next_page_url
        } else {
            $state.complete()
        }

        page.value++
    } catch (error) {
        console.log(error)
        page.value = 1
        data.value = []
        nextUrl.value = null
        $state.error()
    }
    emit('data', data.value)
}

watch(
    () => props.url,
    (newValue, oldValue) => {
        if ((oldValue != '' && newValue != oldValue) || newValue == '') {
            refresh()
        }
    },
    { deep: true },
)
</script>

<template>
    <input v-model="search" type="search" class="form-control" placeholder="Search" @keyup.enter="refresh" />
    <slot />
    <InfiniteLoading :identifier="resetData" @infinite="load" />
</template>
