@props(['enabled' => 'false', 'onChanged'])

<button x-data="{enabled: {{$enabled}}}" x-on:click="enabled = !enabled; {{$onChanged}}(enabled)">
    <div class="pointer-events-auto h-6 w-10 rounded-full p-1 rings-1 ring-inset transition duration-200 ease-in-out"
         :class="enabled ? 'bg-indigo-600 ring-black/20' : 'bg-slate-900/10 ring-slate-900/5'">
        <div class="h-4 w-4 rounded-full bg-white shadow-sm ring-1 ring-slate-700/10 transition duration-200"
             :class="enabled ? 'ease-in-out translate-x-4' : 'ease-in-out'"></div>
    </div>
</button>
