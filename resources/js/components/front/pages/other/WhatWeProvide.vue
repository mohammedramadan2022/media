<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";

const store = useStore();

store.dispatch('whatWeProvide');
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'whatWeProvide'}" v-text="$t('message.whatWeProvide')"></router-link>
            </li>
        </template>
        <div class="container" v-html="store.state.whatWeProvide"></div>
    </app-layout>
</template>
