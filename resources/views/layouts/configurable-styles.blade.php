{{-- style block for configurable (via db settings) colors and other styles --}}
<style>
    .bg-nav {
        background-color: {{ \App\Models\Configuration::getString(\App\Models\ConfigurationKey::STYLE_NAV_BACKGROUND_C, null, "white") }};
    }
    .bg-nav:active {
        background-color: {{ \App\Models\Configuration::getString(\App\Models\ConfigurationKey::STYLE_NAV_BACKGROUND_C, null, "rgb(226, 232, 255)") }};
    }
    .text-nav {
        background-color: {{ \App\Models\Configuration::getString(\App\Models\ConfigurationKey::STYLE_NAV_TEXT_C, null, "rgb(75, 85, 99)") /*text-gray-600*/ }};
    }
    {{-- TODO add active and hover --}}
</style>
