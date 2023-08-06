<script setup>
    defineProps(['product']);
</script>

<template>
    <router-link :to="{name: 'product-details', params: {id: product.id}}">
        <div class="result-unit">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img :src="product.image" :alt="product.name">
                </div>
                <div class="col">
                    <span class="title" v-text="product.name"></span>
                    <span class="price" v-text="product.price"></span>
                    <span class="currency" v-text="$t('message.realPerDay')"></span>
                </div>
            </div>
        </div>
    </router-link>
</template>
