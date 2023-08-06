<script setup>
    import AppLayout from "@/components/front/layout/AppLayout";
</script>

<template>
    <app-layout>
        <template #nav>
            <li class="breadcrumb-item active">
                <router-link to="/" v-text="$t('message.notFound')"></router-link>
            </li>
        </template>

        <!--Not Found Start-->
        <div class="blog main-content-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="error-page text-center error-404 not-found">
                            <div class="error-header">
                                <h2><strong>404</strong></h2>
                            </div>
                            <div class="error-message">
                                <h3 v-text="$t('message.pageNotFoundTitle')"></h3>
                            </div>

                            <div class="error-content">{{$t('message.pageNotFoundMessage')}}&nbsp;<br>
                                <router-link to="/" class="btn btn-main" v-text="$t('message.backToHome')"></router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- #main -->
        </div>
        <!--Not Found End-->
    </app-layout>
</template>

<style scoped>
    h1{
        margin: 50px 0;
    }
</style>
