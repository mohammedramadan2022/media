<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Pagination, Navigation } from 'vue3-carousel';
</script>

<template>
    <carousel :items-to-show="1.5">
        <slot/>

        <template #addons>
            <navigation />
            <pagination />
        </template>
    </carousel>
</template>
