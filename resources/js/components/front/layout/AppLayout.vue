<script setup>
import PageHeader from "@/components/front/includes/PageHeader";
import SiteSpinner from "@/components/front/includes/SiteSpinner";
import SiteFooter from "@/components/front/includes/SiteFooter";
import {useStore} from "vuex";
import {useRoute} from "vue-router/dist/vue-router";
import {onMessage} from "firebase/messaging";

const store = useStore();
const route = useRoute();

store.state.notification.hasNotifications = false;

onMessage(messaging,(payload) => {
    app.$toast.show(`${payload.notification.title}`);
    store.state.notification.hasNotifications = true;
    setTimeout(this.$toast.clear,3000);
});

</script>

<template>
    <div>
        <site-spinner v-if="store.state.isLoading" />

        <page-header/>

        <section id="breadcrumb">
            <div class="container">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" v-if="route.fullPath !== '/'">
                            <router-link :to="{name: 'home'}" v-text="$t('message.home')"></router-link>
                        </li>
                        <slot name="nav"></slot>
                    </ol>
                </nav>
            </div>
        </section>

        <slot/>

        <site-footer/>
    </div>
</template>
