import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import sort from '@alpinejs/sort';
Alpine.plugin(sort);

import webPush from './webPush';
window.webPush = webPush;


import.meta.glob(['../images/**',]);

Livewire.start()
