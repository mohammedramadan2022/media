<script setup>
import AppLayout from "@/components/front/layout/AppLayout";
import ProfileSideMenu from "@/components/front/includes/ProfileSideMenu";
import {useRouter} from "vue-router";
import {computed} from "vue";
import {useStore} from "vuex";
import {getCurrentStatus, getCurrentStatusClass, getPaymentStatus} from "@/composables/useOrderStatus";

const {push} = useRouter();
const store = useStore();

store.dispatch('getUserOrders');

let orders = computed(() => store.state.order.allOrders);
let pagination = computed(() => store.state.order.pagination);
let has_pagination = computed(() => store.state.order.has_pagination);
let has_order_filter_pagination = computed(() => store.state.order.has_order_filter_pagination);

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

                  <!-- data -->
                  <div class="col-lg-9">
                      <div class="data">
                          <h6 v-text="$t('message.myOrders')"></h6>
                          <form action="">
                              <div class="row gy-2 gy-lg-0 justify-content-between align-items-center">
                                  <div class="col-12 col-md-7">
                                      <div class="input-group">
                                          <input type="text" @keyup="store.dispatch('filterKeyUp', $event.target.value)" class="form-control" :placeholder="$t('message.searchInOrders')">
                                          <span class="input-group-text">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </span>
                                      </div>
                                  </div>
                                  <div class="col-12 col-md-auto">
                                      <div class="row gx-3">
                                          <label for="category" class="col-sm-auto col-form-label" v-text="$t('message.ordersFilter')"></label>
                                          <div class="col-sm">
                                              <select class="form-select" @change="store.dispatch('filterOrders', $event.target.value)" id="category">
                                                  <option value="all" v-text="$t('message.all')"></option>
                                                  <option value="pending" v-text="$t('message.pending')"></option>
                                                  <option value="rejected" v-text="$t('message.rejected')"></option>
                                                  <option value="accepted" v-text="$t('message.accepted')"></option>
                                                  <option value="delivered" v-text="$t('message.delivered')"></option>
                                                  <option value="processing" v-text="$t('message.processing')"></option>
                                                  <option value="in_delivery" v-text="$t('message.in_delivery')"></option>
                                                  <option value="processed" v-text="$t('message.processed')"></option>
                                                  <option value="retrieving" v-text="$t('message.retrieving')"></option>
                                                  <option value="delivered" v-text="$t('message.delivered')"></option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </form>

                          <div class="table-responsive mt-3 mb-3 mb-sm-0">
                              <table class="table table-striped table-hover table-borderless">
                                  <thead>
                                  <tr>
                                      <th scope="col" v-text="$t('message.orderNumber')"></th>
                                      <th scope="col" v-text="$t('message.orderDate')"></th>
                                      <th scope="col" v-text="$t('message.orderCost')"></th>
                                      <th scope="col" v-text="$t('message.orderPaymentStatus')"></th>
                                      <th scope="col" colspan="2" v-text="$t('message.orderStatus')"></th>
                                  </tr>
                                  </thead>
                                  <tbody v-if="orders.length > 0">
                                      <tr v-for="order in orders" :key="order.id">
                                          <th scope="row">{{order.order_no}}#</th>
                                          <td v-text="order.created_at"></td>
                                          <td v-text="$t('message.shoppingCartTotal', {total: order.total})"></td>
                                          <td v-text="getPaymentStatus(order.payment_status)"></td>
                                          <td>
                                              <div class="order-status">
                                                  <i class="fa-solid fa-circle me-2" :class="getCurrentStatusClass(order.order_status)"></i>{{getCurrentStatus(order.order_status)}}
                                              </div>
                                              <router-link @click="store.dispatch('getOrderById', order.order_no)" :to="{name: 'order', params: {order_no: order.order_no}}" class="btn btn-outline-primary-color float-end" v-text="$t('message.more')"></router-link>
                                          </td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>

                          <div v-if="orders.length === 0" class="alert alert-info text-center" v-text="$t('message.noVar', {var: $t('message.orders')})"></div>

                          <!-- show more -->
                          <div class="text-center" v-if="has_pagination">
                              <a href="javascript:void(0);" @click.prevent="store.dispatch('getOrdersNextPage')" class="show-more-link">
                                  {{$t('message.loadMore')}}<i class="fa fa-arrow-down ms-2"></i>
                              </a>
                          </div>

                          <!-- show more filter orders -->
                          <div class="text-center" v-if="has_order_filter_pagination">
                              <a href="javascript:void(0);" @click.prevent="store.dispatch('getOrdersFilterNextPage')" class="show-more-link">
                                  {{$t('message.loadMore')}}<i class="fa fa-arrow-down ms-2"></i>
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </section>
  </app-layout>
</template>
