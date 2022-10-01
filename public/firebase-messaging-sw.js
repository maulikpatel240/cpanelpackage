importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

firebase.initializeApp({
    apiKey: "AIzaSyAomfeAwSjzSqLZnq2-9lY7YpkmjrXFgkU",
    authDomain: "vandemission-98da0.firebaseapp.com",
    projectId: "vandemission-98da0",
    storageBucket: "vandemission-98da0.appspot.com",
    messagingSenderId: "655157812442",
    appId: "1:655157812442:web:611d3e66091794662ad9e3",
    measurementId: "G-NGKBM04VKN"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({
    data: { title, body, icon },
}) {
    return self.registration.showNotification(title, { body, icon });
});