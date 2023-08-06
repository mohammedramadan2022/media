<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import SiteSpinner from "@/components/front/includes/SiteSpinner";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

store.dispatch('getFaqsPage');

let faqs = computed(() => store.state.getFaqsPage);
</script>

<template>
    <app-layout>
        <SiteSpinner v-if="store.state.isLoading"></SiteSpinner>

        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'faqs'}" v-text="$t('message.faqs')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="questions">
            <div class="container">
                <div class="row gy-0">
                    <div class="col-12">
                        <h1 v-text="$t('message.faqs')"></h1>
                    </div>
                    <div class="col-12">
                        <div class="accordion" id="accordionExample">
                            <!-- item -->
                            <div class="accordion-item mb-4" v-for="(faq, index) in faqs" :key="index">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse'+index" v-text="faq.question"></button>
                                </h2>
                                <div :id="'collapse'+index" data-bs-parent="#accordionExample" class="accordion-collapse collapse" :class="{'show': index === 0}">
                                    <div class="accordion-body" v-text="faq.answer"></div>
                                </div>
                            </div>
                            <!-- end of item -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
