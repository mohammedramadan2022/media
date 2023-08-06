import {createRouter, createWebHistory} from 'vue-router';
import {isOrderCanceled} from "@/middleware/isOrderCanceled";
import {isAuth} from "@/middleware/isAuth";

// User Routes
import Home from "@/components/front/pages/Home";
import About from "@/components/front/pages/other/About";
import NotFound from "@/components/front/pages/other/NotFound";
import ContactUs from "@/components/front/pages/other/ContactUs";
import Faqs from "@/components/front/pages/other/Faqs";
import Terms from "@/components/front/pages/other/Terms";
import Policy from "@/components/front/pages/other/Policy";
import WhatWeProvide from "@/components/front/pages/other/WhatWeProvide";
import Notifications from "@/components/front/pages/other/Notifications";
import Products from "@/components/front/pages/products/Products";
import Stores from "@/components/front/pages/stores/Stores";
import Store from "@/components/front/pages/stores/Store";
import Cart from "@/components/front/pages/cart/Cart";
import Offers from "@/components/front/pages/Offers";
import Sections from "@/components/front/pages/Sections";
import Profile from "@/components/front/pages/account/Profile";
import Orders from "@/components/front/pages/account/Orders/Orders";
import Order from "@/components/front/pages/account/Orders/Order";
import UndertakingPage from "@/components/front/pages/account/Orders/UndertakingPage";
import Favorites from "@/components/front/pages/account/Favorites";
import Wallet from "@/components/front/pages/account/Wallet";
import Addresses from "@/components/front/pages/account/Addresses/Addresses";
import Edit from "@/components/front/pages/account/Edit";
import AddAddress from "@/components/front/pages/account/Addresses/AddAddress";
import EditAddress from "@/components/front/pages/account/Addresses/EditAddress";
import Product from "@/components/front/pages/products/Product";
import Popular from "@/components/front/pages/products/Popular";
import CityProducts from "@/components/front/pages/products/City";
import StoreOffers from "@/components/front/pages/stores/StoreOffers";
import StoreCategory from "@/components/front/pages/stores/StoreCategory";
import Search from "@/components/front/pages/products/Search";
import Section from "@/components/front/pages/products/Section";
import ContactTerms from "@/components/front/pages/other/ContactTerms";
import CompleteOrder from "@/components/front/pages/cart/CompleteOrder";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
        {
            path: '/',
            component: Home,
            name: 'home',
            replace: true,
            meta: {title: 'home'}
        },
        {
            path: '/about',
            component: About,
            name: 'about',
            meta: {title: 'aboutUs'}
        },
        {
            path: '/contact-us',
            component: ContactUs,
            name: 'contact-us',
            meta: {title: 'contactUs'}
        },
        {
            path: '/faqs',
            component: Faqs,
            name: 'faqs',
            meta: {title: 'faqs'}
        },
        {
            path: '/policy',
            component: Policy,
            name: 'policy',
            meta: {title: 'policy'}
        },
        {
            path: '/what-we-provide',
            component: WhatWeProvide,
            name: 'whatWeProvide',
            meta: {title: 'whatWeProvide'}
        },
        {
            path: '/terms-and-conditions',
            component: Terms,
            name: 'terms',
            meta: {title: 'terms'}
        },
        {
            path: '/products',
            component: Products,
            name: 'products',
            meta: {title: 'products'}
        },
        {
            path: '/stores',
            component: Stores,
            name: 'stores',
            meta: {title: 'stores'}
        },
        {
            path: '/shopping-cart',
            component: Cart,
            name: 'shopping-cart',
            meta: {title: 'shoppingCart'},
            beforeEnter: [isAuth],
        },
        {
            path: '/offers',
            component: Offers,
            name: 'offers',
            meta: {title: 'offers'}
        },
        {
            path: '/notifications',
            component: Notifications,
            name: 'notifications',
            meta: {title: 'notifications'},
            beforeEnter: [isAuth],
        },
        {
            path: '/profile',
            component: Profile,
            name: 'profile',
            meta: {title: 'profile'},
            beforeEnter: [isAuth],
        },
        {
            path: '/profile/orders',
            component: Orders,
            name: 'orders',
            meta: {title: 'myOrders'},
            beforeEnter: [isAuth]
        },
        {
            path: '/profile/favorites',
            component: Favorites,
            name: 'favorites',
            meta: {title: 'myFavorites'},
            beforeEnter: [isAuth]
        },
        {
            path: '/sections',
            component: Sections,
            name: 'sections',
            meta: {title: 'sections'}
        },
        {
            path: '/profile/wallet',
            component: Wallet,
            name: 'wallet',
            meta: {title: 'myWallet'},
            beforeEnter: [isAuth]
        },
        {
            path: '/profile/addresses',
            component: Addresses,
            name: 'addresses',
            meta: {title: 'myAddresses'},
            beforeEnter: [isAuth]
        },
        {
            path: '/profile/addresses/add',
            component: AddAddress,
            name: 'add-new-address',
            meta: {title: 'addNewAddress'},
            beforeEnter: [isAuth]
        },
        {
            path: '/profile/addresses/edit/:id/address',
            component: EditAddress,
            props: true,
            name: 'edit-address',
            meta: {title: 'editAddress'},
            beforeEnter: [isAuth]
        },
        {
            path: '/profile/edit',
            component: Edit,
            name: 'edit-profile',
            meta: {title: 'profileEdit'},
            beforeEnter: [isAuth],
        },
        {
            path: '/profile/orders/:order_no/order-details',
            component: Order,
            name: 'order',
            meta: {title: 'orderDetails'},
            beforeEnter: [isAuth, isOrderCanceled],
            props: true
        },
        {
            path: '/products/:id/product-details',
            component: Product,
            name: 'product-details',
            meta: {title: 'productDetails'}
        },
        {
            path: '/stores/:id/store-details',
            component: Store,
            name: 'store-details',
            props: true,
            meta: {title: 'storeDetails'}
        },
        {
            path: '/offers/:id/store',
            component: StoreOffers,
            name: 'store-offers',
            props: true,
            meta: {title: 'storeOffers'}
        },
        {
            path: '/stores/category/:id/products',
            component: StoreCategory,
            name: 'store-category',
            props: true,
            meta: {title: 'storeCategory'}
        },
        {
            path: '/products/:id/city',
            component: CityProducts,
            name: 'city-products',
            props: true,
            replace: true,
            meta: {title: 'cityProducts'}
        },
        {
            path: '/products/get/:id/section',
            component: Section,
            name: 'section-products',
            props: true,
            replace: true,
            meta: {title: 'sectionProducts'}
        },
        {
            path: '/products/get/popular',
            component: Popular,
            name: 'popular-products',
            props: true,
            replace: true,
            meta: {title: 'popularProducts'}
        },
        {
            path: '/search/:section_id/section/:term',
            component: Search,
            name: 'search',
            props: true,
            meta: {title: 'search'}
        },
        {
            path: '/contact-terms',
            component: ContactTerms,
            name: 'contact-terms',
            meta: {title: 'contactTerms'}
        },
        {
            path: '/complete-cart-order',
            component: CompleteOrder,
            name: 'complete-cart-order',
            meta: {title: 'completeCartOrder'},
            beforeEnter: [isAuth],
        },
        {
            path: '/profile/orders/:undertaking_id/undertaking',
            component: UndertakingPage,
            name: 'undertaking',
            meta: {title: 'undertakingPage'},
            beforeEnter: [isAuth],
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        // always scroll to top
        return { top: 0 }
    },
});

export default router;
