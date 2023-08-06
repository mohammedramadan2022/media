<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import SiteSpinner from "@/components/front/includes/SiteSpinner";
import {useGetImage} from "@/composables/useHelper";
import {useStore} from "vuex";

const store = useStore();

store.dispatch('getContractTermsPage');
</script>

<template>
    <app-layout>
        <SiteSpinner v-if="store.state.isLoading"/>

        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: $route.name}" v-text="$t('message.contractTerms')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="fixed-pages">
            <div class="container">
                <div class="about-us">
                    <router-link :to="{name: 'home'}">
                        <img class="img-fluid" :src="useGetImage('front/assets/images/rental-dark.svg')" width="160" alt="logo">
                    </router-link>
                    <h1 v-text="$t('message.contractTerms')"></h1>
                    <div v-html="store.state.contractTermsPage"></div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
