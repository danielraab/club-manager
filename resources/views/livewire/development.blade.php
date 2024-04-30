@php
    $hasAdminPermission = \Illuminate\Support\Facades\Auth::user()?->hasPermission(\App\Models\UserPermission::ADMIN_USER_PERMISSION) ?? false;
@endphp
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
    <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3" x-init="updateAll()" x-data="{
                info: webPush.info,
                async updateAll() {
                    this.info = (await webPush.checkAll());
                }
            }" @web-push-info-changed.document="updateAll()">
        <button class="ml-auto btn btn-secondary"
                x-on:click="await updateAll(); alert('done');">force param refresh
        </button>
        <ol class="text-sm p-2 text-gray-700">
            <li>
                <span class="font-bold">notification supported:</span>
                <span x-text="info.isNotificationSupported"></span>
            </li>
            <template x-if="info.isNotificationSupported">
                <li>
                    <ol class="mx-3 my-1">
                        <li>
                            <span class="font-bold">notification permission granted:</span>
                            <span x-text="info.notification.hasNotificationPermission"></span>
                        </li>
                        <li>
                            <span class="font-bold">notification api permission status:</span>
                            <span x-text="info.notification.notificationPermission"></span>
                        </li>
                    </ol>
                </li>
            </template>
            <li>
                <span class="font-bold">push managers supported:</span>
                <span x-text="info.isPushManagerSupported"></span>
            </li>
            <li>
                <span class="font-bold">service worker supported:</span>
                <span x-text="info.isServiceWorkerSupported"></span>
            </li>

            <template x-if="info.isServiceWorkerSupported">
                <li>
                    <ol class="mx-3 my-1">
                        <li>
                            <span class="font-bold">active service worker:</span>
                            <span x-text="info.serviceWorker.hasServiceWorker"></span>
                        </li>
                        <template x-if="info.serviceWorker.hasServiceWorker">
                            <li>
                                <span class="font-bold">service worker script url:</span>
                                <span x-text="info.serviceWorker.serviceWorkerUrl"></span>
                            </li>
                        </template>
                        <template x-if="info.serviceWorker.hasServiceWorker">
                            <li>
                                <span class="font-bold">service worker has pushManager:</span>
                                <span x-text="info.serviceWorker.pushManager.hasPushManager"></span>
                                <template x-if="info.serviceWorker.pushManager.hasPushManager">
                                    <ol class="mx-3 my-1">
                                        <li>
                                            <span class="font-bold">push manager has subscription:</span>
                                            <span
                                                x-text="info.serviceWorker.pushManager.subscription.hasSubscription"></span>
                                            <template
                                                x-if="info.serviceWorker.pushManager.subscription.hasSubscription">
                                                <ol class="mx-3 my-1">
                                                    <li>
                                                        <span class="font-bold">keys are matching:</span>
                                                        <span
                                                            x-text="info.serviceWorker.pushManager.subscription.serverKeyIsSameAsVapid"></span>
                                                    </li>
                                                    <li>
                                                        <span class="font-bold">key is on server:</span>
                                                        <span
                                                            x-text="info.serviceWorker.pushManager.subscription.server.isPushSubscriptionStored"></span>
                                                    </li>
                                                </ol>
                                            </template>
                                        </li>
                                    </ol>
                                </template>
                            </li>
                        </template>
                    </ol>
                </li>
            </template>
            <li>
                <span class="font-bold">stored vapid:</span>
                <div class="text-xs ml-5 break-all" x-text="info.storedVapidPublicKey"></div>
            </li>
            <li x-cloak x-init x-show="info.errors?.length">
                <span class="font-bold">web push errors:</span>
                <template x-for="error in info.errors">
                    <div class="text-xs" x-text="error"></div>
                </template>
            </li>
        </ol>
        <hr/>
        <div class="flex flex-col items-center gap-2">
            <button class="btn btn-danger" x-cloak
                    x-show="info.storedVapidPublicKey?.length > 0"
                    x-on:click="await webPush.vapid.setStoredVapidPublicKey('')">DELETE vapid key
            </button>
            <button class="btn btn-info" x-cloak
                    x-show="!(info.storedVapidPublicKey?.length > 0)"
                    x-on:click="await webPush.vapid.getVapidPublicKeyFromServer()">get vapid key
            </button>

            <button class="btn btn-primary"
                    :disabled="info.notification.hasNotificationPermission"
                    x-on:click="await webPush.notification.requestNotificationPermission()">request notification permission
            </button>

            <button class="btn btn-secondary" x-cloak
                    x-show="!info.serviceWorker.hasServiceWorker"
                    x-on:click="await webPush.serviceWorker.registerServiceWorker()">register service worker
            </button>

            <template x-if="info.serviceWorker.hasServiceWorker">
                <div class="flex flex-col items-center gap-2">
                    <button class="btn btn-danger"
                            x-on:click="await webPush.serviceWorker.unregisterServiceWorker()">UNregister service worker
                    </button>

                    <button class="btn btn-primary"
                            x-show="!info.serviceWorker.pushManager.subscription.hasSubscription"
                            x-on:click="await webPush.subscription.addPushSubscription()">add push subscription
                    </button>
                    <template x-if="info.serviceWorker.pushManager.subscription.hasSubscription">
                        <div class="flex flex-col items-center gap-2">
                            <button class="btn btn-danger"
                                    x-on:click="await webPush.subscription.removePushSubscription()">REMOVE push subscription
                            </button>
                            <button class="btn btn-danger"
                                    x-show="info.serviceWorker.pushManager.subscription.server.isPushSubscriptionStored"
                                    x-on:click="await webPush.server.removePushSubscription()">REMOVE subscription from server
                            </button>
                            <button class="btn btn-primary"
                                    x-show="!info.serviceWorker.pushManager.subscription.server.isPushSubscriptionStored"
                                    x-on:click="await webPush.server.storePushSubscription()">store subscription on server
                            </button>
                        </div>
                    </template>
                </div>
            </template>
        </div>
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
    @if($hasAdminPermission)
        <div class="shadow-xl shadow-black/5 sm:rounded-md bg-white p-3">
            <details open>
                <summary>Log files</summary>
                <ol class="text-sm p-2 text-gray-700 list-disc">
                    @foreach(\Illuminate\Support\Facades\File::allFiles("../storage/logs") as $file)
                        <li class="ml-4">
                            <button type="submit" class="underline"
                                    wire:click="download('{{$file->getPathname()}}')">{{$file->getFilename()}}</button>
                            <span class="text-xs text-gray-500">({{$file->getSize()}} B)</span>
                        </li>
                    @endforeach
                </ol>
            </details>
        </div>
    @endif
</div>
