importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

firebase.initializeApp({
    apiKey: 'AIzaSyBvRs1aY6l7H5rahMuHXPUjiIRGQOroszk',
    authDomain: 'rental-248ee.firebaseapp.com',
    databaseURL: 'https://rental-248ee.firebaseio.com',
    projectId: 'rental-248ee',
    storageBucket: 'rental-248ee.appspot.com',
    messagingSenderId: '1088583078458',
    appId: '1:1088583078458:web:4b1cc34439b07dd0c79b03',
    measurementId: 'G-BKDWP6WKSZ',
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    // Customize notification here
    const notificationTitle = payload.notification.title;

    const notificationOptions = {
        body: payload.notification.body,
        icon: 'https://rental.sa/public/storage/uploaded/settings/setting_NHWZIpqytlsv_2023-04-13.jpg'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
