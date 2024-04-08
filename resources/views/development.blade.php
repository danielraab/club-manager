<x-backend-layout>
    <x-slot name="headline">
        {{ __('Settings') }}
    </x-slot>

    <div class="sm:px-6 lg:px-8 flex flex-col md:grid grid-cols-2 gap-2">
        <section class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Common information') }}
                </h2>

                <dl class="divide-y divide-gray-100 text-sm p-2">
                    <div class="p-2">
                        <dt class="font-bold">Your IP</dt>
                        <dd class="text-gray-700">{{implode(', ', request()->ips())}}</dd>
                    </div>
                    <div class="p-2">
                        <dt class="font-bold">Your Browser</dt>
                        <dd class="text-gray-700">{{request()->userAgent()}}</dd>
                    </div>
                    <div class="p-2">
                        <dt class="font-bold">window inner screen Size</dt>
                        <dd class="text-gray-700" x-data="{text: window.innerWidth+' x '+window.innerHeight}"
                            x-on:resize.window="text= window.innerWidth+' x '+window.innerHeight"
                            x-text="text"></dd>
                    </div>
                    <div class="p-2">
                        <dt class="font-bold">window outer screen Size</dt>
                        <dd class="text-gray-700" x-data="{text: window.outerWidth+' x '+window.outerHeight}"
                            x-on:resize.window="text= window.outerWidth+' x '+window.outerHeight"
                            x-text="text"></dd>
                    </div>
                </dl>
            </header>
        </section>
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <details open>
                <summary>Web Push Notification Info</summary>
                <ol class="text-sm p-2 text-gray-700" x-init="webPush.setupAll(true)">
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': webPush.isBrowserReady,
                        'text-orange-700 fa-solid fa-triangle-exclamation': webPush.isBrowserReady === null,
                        'text-red-700 fa-solid fa-circle-xmark': webPush.isBrowserReady === false}"></i> is browser ready
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': Notification.permission === 'granted',
                        'text-orange-700 fa-solid fa-triangle-exclamation': Notification.permission === 'default',
                        'text-red-700 fa-solid fa-circle-xmark': Notification.permission === 'denied'}"></i> has notification permission
                        (<span class="text-gray-500" x-text="Notification.permission"></span>)
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': webPush.hasServiceWorker,
                        'text-orange-700 fa-solid fa-triangle-exclamation': webPush.hasServiceWorker === null,
                        'text-red-700 fa-solid fa-circle-xmark': webPush.hasServiceWorker === false}"></i> has service worker
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': webPush.hasPushSubscription,
                        'text-orange-700 fa-solid fa-triangle-exclamation': webPush.hasPushSubscription === null,
                        'text-red-700 fa-solid fa-circle-xmark': webPush.hasPushSubscription === false}"></i> has push subscription
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': webPush.isPushSubscriptionStored,
                        'text-orange-700 fa-solid fa-triangle-exclamation': webPush.isPushSubscriptionStored === null,
                        'text-red-700 fa-solid fa-circle-xmark': webPush.isPushSubscriptionStored === false}"></i> is push subscription stored
                    </li>
                    <li>
                        <span>is ready forced ?</span> - <span class="text-gray-500" x-text="webPush.forceIsReady ? 'yes': 'no'"></span>
                        <template x-if="webPush.forceIsReady"><span x-text="webPush.getLastCheckTimeStamp()"></span></template>
                    </li>
                    <li>
                        <span>is vapid public key stored ?</span> - <span class="text-gray-500" x-text="webPush.isVapidPublicKeyStored() ? 'yes': 'no'"></span>
                        <template x-if="webPush.isVapidPublicKeyStored"><span x-text="webPush.getStoredVapidPublicKey()"></span></template>
                    </li>

                </ol>
            </details>
        </div>
    </div>
</x-backend-layout>
