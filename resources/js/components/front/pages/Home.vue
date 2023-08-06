<script setup>
import {useStore} from "vuex";
import {computed} from "vue";
import AppLayout from "@/components/front/layout/AppLayout";
import Stores from "@/components/front/carousels/Stores";
import Sections from "@/components/front/carousels/Sections";
import Cities from "@/components/front/carousels/Cities";
import Popular from "@/components/front/carousels/Popular";

const store = useStore();

store.dispatch('getHomePage');

let metaInfo = computed(() => store.state.getMetaInfo);
</script>

<template>
    <metainfo>
        <!-- Search Engine -->
        <meta name="robots" content="index, follow"/>
        <meta name="author" :content="metaInfo.author"/>
        <meta name="description" :content="metaInfo.description"/>
        <meta name="keywords" :content="metaInfo.keywords"/>
        <meta name="image" :content="metaInfo.image">

        <!-- Schema.org for Google -->
        <meta itemprop="name" :content="metaInfo.name">
        <meta itemprop="description" :content="metaInfo.description">
        <meta itemprop="image" :content="metaInfo.image">

        <!-- Open Graph general (Facebook, Pinterest & Google+) -->
        <meta property="og:title" :content="metaInfo.name">
        <meta property="og:description" :content="metaInfo.description">
        <meta property="og:image" :content="metaInfo.image">
        <meta property="og:url" :content="$route.fullPath">
        <meta property="og:site_name" :content="metaInfo.author">
        <meta property="og:type" content="website">

        <!-- Twitter -->
        <meta property="twitter:card" content="website">
        <meta property="twitter:title" :content="metaInfo.name">
        <meta property="twitter:description" :content="metaInfo.description">
        <meta property="twitter:image:src" :content="metaInfo.image">
        <meta name="twitter:card" :content="metaInfo.author">
        <meta name="twitter:site" :content="metaInfo.twitter_site">
        <meta name="twitter:creator" :content="metaInfo.twitter_creator">
    </metainfo>

    <app-layout>
        <!-- sliders & items -->
        <section id="sliders">
            <div class="container" v-if="store.state.home.banners.length > 0">
                <div class="row g-3">
                    <!-- sliders -->

                    <div class="wow fadeInRight" :class="[store.state.home.previews.length > 0 ? 'col-xl-12' : 'col-xl-12']">

                        <div id="carouselExampleCaptions" class="carousel slide main-slider" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button
                                    v-for="(banner, index) in store.state.home.banners"
                                    :key="index"
                                    type="button"
                                    data-bs-target="#carouselExampleCaptions"
                                    :data-bs-slide-to="index"
                                    :class="{'active': index === 0}"></button>
                            </div>
                            <div class="carousel-inner">
                                <div v-for="(banner, index) in store.state.home.banners" :key="index" class="carousel-item" :class="{'active': index === 0}">
                                    <img :src="banner.image" class="d-block w-100" alt="slider image">
                                    <div v-if="banner.type !== 'none'" class="carousel-caption d-none d-md-block text-start">
                                        <template v-if="banner.type === 'section'">
                                            <router-link :to="{name: 'section-products', params: {id: banner.type_id}}" class="btn btn-primary-color" v-text="$t('message.showBannerVar', {var: $t('message.section')})"></router-link>
                                        </template>

                                        <template v-else-if="banner.type === 'link'">
                                            <a :href="banner.type_id" target="_blank" class="btn btn-primary-color" v-text="$t('message.showBannerVar', {var: $t('message.link')})"></a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- items -->
                    <div class="col-xl-12 wow fadeInLeft" v-if="store.state.home.previews.length > 0">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-6" v-for="(preview, index) in store.state.home.previews" :key="index">
                                <a :href="preview.url">
                                    <div class="item-image">
                                        <img :src="preview.image" class="img-fluid w-100" alt="item image">
                                        <span v-text="preview.section.name"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <cities/>

        <stores/>
        
        <popular/>

        <!-- bottom items -->
        <section class="wow fadeInUp" id="bottom-items">
            <div class="container" v-if="store.state.home.features.length > 0">
                <div class="row gy-2 gy-xl-0 row-cols-1 row-cols-sm-2 row-cols-lg-3">
                    <div class="col" v-for="(feature, index) in store.state.home.features" :key="index">
                        <a :href="feature.url"><img :src="feature.image" class="img-fluid w-100" alt="item image"></a>
                    </div>
                </div>
            </div>
        </section>

        <sections/>
        
    </app-layout>
</template>

<style scoped>
    #breadcrumb nav .breadcrumb{
        visibility: hidden;
    }
</style>
