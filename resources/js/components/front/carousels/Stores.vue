<script setup>
import {Carousel, Slide, Navigation, Pagination} from "vue3-carousel";
import {ref} from "vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import {useSwalWarning} from "@/composables/useSwal";
import User from "@/libs/User";

const store = useStore();
const {push} = useRouter();
let auth = User.auth();

let storeSettings = ref({
    autoplay: "5000",
    dir: 'rtl',
    breakpoints: {
        360 : {
            itemsToShow: 2,
        },
        539 : {
            itemsToShow: 3,
        },
        800 : {
            itemsToShow: 5,
        },
        1000 : {
            itemsToShow: 7,
        },
    },
    pauseAutoplayOnHover: true,
    snapAlign: 'center',
    wrapAround: true,
});

async function handleNavigation(provider) {
    if (User.hasToken() && auth.city.id !== provider.city.id) {
        await useSwalWarning(trans('message.thisProviderIsNotInYourCity'));
        return;
    }

    await push({name: 'store-details', params: {id: provider.id}});
}
</script>

<template>
    <section class="wow fadeInUp" id="stores">
        <div class="container" v-if="store.state.home.stores.length > 0">
            <h5>
                {{ $t('message.commonStores') }}
                <router-link :to="{name: 'stores'}">{{$t('message.showMore')}}&nbsp;<i class="fa fa-angle-double-left"></i></router-link>
            </h5>
            <carousel :settings="storeSettings">
                <slide v-for="(provider, index) in store.state.home.stores" :key="index">
                    <a href="javascript:void(0);" @click.prevent="handleNavigation(provider)">
                        <div class="store-item">
                            <div class="img-div">
                                <img class="card-img-top" :src="provider.logo" :alt="provider.store_name">
                            </div>
                            <span v-text="provider.store_name"></span>
                        </div>
                    </a>
                </slide>

                <template #addons>
                    <pagination />
                    <navigation />
                </template>
            </carousel>
        </div>
        <div class="container" v-else><div class="alert alert-info text-center" v-text="$t('message.noStores')"></div></div>
    </section>
</template>

<style>
#stores .store-item {
    background: transparent;
    border: none;
    margin-bottom: 10px;
    text-align: center;
}

#stores .store-item .img-div {
    align-items: center;
    background: var(--white-color) 0 0 no-repeat padding-box;
    border: 1px solid #eef1f6;
    border-radius: 10px;
    display: flex;
    height: 115px;
    margin-bottom: 10px;
    width: 170px;
}

@media(min-width: 450px) and (max-width: 550px){
    #stores .store-item .img-div{
        width: unset;
    }
}

/*#stores .store-item:hover .img-div {*/
/*    box-shadow: 0 2px 20px #0000001A;*/
/*    transition: 300ms ease;*/
/*}*/

#stores .store-item .img-div img {
    height: 80px;
    object-fit: contain;
}

#stores .store-item span {
    font-size: 16px;
    font-family: Tajawal-Bold, sans-serif;
    color: var(--basic-1000-color);
}

#stores .store-item:hover span {
    color: var(--primary-color);
    transition: 300ms ease;
}

.carousel {
    position: relative;
    text-align: center;
    box-sizing: border-box;
}

.carousel * {
    box-sizing: border-box;
}

.carousel__track {
    display: flex;
    margin: 0;
    padding: 0;
    position: relative;
}

.carousel__viewport {
    overflow: hidden;
}

.carousel__sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    background: var(--vc-nav-background);
    border-radius: var(--vc-nav-border-radius);
    width: var(--vc-nav-width);
    height: var(--vc-nav-height);
    text-align: center;
    font-size: var(--vc-nav-height);
    padding: 0;
    color: var(--vc-nav-color);
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    border: 0;
    cursor: pointer;
    margin: 0 10px;
    top: 50%;
    transform: translateY(-50%);
}

.carousel__prev:hover,
.carousel__next:hover {
    color: var(--vc-nav-color-hover);
}

.carousel__next--disabled,
.carousel__prev--disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.carousel__prev {
    background: var(--white-color) 0 0 no-repeat padding-box;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    left: 0;
}

.carousel__next {
    background: var(--white-color) 0 0 no-repeat padding-box;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    right: 0;
}

.carousel--rtl .carousel__prev {
    left: auto;
    right: -83px;
    top: 83px;
}

.carousel--rtl .carousel__next {
    right: auto;
    left: -83px;
    top: 83px;
}

@media(max-width: 991px){
    .carousel--rtl .carousel__prev {
    display: none !important;
    }

.carousel--rtl .carousel__next {
    display: none !important;
    }
}

.carousel__icon {
    background: var(--white-color) 0 0 no-repeat padding-box;
    width: 27px;
    height: 48px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

.carousel__pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    line-height: 0;
    margin: 10px 0 0;
}

.carousel__pagination-button {
    display: block;
    border: 0;
    margin: 0;
    cursor: pointer;
    padding: var(--vc-pgn-margin);
    background: transparent;
}

.carousel__pagination-button::after {
    display: block;
    content: '';
    background: var(--white-color) 0 0 no-repeat padding-box;
    border: 1px solid var(--primary-color);
    width: 11px;
    height: 11px;
    border-radius: 100px;
}

.carousel__pagination-button--active::after {
    background: var(--primary-color) 0 0 no-repeat padding-box;
    width: 22px;
}

@media(max-width: 300px){
    #stores .store-item .img-div{
        width: unset !important;
    }
    #stores .store-item .img-div img{
        max-height: unset !important;
        height: 80px;
    }
}
</style>
