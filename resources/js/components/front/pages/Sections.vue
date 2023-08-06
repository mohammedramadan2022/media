<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();
let has_pagination = computed(() => store.state.section.has_pagination);
let sections = computed(() => store.state.section.getAllSections);

</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'products'}" v-text="$t('message.sections')"></router-link>
            </li>
        </template>

        <section id="content" class="all-stores">
            <div class="container">
                <div class="row gy-3 gy-xl-0">
                    <!-- data -->
                    <div class="col-12">
                        <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5">
                            <div class="col" v-for="(section, index) in sections" :key="index">
                                <router-link :to="{name: 'section-products', params: {id: section.id}}">
                                    <div class="store-item">
                                        <div class="img-div cat-icon">
                                            <i class="fa fa-2x" :class="section.icon"></i>
                                        </div>
                                        <span v-text="section.name"></span>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>

<!--                    <template v-if="sections.length === 0" class="main-filter-div mt-1">-->
<!--                        <div class="alert alert-info text-center" v-text="$t('message.noSections')"></div>-->
<!--                    </template>-->

<!--                    &lt;!&ndash; show more &ndash;&gt;-->
<!--                    <div class="text-center" style="margin-top: 40px; margin-right:  168px;" v-if="has_pagination">-->
<!--                        <a href="javascript:void(0);" @click.prevent="store.dispatch('getSectionsNextPage')" class="show-more-link">-->
<!--                            {{ $t('message.loadMore') }}<i class="fa fa-arrow-down ms-2"></i>-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
        </section>
    </app-layout>
</template>
