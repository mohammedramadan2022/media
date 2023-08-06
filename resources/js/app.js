require('./bootstrap');
require('@/libs/helpers');
require('@/libs/Firebase');
require('@/libs/Axios');
require('@/libs/I18n');

import {createMetaManager} from 'vue-meta';
import BootstrapVue3 from "bootstrap-vue-3";
import Select2 from "vue3-select2-component";
import VueClipboard from 'vue3-clipboard';
import store from "@/store/modules/root";
import Toaster from '@meforma/vue-toaster';
import app from "@/libs/Application";
import {router} from "@/libs/Prefix";

window.store = store;

app.config.globalProperties.$router = router;

app.use(i18n);
app.use(store);
app.use(router);
app.use(Toaster);
app.use(BootstrapVue3);
app.use(createMetaManager(), {
    // optional pluginOptions
    refreshOnceOnNavigation: true
});
app.use(VueClipboard, {autoSetContainer: true, appendToBody: true});
app.component('Select2', Select2);
app.mount('#app');
