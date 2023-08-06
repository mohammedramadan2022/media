<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import SiteSpinner from "@/components/front/includes/SiteSpinner";
import {useGetImage} from "@/composables/useHelper";
import {useStore} from "vuex";

const store = useStore();

store.dispatch('getAboutUsPage');
</script>

<template>
    <app-layout>
        <SiteSpinner v-if="store.state.isLoading"/>

        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'about'}" v-text="$t('message.aboutRental')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="fixed-pages">
            <div class="container">
                <div class="about-us">
                    <router-link :to="{name: 'home'}">
                        <img class="img-fluid" :src="useGetImage('front/assets/images/rental-dark.svg')" width="160" alt="logo">
                    </router-link>
                    <h1 v-text="$t('message.aboutRental')"></h1>
                    <div v-html="store.state.getAboutUsPage"></div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
