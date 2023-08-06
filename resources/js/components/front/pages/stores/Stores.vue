<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import {computed} from "vue";
import User from "@/libs/User";
import {useSwalWarning} from "@/composables/useSwal";
import {useRouter} from "vue-router";

const store = useStore();
const {push} = useRouter();

store.dispatch('getAllStores');
store.dispatch('getStoreSectionWithCategories');

let sections = computed(() => store.state.providers.sections);
let stores = computed(() => store.state.providers.allStores);
let pagination = computed(() => store.state.providers.pagination);
let has_pagination = computed(() => store.state.providers.has_pagination);

async function handleNavigation(provider) {
    console.log(User.auth().city.id);

    if(User.hasToken() && User.auth().city.id) {
        alert('here');
    }

    if (User.hasToken() && User.auth().city.id !== provider.city.id) {
        await useSwalWarning(trans('message.thisProviderIsNotInYourCity'));
        return;
    }

    await push({name: 'store-details', params: {id: provider.id}});
}
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active"><router-link :to="{name: 'stores'}" v-text="$t('message.allStores')"></router-link></li>
        </template>

        <!-- content -->
        <section id="content" class="all-stores">
            <div class="container">
                <div class="row gy-3 gy-xl-0">
                    <!-- sections filter -->
                    <div class="col-lg-4 col-xl-3">
                        <div class="sections-div">
                            <h6 v-text="$t('message.sections')"></h6>
                            <ul class="list-unstyled sections-data" id="store-sections">
                                <li class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="active" v-text="$t('message.all')"></a>
                                    <span class="badge-count">({{sections.all}})</span>
                                </li>
                                <template v-for="(section, index) in sections.sections" :key="index">
                                    <li v-if="section.categories.length > 0">
                                        <div class="accordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseOne-'+section.id">
                                                        {{section.name}}
                                                        <span class="ms-auto badge-count">({{section.products_count}})</span>
                                                    </button>
                                                </h2>
                                                <div :id="'collapseOne-'+section.id" class="accordion-collapse collapse" data-bs-parent="#store-sections">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled">
                                                            <li v-for="(category, index) in section.categories" :key="index">
                                                                <router-link :to="{name: 'store-category', params: {id: category.id}}">{{category.name}}</router-link>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li v-else class="d-flex justify-content-between align-items-center">
                                        <a href="#" v-text="section.name"></a>
                                        <span class="badge-count">({{section.products_count}})</span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <!-- data -->
                    <div class="col-lg-8 col-xl-9">
                        <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
                            <div class="col" v-for="(provider, index) in stores" :key="index">
                                <a href="javascript:void(0);" @click.prevent="handleNavigation(provider)">
                                    <div class="store-item">
                                        <div class="img-div">
                                            <img :src="provider.logo" :alt="provider.store_name">
                                        </div>
                                        <span v-text="provider.store_name"></span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- loading -->
<!--                        <div class="row mt-5 text-center">-->
<!--                            <div class="col-xl-12">-->
<!--                                <div class="spinner-border text-primary-color" role="status">-->
<!--                                    <span class="visually-hidden">Loading...</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

                    <template v-if="stores.length === 0" class="main-filter-div mt-1">
                        <div class="alert alert-info text-center" v-text="$t('message.noStores')"></div>
                    </template>

                    <!-- show more -->
                    <div class="text-center" style="margin-top: 40px; margin-right:  168px;" v-if="has_pagination">
                        <a href="javascript:void(0);" @click.prevent="store.dispatch('getStoresNextPage')" class="show-more-link">
                            {{$t('message.loadMore')}}<i class="fa fa-arrow-down ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
