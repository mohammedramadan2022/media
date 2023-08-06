<script setup>
import ProfileSideMenu from "@/components/front/includes/ProfileSideMenu";
import AppLayout from "@/components/front/layout/AppLayout";
import {onBeforeMount, ref} from "vue";
import { useRouter } from 'vue-router';
import {useStore} from "vuex";
import {useSuccessSwal} from "@/composables/useSwal";
import User from "@/libs/User";

const {push} = useRouter();
const store = useStore();
let auth = ref({});

onBeforeMount(() => {
    store.dispatch('getUpdatedProfile');
    auth.value = User.auth();
});

function onCopy() {
    useSuccessSwal(trans('message.copied'),'center');
}
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link :to="{name: 'profile'}" v-text="$t('message.personalInfo')"></router-link>
            </li>
        </template>

        <!-- content -->
        <section id="content" class="my-account personal-info">
            <div class="container">
                <div class="row gy-3 gy-lg-0">
                    <!-- menu -->
                    <div class="col-lg-3"><profile-side-menu/></div>
                    <!-- data -->
                    <div class="col-lg-9">
                        <div class="data">
                            <h6 v-text="$t('message.personalInfo')"></h6>

                            <div class="row gy-3 row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <span class="key" v-text="$t('message.identityImage')"></span>
                                    <div class="value"><img :src="User.auth().identity" style="width: 50%;" alt=""></div>
                                </div>

                                <div class="col">
                                    <span class="key" v-text="$t('message.identityNumber')"></span>
                                    <div class="value">{{ auth.identity_number !== '' ? auth.identity_number : $t('message.noValue') }}</div>
                                </div>

                                <div class="col">
                                    <span class="key" v-text="$t('message.firstName')"></span>
                                    <div class="value">{{ auth.first_name !== '' ? auth.first_name : $t('message.noValue') }}</div>
                                </div>
                                <div class="col">
                                    <span class="key" v-text="$t('message.lastName')"></span>
                                    <div class="value">{{ auth.last_name !== '' ? auth.last_name : $t('message.noValue') }}</div>
                                </div>

                                <div class="col">
                                    <span class="key" v-text="$t('message.email')"></span>
                                    <div class="value">{{ auth.email !== '' ? auth.email : $t('message.noValue') }}</div>
                                </div>

                                <div class="col">
                                    <span class="key" v-text="$t('message.phone')"></span>
                                    <div class="value">{{ auth.phone !== '' ? auth.phone : $t('message.noValue') }}</div>
                                </div>

                                <div class="col">
                                    <span class="key" v-text="$t('message.whatsapp')"></span>
                                    <div class="value">{{ auth.whatsapp !== '' ? auth.whatsapp : $t('message.noValue') }}</div>
                                </div>

                                <div class="col">
                                    <span class="key" v-text="$t('message.city')"></span>
                                    <div class="value">{{ auth.city ? auth.city.text : $t('message.noValue') }}</div>
                                </div>

                                <div class="col">
                                    <span class="key" v-text="$t('message.ownAccessCode')"></span>
                                    <div class="value">
                                        <div class="row justify-content-between">
                                            <div class="col" id="app_access_code" v-text="auth.app_access_code"></div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0);" v-clipboard:copy="auth.app_access_code" v-clipboard:success="onCopy"><i class="fa-solid fa-copy"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="text-center text-md-end">
                                        <router-link :to="{name: 'edit-profile'}" class="btn btn-primary-color" v-text="$t('message.editPersonalInformation')"></router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>
