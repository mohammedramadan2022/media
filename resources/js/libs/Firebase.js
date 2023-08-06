import {initializeApp} from "firebase/app";
import {getMessaging} from "firebase/messaging";

initializeApp({
    apiKey: "AIzaSyBvRs1aY6l7H5rahMuHXPUjiIRGQOroszk",
    authDomain: "rental-248ee.firebaseapp.com",
    projectId: "rental-248ee",
    storageBucket: "rental-248ee.appspot.com",
    messagingSenderId: "1088583078458",
    appId: "1:1088583078458:web:4b1cc34439b07dd0c79b03",
    measurementId: "G-BKDWP6WKSZ"
});

window.messaging = getMessaging();
