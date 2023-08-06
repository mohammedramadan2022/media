<script setup>
import {Carousel, Slide, Navigation} from "vue3-carousel";
import {ref} from "vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";

const store = useStore();
const router = useRouter();

let citiesSettings = ref({
    autoplay: "5000",
    dir: 'rtl',
    itemsToShow: 5,
    touchDrag: true,
    pauseAutoplayOnHover: true,
    snapAlign: 'center',
    wrapAround: true,
    breakpoints: {
        0: {itemsToShow: 1},
        271: {itemsToShow: 2},
        541: {itemsToShow: 3},
        811: {itemsToShow: 4},
        1081: {itemsToShow: 5},
        1621: {itemsToShow: 5},
        1891: {itemsToShow: 5},
    }
});

function setRouteState(city) {
    if(city.products === 0) return;

    else router.push({name: 'city-products', params: {id: city.id}});
}

function setText(products) {
    if(products === 0) return trans('message.soon');

    else return i18n.global.t('message.productsCount', {count: products});
}
</script>

<template>
    <section class="wow fadeInUp" id="cities" v-if="store.state.home.cities.length > 0">
        <div class="container">
            <h5 v-text="$t('message.browseByCity')"></h5>
            <carousel :settings="citiesSettings" style="position: relative">
                <slide v-for="(city, index) in store.state.home.cities" :key="index">
                    <div class="carousel__item">
                        <a href="javascript:void(0);" @click.prevent="setRouteState(city)">
                            <div class="card city-item">
                                <img class="card-img-top" :src="city.image" :alt="city.text">
                                <div class="card-body">
                                    <span class="card-title" v-text="city.text"></span>
                                    <span class="card-text" v-text="setText(city.products)"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </slide>
                <template #addons>
                    <navigation />
                </template>
            </carousel>
        </div>
    </section>
</template>

<style>
#cities a {
    width: inherit;
}

#cities .city-item {
    background: var(--white-color) 0 0 no-repeat padding-box;
    border: 1px solid #EEF1F6;
    border-radius: 10px;
    margin-bottom: 10px;
}

#cities .city-item:hover {
    box-shadow: 0 2px 20px #0000001A;
    transition: 300ms ease;
}

#cities .city-item .card-img-top {
    border-radius: 10px 10px 0 0;
    height: 170px;
    object-fit: cover;
}

#cities .city-item .card-body {
    padding: 25px 0 7px 0 !important;
}

#cities .city-item .card-title {
    display: block;
    color: var(--basic-1000-color);
    font-size: 16px;
    font-family: Tajawal-Bold, sans-serif;
    margin-bottom: 5px;
}

#cities .city-item .card-text {
    display: block;
    color: var(--basic-600-color);
}

#cities .carousel--rtl .carousel__prev {
    left: auto;
    right: -100;
    top: 40%;
    height: 280px;
    width: 100px;
    /*background: transparent linear-gradient(90deg, #FFFFFF00 0%, #FFFFFF 100%) 0 0 no-repeat padding-box;*/
    border-radius: 0px;
    margin: 0;
}

#cities .carousel__icon{
    width: 48px;
    height: 48px;
    padding-top: 8px;
    padding-bottom: 8px;
    align-items: center;
    background: var(--basic-200-color) 0 0 no-repeat padding-box;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
}

#cities .carousel--rtl .carousel__next {
    right: auto;
    left: -100;
    top: 40%;
    height: 280px;
    width: 100px;
    /*background: transparent linear-gradient(270deg, #FFFFFF00 0%, #FFFFFF 100%) 0 0 no-repeat padding-box;*/
    border-radius: 0px;
    margin: 0;
}
</style>
