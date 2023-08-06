<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import SiteSpinner from "@/components/front/includes/SiteSpinner";
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

store.dispatch('getPrivacyPage');

let policy_page = computed(() => store.state.getPolicyPage);
</script>

<template>
    <app-layout>
        <SiteSpinner v-if="store.state.isLoading"></SiteSpinner>

        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'policy'}" v-text="$t('message.policy')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="fixed-pages">
            <div class="container">
                <div class="use-policy">
                    <h1 v-text="$t('message.policy')"></h1>
                    <div class="body-text">
                        <p v-html="policy_page"></p>
                    </div>
<!--                    <div class="text-center">-->
<!--                        <a :href="store.state.policyPdfFile" target="_blank" download class="btn btn-primary-color">-->
<!--                            <i class="fa-regular fa-file-pdf"></i>{{ $t('message.policyFile') }}-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
        </section>
    </app-layout>
</template>
