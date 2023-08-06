<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

store.dispatch('getTermsPage');

let termsPage = computed(() => store.state.getTermsPage);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'terms'}" v-text="$t('message.terms')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="fixed-pages">
            <div class="container">
                <div class="use-policy">
                    <h1 v-text="$t('message.terms')"></h1>
                    <div class="body-text">
                        <p v-html="termsPage"></p>
                    </div>
<!--                    <div class="text-center">-->
<!--                        <a :href="store.state.termsPdfFile" download class="btn btn-primary-color">-->
<!--                            <i class="fa-regular fa-file-pdf"></i>{{ $t('message.terms') }}-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
        </section>
    </app-layout>
</template>
