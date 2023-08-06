<script setup>
import AppLayout from "@/components/front/layout/AppLayout.vue";
import ProfileSideMenu from "@/components/front/includes/ProfileSideMenu.vue";
import {useStore} from "vuex";
import {computed} from "vue";
import {useRoute} from "vue-router";

const store = useStore();
const route = useRoute();

store.dispatch('getOrderUndertaking', route.params.undertaking_id);

let undertaking = computed(() => store.state.order.undertaking);
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'orders'}" v-text="$t('message.myOrders')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="my-account my-orders">
          <div class="container">
              <div class="row gy-3 gy-lg-0">
                  <!-- menu -->
                  <div class="col-lg-3"><profile-side-menu/></div>
                  <div class="col-lg-9">
                      <div class="data">
                          <p v-text="undertaking.content"></p>
                          <template v-if="undertaking.status === 'new'">
                              <button @click="store.dispatch('setUserOrderUndertakingAccepted', undertaking.id)" class="btn btn-outline-success" style="margin: 5px;" v-text="$t('message.accept')"></button>
                              <button @click="store.dispatch('setUserOrderUndertakingRefused', undertaking.id)" class="btn btn-outline-danger" style="margin: 5px;" v-text="$t('message.refuse')"></button>
                          </template>

                          <template v-if="undertaking.status !== 'new'">
                              <span v-text="$t('message.' + undertaking.status)"></span>
                          </template>
                      </div>
                  </div>
              </div>
          </div>
        </section>
  </app-layout>
</template>
