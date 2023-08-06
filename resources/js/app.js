import './bootstrap';

import webPush from './webPush';
window.webPush = webPush;

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

Alpine.plugin(persist)
window.Alpine = Alpine;
Alpine.start();

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
