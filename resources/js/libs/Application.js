import {createApp} from "vue";
import store from "@/store/modules/root";

const app = createApp({
    mounted() {
        let htmlEl = document.querySelector("html");
        htmlEl.setAttribute('dir', currentLang === 'ar' ? 'rtl' : 'ltr');
        htmlEl.setAttribute('lang', currentLang);
        store.state.isLoading = false;
    }
});

window.app = app;

export default app;
