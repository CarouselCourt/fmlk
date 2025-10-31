<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    header('Permissions-Policy: interest-cohort=()');
    ?>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (config('lorekeeper.extensions.use_recaptcha'))
        <!-- ReCaptcha v3 -->
        {!! RecaptchaV3::initJs() !!}
    @endif

    <title>{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}{!! View::hasSection('title') ? ' - ' . trim(View::getSection('title')) : '' !!}</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}{!! View::hasSection('title') ? ' - ' . trim(View::getSection('title')) : '' !!}">
    <meta name="description" content="{!! View::hasSection('meta-desc') ? trim(strip_tags(View::getSection('meta-desc'))) : config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') !!}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url', 'http://localhost') }}">
    <meta property="og:image" content="{{ View::hasSection('meta-img') ? View::getSection('meta-img') : asset('images/meta-image.png') }}">
    <meta property="og:title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}{!! View::hasSection('title') ? ' - ' . trim(View::getSection('title')) : '' !!}">
    <meta property="og:description" content="{!! View::hasSection('meta-desc') ? trim(strip_tags(View::getSection('meta-desc'))) : config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') !!}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ config('app.url', 'http://localhost') }}">
    <meta property="twitter:image" content="{{ View::hasSection('meta-img') ? View::getSection('meta-img') : asset('images/meta-image.png') }}">
    <meta property="twitter:title" content="{{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}{!! View::hasSection('title') ? ' - ' . trim(View::getSection('title')) : '' !!}">
    <meta property="twitter:description" content="{!! View::hasSection('meta-desc') ? trim(strip_tags(View::getSection('meta-desc'))) : config('lorekeeper.settings.site_desc', 'A Lorekeeper ARPG') !!}">

    <!-- No AI scraping directives -->
    <meta name="robots" content="noai">
    <meta name="robots" content="noimageai">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/site.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('js/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tinymce.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('js/selectize.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-timepicker-addon.js') }}"></script>
    <script src="{{ asset('js/croppie.min.js') }}"></script>
    <script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>

    <!-- Scripts for wheel of fortune dailies -->
    <script src="{{ asset('js/winwheel.min.js') }}"></script>
    <script src="{{ asset('js/tweenmax.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- ALTERNATE SITE FONTS  -->
    <!--- Find more fonts on: https://fonts.google.com/ --->
    <link href="https://fonts.googleapis.com/css2?family=Lora" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Arvo" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Wellfleet" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Concert+One" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Tangerine" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Philosopher" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lorekeeper.css?v=' . filemtime(public_path('css/lorekeeper.css'))) }}" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    {{-- jQuery UI --}}
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">

    {{-- Bootstrap Toggle --}}
    <link href="{{ asset('css/bootstrap4-toggle.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui-timepicker-addon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/croppie.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.bootstrap4.css') }}" rel="stylesheet">

    @if (file_exists(public_path() . '/css/custom.css'))
        <link href="{{ asset('css/custom.css') . '?v=' . filemtime(public_path('css/custom.css')) }}" rel="stylesheet">
    @endif

    @php
    $design = App\Models\SiteDesign::all()->first();
    @endphp

    <!-- ALTERNATE SITE LAYOUTS -->
    @isset($design)
    <link href="{{ asset('css/'. $design->design .'.css') }}" rel="stylesheet">
    @endisset

    <!--Editable font css-->
    @include('layouts.editable_fonts') 

    <!-- THEME MANAGER -->
    @if (isset($theme) && $theme?->prioritize_css)
        @include('layouts.editable_theme')
    @endif
    @if (isset($theme) && $theme?->has_css)
        <style type="text/css" media="screen">
            @php include_once($theme?->cssUrl)
            @endphp
            {{-- css in style tag so that order matters --}}
        </style>
    @endif
    @if (isset($theme) && !$theme?->prioritize_css)
        @include('layouts.editable_theme')
    @endif

    {{-- Conditional Themes are dependent on other site features --}}
    @if (isset($conditionalTheme) && $conditionalTheme?->prioritize_css)
        @include('layouts.editable_theme', ['theme' => $conditionalTheme])
    @endif
    @if (isset($conditionalTheme) && $conditionalTheme?->has_css)
        <style type="text/css" media="screen">
            @php include_once($conditionalTheme?->cssUrl)
            @endphp
            {{-- css in style tag so that order matters --}}
        </style>
    @endif
    @if (isset($conditionalTheme) && !$conditionalTheme?->prioritize_css)
        @include('layouts.editable_theme', ['theme' => $conditionalTheme])
    @endif

    @if (isset($decoratorTheme) && $decoratorTheme?->prioritize_css)
        @include('layouts.editable_theme', ['theme' => $decoratorTheme])
    @endif
    @if (isset($decoratorTheme) && $decoratorTheme?->has_css)
        <style type="text/css" media="screen">
            @php include_once($decoratorTheme?->cssUrl)
            @endphp
            {{-- css in style tag so that order matters --}}
        </style>
    @endif
    @if (isset($decoratorTheme) && !$decoratorTheme?->prioritize_css)
        @include('layouts.editable_theme', ['theme' => $decoratorTheme])
    @endif

    @include('feed::links')
</head>

<body>
    <div id="app">
        <div class="site-header-image" id="header" style="background-image: url('{{ $decoratorTheme?->headerImageUrl ?? ($conditionalTheme?->headerImageUrl ?? ($theme?->headerImageUrl ?? asset('images/header.png'))) }}');"></div>
        @include('layouts._nav')
        @if (View::hasSection('sidebar'))
            <div class="site-mobile-header bg-secondary"><a href="#" class="btn btn-sm btn-outline-light" id="mobileMenuButton">Menu <i class="fas fa-caret-right ml-1"></i></a></div>
        @endif

        <main class="container-fluid" id="main">
            <div class="row">

                <div class="sidebar col-lg-2" id="sidebar">
                    @yield('sidebar')
                </div>
                <div class="main-content col-lg-8 p-4">
                    <div>
                        @if (Settings::get('is_maintenance_mode'))
                            <div class="alert alert-secondary">
                                The site is currently in maintenance mode!
                                @if (!Auth::check() || !Auth::user()->hasPower('maintenance_access'))
                                    You can browse public content, but cannot make any submissions.
                                @endif
                            </div>
                        @endif
                        @if (Auth::check() && !config('lorekeeper.extensions.navbar_news_notif'))
                            @if (Auth::user()->is_news_unread)
                                <div class="alert alert-info"><a href="{{ url('news') }}">There is a new news post!</a></div>
                            @endif
                            @if (Auth::user()->is_sales_unread)
                                <div class="alert alert-info"><a href="{{ url('sales') }}">There is a new sales post!</a></div>
                            @endif
                        @endif
                        @include('flash::message')
                        @yield('content')
                    </div>

                    <div class="site-footer mt-4" id="footer">
                        @include('layouts._footer')
                    </div>
                </div>
            </div>

        </main>


        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0"></span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>

        @yield('scripts')
        @include('layouts._pagination_js')
        <script>
            $(document).on('focusin', function(e) {
                if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
                    e.stopImmediatePropagation();
                }
            });

            $(function() {
                $('[data-toggle="tooltip"]').tooltip({
                    html: true
                });

                class BlurValid extends $.colorpicker.Extension {
                    constructor(colorpicker, options = {}) {
                        super(colorpicker, options);

                        if (this.colorpicker.inputHandler.hasInput()) {
                            const onBlur = function(colorpicker, fallback) {
                                return () => {
                                    colorpicker.setValue(colorpicker.blurFallback._original.color);
                                }
                            };
                            this.colorpicker.inputHandler.input[0].addEventListener('blur', onBlur(this.colorpicker));
                        }
                    }

                    onInvalid(e) {
                        const color = this.colorpicker.colorHandler.getFallbackColor();
                        if (color._original.valid)
                            this.colorpicker.blurFallback = color;
                    }
                }

                $.colorpicker.extensions.blurvalid = BlurValid;
                console.log($['colorpicker'].extensions);

                $('.cp').colorpicker({
                    'autoInputFallback': false,
                    'autoHexInputFallback': false,
                    'format': 'auto',
                    'useAlpha': true,
                    extensions: [{
                        name: 'blurValid'
                    }]
                });
                
                tinymce.init({
                    selector: '.wysiwyg',
                    height: 500,
                    menubar: false,
                    convert_urls: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen spoiler',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
                    content_css: [
                        '{{ asset('css/app.css') }}',
                        '{{ asset('css/lorekeeper.css?v=' . filemtime(public_path('css/lorekeeper.css'))) }}',
                        {!! file_exists(public_path() . '/css/custom.css') ? "'" . asset('css/custom.css?v=') . filemtime(public_path('css/custom.css')) . "'," : '' !!}
                        {!! $theme?->cssUrl ? "'" . asset($theme?->cssUrl) . "'," : '' !!}
                        {!! $conditionalTheme?->cssUrl ? "'" . asset($conditionalTheme?->cssUrl) . "'," : '' !!}
                        {!! $decoratorTheme?->cssUrl ? "'" . asset($decoratorTheme?->cssUrl) . "'," : '' !!} '{{ asset('css/all.min.css') }}' //fontawesome
                    ],
                    content_style: `
                        {!! str_replace(['<style>', '</style>'], '', view('layouts.editable_theme', ['theme' => $theme])) !!}
                        {!! isset($conditionalTheme) && $conditionalTheme ? str_replace(['<style>', '</style>'], '', view('layouts.editable_theme', ['theme' => $conditionalTheme])) : '' !!}
                        {!! isset($decoratorTheme) && $decoratorTheme ? str_replace(['<style>', '</style>'], '', view('layouts.editable_theme', ['theme' => $decoratorTheme])) : '' !!}
                    `,
                    spoiler_caption: 'Toggle Spoiler',
                    target_list: false
                });
                bsCustomFileInput.init();
                var $mobileMenuButton = $('#mobileMenuButton');
                var $sidebar = $('#sidebar');
                $('#mobileMenuButton').on('click', function(e) {
                    e.preventDefault();
                    $sidebar.toggleClass('active');
                });

                $('.inventory-log-stack').on('click', function(e) {
                    e.preventDefault();
                    loadModal("{{ url('items') }}/" + $(this).data('id') + "?read_only=1", $(this).data('name'));
                });

                $('.spoiler-text').hide();
                $('.spoiler-toggle').click(function() {
                    $(this).next().toggle();
                });
            });
        </script>
    </div>
</body>

</html>
