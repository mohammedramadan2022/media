<script setup>
import {useStore} from "vuex";

let props = defineProps(['sections', 'store_id']);
const store = useStore();
</script>

<template>
    <div class="sections-div">
        <h6 v-text="$t('message.sections')"></h6>
        <ul class="list-unstyled sections-data" id="accordionExample">
            <li class="d-flex justify-content-between align-items-center">
                <a href="javascript:void(0);" class="active" v-text="$t('message.all')"></a>
                <span class="badge-count">({{sections.all}})</span>
            </li>
            <template v-for="(section, index) in sections.sections" :key="index">
                <li v-if="section.categories.length > 0">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseOne-'+section.id">
                                    {{section.name}}
                                    <span class="ms-auto badge-count">({{section.products_count}})</span>
                                </button>
                            </h2>
                            <div :id="'collapseOne-'+section.id" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-unstyled">
                                        <li v-for="category in section.categories" :key="category.id">
                                            <a
                                                href="javascript:void(0);"
                                                @click.prevent="store.dispatch('getStoreProductsByCategoryId',{category_id: category.id, store_id: store_id});"
                                                v-text="category.name"></a>
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
