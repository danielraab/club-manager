import './bootstrap';

import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css'; // optional for styling

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import sort from '@alpinejs/sort';
Alpine.plugin(sort);

Alpine.directive('clipboard', (el, {}, { cleanup }) => {
    let text = el.textContent

    const handler = () => {
        navigator.clipboard.writeText(text)
    }

    el.addEventListener('click', handler)
    cleanup(() => {
        el.removeEventListener('click', handler)
    })
});

tippy.setDefaultProps({trigger: 'mouseenter click'});
Alpine.directive('tippy', (el, { modifiers, expression }, { cleanup }) => {
    let content = '';
    let placement = 'bottom';
    if(expression) {
        content = expression;
    } else if(el.hasAttribute('title')) {
        content = el.title;
    }

    modifiers.forEach((modifier) => {
        switch (modifier) {
            case 'top':
            case 'top-start':
            case 'top-end':
            case 'right':
            case 'right-start':
            case 'right-end':
            case 'bottom':
            case 'bottom-start':
            case 'bottom-end':
            case 'left':
            case 'left-start':
            case 'left-end':
            case 'auto':
            case 'auto-start':
            case 'auto-end':
                placement = modifier;
        }
    });

    const instance = tippy(el, {
        content,
        arrow: true,
        placement
    })
    cleanup(() => {
        instance.destroy();
    })
});

import webPush from './webPush';
window.webPush = webPush;

import.meta.glob(['../images/**',]);

Livewire.start()
