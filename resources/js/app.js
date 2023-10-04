import './bootstrap';

import webPush from './webPush';
window.webPush = webPush;

import.meta.glob(['../images/**',]);

window.addEventListener('load', function () {
    webPush.setupAll().then(result => {
        if (result) {
            console.log("webPush setup done");
        } else {
            console.log("unable to enable webPush");
        }
    });
})
