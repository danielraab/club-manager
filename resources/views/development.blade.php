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
                        <dt class="font-bold">App version</dt>
                        <dd class="text-gray-700">{{config('app.version')}} - {{config('app.deployDateTime')}}</dd>
                    </div>
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
                    <div class="p-2">
                        <dt class="font-bold">current browser time</dt>
                        <dd class="text-gray-700" x-init x-text="(new Date())"></dd>
                    </div>
                    <div class="p-2">
                        <dt class="font-bold">current server time</dt>
                        <dd class="text-gray-700 text-xs">{{(new \Carbon\Carbon())->formatDateTimeWithSec()}}</dd>
                    </div>
                    <div class="p-2">
                        <dt class="font-bold">timezone</dt>
                        <dd class="text-gray-700">{{config('app.displayed_timezone')}}</dd>
                    </div>
                </dl>
            </header>
        </section>
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <script>
                function initWebPush() {
                    return {
                        forceIsReady: null,
                        isBrowserReady: null,
                        hasServiceWorker: null,
                        hasPushSubscription: null,
                        isPushSubscriptionStored: null,
                        init() {
                            webPush.setupAll(true);
                        },
                        updateFlags() {
                            this.forceIsReady = webPush.forceIsReady;
                            this.isBrowserReady = webPush.isBrowserReady;
                            this.hasServiceWorker = webPush.hasServiceWorker;
                            this.hasPushSubscription = webPush.hasPushSubscription;
                            this.isPushSubscriptionStored = webPush.isPushSubscriptionStored;
                        }
                    }
                }
            </script>
            <details open>
                <summary>Web Push Notification Info</summary>
                <div class="mx-2 mt-3">
                    <span>Legend: </span>
                    <i class='text-green-700 fa-solid fa-circle-check'></i> Passed
                    <i class='text-orange-700 fa-solid fa-triangle-exclamation'></i> Not Checked
                    <i class='text-red-700 fa-solid fa-circle-xmark'></i> Failed
                </div>
                <ol class="text-sm p-2 text-gray-700" x-data="initWebPush()"
                    x-on:webpush-setup-finished.window="updateFlags">
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': Notification.permission === 'granted',
                        'text-orange-700 fa-solid fa-triangle-exclamation': Notification.permission === 'default',
                        'text-red-700 fa-solid fa-circle-xmark': Notification.permission === 'denied'}"></i> has
                        notification permission
                        (<span class="text-gray-500" x-text="Notification.permission"></span>)
                    </li>
                    <li x-data="{serviceWorkerSupported: ('serviceWorker' in navigator)}">
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': serviceWorkerSupported,
                        'text-red-700 fa-solid fa-circle-xmark': serviceWorkerSupported === false}"></i> are service
                        worker supported by your browser
                    </li>
                    <li x-data="{pushManagerSupported: ('PushManager' in window)}">
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': pushManagerSupported,
                        'text-red-700 fa-solid fa-circle-xmark': pushManagerSupported === false}"></i> is the push
                        manager supported by your browser
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': isBrowserReady,
                        'text-orange-700 fa-solid fa-triangle-exclamation': isBrowserReady === null,
                        'text-red-700 fa-solid fa-circle-xmark': isBrowserReady === false}"></i> is browser ready
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': forceIsReady,
                        'text-red-700 fa-solid fa-circle-xmark': forceIsReady === false}"></i> checked is cached
                        <template x-if="forceIsReady"><span class="text-xs"
                                                            x-text="'('+(new Date(Number(webPush.getLastCheckTimeStamp())))+')'"></span>
                        </template>
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': hasServiceWorker,
                        'text-orange-700 fa-solid fa-triangle-exclamation': hasServiceWorker === null,
                        'text-red-700 fa-solid fa-circle-xmark': hasServiceWorker === false}"></i> has service worker
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': hasPushSubscription,
                        'text-orange-700 fa-solid fa-triangle-exclamation': hasPushSubscription === null,
                        'text-red-700 fa-solid fa-circle-xmark': hasPushSubscription === false}"></i> has push
                        subscription
                    </li>
                    <li>
                        <i :class="{
                        'text-green-700 fa-solid fa-circle-check': isPushSubscriptionStored,
                        'text-orange-700 fa-solid fa-triangle-exclamation': isPushSubscriptionStored === null,
                        'text-red-700 fa-solid fa-circle-xmark': isPushSubscriptionStored === false}"></i> is push
                        subscription stored
                    </li>
                    <li>
                        <i x-data="{isVapidKeyStored: webPush.isVapidPublicKeyStored()}" :class="{
                        'text-green-700 fa-solid fa-circle-check': isVapidKeyStored,
                        'text-orange-700 fa-solid fa-triangle-exclamation': isVapidKeyStored === null,
                        'text-red-700 fa-solid fa-circle-xmark': isVapidKeyStored === false}"></i>
                        <span>is vapid public key stored</span>
                        <template x-if="webPush.isVapidPublicKeyStored">
                            <div class="text-xs ml-5 break-all" x-text="webPush.getStoredVapidPublicKey()"></div>
                        </template>
                    </li>
                </ol>
            </details>
        </div>
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <details open>
                <summary>PHP (env) config</summary>
                <ol class="text-sm p-2 text-gray-700">
                    @foreach(['app.name', 'app.env', 'app.debug', 'app.url', 'app.displayed_timezone',
                                'app.locale', 'app.currency', 'logging.default', 'session.driver',
                                'session.lifetime','session.expire_on_close', 'session.encrypt'] as $configKey)
                        <li>
                            <span class="font-bold">{{$configKey}}:</span>
                            <pre class="inline">"{{config($configKey)}}"</pre>
                        </li>
                    @endforeach
                </ol>
            </details>
        </div>
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <details open>
                <summary>Global DB configuration settings</summary>
                <ol class="text-sm p-2 text-gray-700">
                    @foreach(\App\Models\Configuration::query()->whereNull('user_id')->get() as $config)
                        <li>
                            <span class="font-bold">{{\App\Models\ConfigurationKey::from($config->key)->name}}:</span>
                            <pre class="inline">"{{$config->value}}"</pre>
                        </li>
                    @endforeach
                </ol>
            </details>
        </div>
        @if($id = auth()->id())
            <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
                <details open>
                    <summary>Your user specific DB configuration settings</summary>
                    <ol class="text-sm p-2 text-gray-700">
                        @foreach(\App\Models\Configuration::query()->where('user_id', $id)->get() as $config)
                            <li>
                                <span
                                    class="font-bold">{{\App\Models\ConfigurationKey::from($config->key)->name}}:</span>
                                <pre class="inline">"{{$config->value}}"</pre>
                            </li>
                        @endforeach
                    </ol>
                </details>
            </div>
        @endif
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <details open>
                <summary>Log files</summary>
                <ol class="text-sm p-2 text-gray-700 list-disc">
                    @foreach(\Illuminate\Support\Facades\File::allFiles("../storage/logs") as $file)
                        <li class="ml-4">
                            <button type="submit" class="underline" >{{$file->getFilename()}}</button>
{{--                            <button type="submit" class="underline" wire:click="download({{$file->getPath()}})">{{$file->getFilename()}}</button>--}}
                            <span class="text-xs text-gray-500">({{$file->getSize()}} B)</span>
                        </li>
                    @endforeach
                </ol>
            </details>
        </div>
    </div>
</x-backend-layout>
