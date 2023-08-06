<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import {useStore} from "vuex";
import {computed} from "vue";
import {useRouter} from "vue-router";

const store = useStore();
const router = useRouter();

store.dispatch('getNotificationsPage');

let notifications = computed(() => store.state.notification.notifications);
let has_pagination = computed(() => store.state.notification.has_pagination);

function getClickableLink(notification) {
    let types = [
        'user_order_payed',
        'user_order_ready_to_pay',
        'user_order_undertaking',
        'user_order_rejected'
    ];

    if(types.includes(notification.type)) {
        if(notification.type === 'user_order_undertaking') return {name: 'undertaking', params: {undertaking_id: notification.type_id}};

        return {name: 'order', params: {order_no: notification.type_id}};
    }

    return {name: 'notifications'};
}
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'notifications'}" v-text="$t('message.notifications')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content">
            <div class="container">
                <div class="notifications" v-if="notifications.length > 0">
                    <div class="row justify-content-between align-items-center mb-3">
                        <div class="col-auto">
                            <h1 class="title" v-text="$t('message.notifications')"></h1>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:void(0);" @click.prevent="store.dispatch('deleteUserNotifications')" class="delete-all">
                                <div><i class="fa-solid fa-trash"></i></div>
                                <span v-text="$t('message.deleteAll')"></span>
                            </a>
                        </div>
                    </div>

                    <div class="notification-item" v-for="notification in notifications" :key="notification.id" :id="'notification-id-' + notification.id">
                        <div class="col">
                            <router-link :to="getClickableLink(notification)" class="notification-link">
                                <div :class="[notification.type === 'user_order_rejected' ? 'unread' : 'read']">
                                    <i class="fa-regular fa-bell"></i>
                                </div>
                                <span class="notification_title" v-text="notification.title"></span>
                            </router-link>
                            <h6 class="notification_description" v-text="notification.body"></h6>
                        </div>
                        <div class="col-auto">
                            <span class="notification_time" v-text="notification.created_at"></span>
                        </div>
                    </div>
                </div>

                <template v-else>
                    <div class="alert alert-info text-center" v-text="$t('message.noVar', {var: $t('message.aNotifications')})"></div>
                </template>
            </div>

            <!-- show more filter orders -->
            <div class="text-center" style="margin-top: 35px;" v-if="has_pagination">
                <a href="javascript:void(0);" @click.prevent="store.dispatch('getNotificationsNextPage')" class="show-more-link">
                    {{$t('message.loadMore')}}<i class="fa fa-arrow-down ms-2"></i>
                </a>
            </div>
        </section>
    </app-layout>
</template>
