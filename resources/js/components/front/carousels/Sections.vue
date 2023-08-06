<script setup>
import {Carousel, Slide, Navigation, Pagination} from "vue3-carousel";
import {ref} from "vue";
import {useStore} from "vuex";

const store = useStore();

let sectionSettings = ref({
    autoplay: "5000",
    dir: 'rtl',
    itemsToShow: 4,
    pauseAutoplayOnHover: true,
    snapAlign: 'center',
    wrapAround: true,
    breakpoints: {
        0: {itemsToShow: 1},
        290: {itemsToShow: 2},
        550: {itemsToShow: 3},
        851: {itemsToShow: 5},
        1021: {itemsToShow: 6},
        1191: {itemsToShow: 7}
    }
});
</script>

<template>
    <section class="wow fadeInUp" id="sections">
        <div class="container" v-if="store.state.home.sections.length > 0">
            <h5>
                {{ $t('message.sections') }}
                <router-link :to="{name: 'sections'}">{{$t('message.showMore')}}&nbsp;<i class="fa fa-angle-double-left"></i></router-link>
            </h5>
            <carousel :settings="sectionSettings">
                <slide v-for="(section, index) in store.state.home.sections" :key="index">
                    <router-link @click="store.dispatch('getProductsBySectionId', section.id ?? 0)" :to="{name: 'section-products', params: {id: section.id ?? 0}}">
                        <div class="card section-item">
                            <i class="fa fa-2x icon-for-section" :class="section.icon"></i>
                            <div class="card-body">
                                <span class="card-title" v-text="section.name"></span>
                            </div>
                        </div>
                    </router-link>
                </slide>
                <template #addons>
                    <pagination />
                    <navigation />
                </template>
            </carousel>
        </div>
        <div class="container" v-else><div class="alert alert-info text-center" v-text="$t('message.noSections')"></div></div>
    </section>
</template>

<style scoped>
.a {
    width: 191px;
}

#sections .section-item {
    background: var(--white-color) 0 0 no-repeat padding-box;
    border: 1px solid #EEF1F6;
    border-radius: 10px;
    margin-bottom: 10px;
    text-align: center;
    padding: 24px;
    width: 160px;
}

@media(min-width: 450px) and (max-width: 550px){
    #sections .section-item{
        width: unset;
    }
}

@media(max-width: 300px){
    .carousel__slide{
        display: flex;
        justify-content: center;
        align-items: centet;
    }
}

#sections .section-item:hover {
    color: var(--primary-color);
    box-shadow: 0 2px 20px #0000001A;
    transition: 300ms ease;
}

#sections .icon-for-section{
    font-size: 40px;
}

#sections .section-item .card-body {
    padding: 24px 0 0 0 !important;
}

#sections .section-item .card-title {
    display: block;
    color: var(--basic-1000-color);
    font-size: 16px;
    font-family: Tajawal-Medium, sans-serif;
    margin-bottom: 0;
}

#sections .section-item:hover .card-title {
    color: var(--primary-color);
    transition: 300ms ease;
}
</style>
