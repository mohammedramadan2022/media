import {createI18n} from "vue-i18n";
import messages from "@/lang/messages";
import {storeCustomKey} from "@/composables/useStorage";

window.i18n = createI18n({legacy: false, globalInjection: true, locale: currentLang, messages: messages});

(currentLang === null || currentLang === undefined) ? storeCustomKey('lang', 'ar') : '';
