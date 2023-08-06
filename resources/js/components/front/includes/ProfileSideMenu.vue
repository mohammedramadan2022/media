<script setup>
import {useStore} from "vuex";
import User from "@/libs/User";

const store = useStore();
</script>
<template>
    <div class="menu">
        <h6 class="title" v-text="$t('message.myAccount')"></h6>
        <ul class="list-unstyled">
            <li><router-link :to="{name: 'profile'}" active-class="active" exact v-text="$t('message.personalInfo')"></router-link></li>
            <li><router-link :to="{name: 'orders'}" active-class="active" exact v-text="$t('message.myOrders')"></router-link></li>
            <li><router-link :to="{name: 'favorites'}" active-class="active" exact v-text="$t('message.myFavorites')"></router-link></li>
            <li><router-link :to="{name: 'wallet'}" active-class="active" exact v-text="$t('message.myWallet')"></router-link></li>
            <li><router-link @click="store.commit('setAddressItemStyle', User.auth().address_id);" :to="{name: 'addresses'}" active-class="active" exact v-text="$t('message.myAddresses')"></router-link></li>
            <li><hr/></li>
            <li><a href="javascript:void(0);" @click.prevent="store.dispatch('logout')" class="logout-link" v-text="$t('message.logout')"></a></li>
        </ul>
    </div>
</template>
