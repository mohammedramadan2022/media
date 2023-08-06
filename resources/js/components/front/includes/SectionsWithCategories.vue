<script setup>
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import {ref} from "vue";

const props = defineProps(['sections']);
const store = useStore();
const route = useRoute();

const current_id = ref(route.params.id);

function onClickCategory(category) {
    store.dispatch('getProductsByCategoryId', category.id);
    store.dispatch('getSpecsByCategoryId', category.id);
    store.commit('setPaginationToCategory');
}
</script>

<template>
    <div class="sections-div">
        <h6 v-text="$t('message.sections')"></h6>
        <ul class="list-unstyled sections-data" id="accordionExample">
            <li class="d-flex justify-content-between align-items-center">
                <a href="javascript:void(0);" class="active" v-text="$t('message.all')"></a>
                <span class="badge-count">({{ sections.all }})</span>
            </li>
            <template v-for="(section, index) in sections.sections" :key="index">
                <li v-if="section.categories.length > 0">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseOne-'+section.id">
                                    {{ section.name }}
                                    <span class="ms-auto badge-count">({{ section.products_count }})</span>
                                </button>
                            </h2>
                            <div :id="'collapseOne-'+section.id" :class="{'show' : section.id === parseInt(current_id)}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-unstyled">
                                        <li v-for="category in section.categories" :key="category.id">
                                            <a href="javascript:void(0);" @click.prevent="onClickCategory(category)" v-text="category.name"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </template>
            <li class="d-flex justify-content-between align-items-center">
                <slot/>
                <span class="badge-count">({{ sections.offers_count }})</span>
            </li>
        </ul>
    </div>
</template>
