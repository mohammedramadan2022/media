import User from "@/libs/User";
import $ from "jquery";

window.currentLang = localStorage.getItem('lang') ?? 'ar';
window.base_url = root + '/';
window.api_base_url = base_url + 'api';
window.rootUrl = isLocal === '' ? (root + '/public/') : (root + '/');
window.direction = currentLang === 'ar' ? 'rtl' : 'ltr';

window.User = User;
window.auth = () => User.auth();
window.dd = (arg) => console.log(arg);
window.trans = (key) => i18n.global.t(key);
window.$ = $;
