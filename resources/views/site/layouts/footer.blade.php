@php
$footerWidgets = data_get($widgets, \Modules\Widget\Enums\WidgetLocation::FOOTER, []);
@endphp

@include('site.partials.ads', ['ads' => $footerWidgets])

@include('site.layouts.footer.style_3', ['footerWidgets' => $footerWidgets])

