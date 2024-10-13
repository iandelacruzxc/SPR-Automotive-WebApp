<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
        .carousel-wrapper {
            width: 100%;
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel-item {
            flex: 0 0 auto;
            width: 25%;
            /* Show 4 cards at a time */
        }

        /* Indicator dots */
        .dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .dot.active {
            background-color: #717171;
        }

        /* Button hover styling */
        .group:hover .carousel-btn {
            opacity: 1;
        }


        /* ! tailwindcss v3.4.1 | MIT License | https://tailwindcss.com */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after,
        ::before {
            --tw-content: ''
        }

        :host,
        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        pre,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-feature-settings: normal;
            font-variation-settings: normal;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        [type=button],
        [type=reset],
        [type=submit],
        button {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dd,
        dl,
        figure,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu,
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        dialog {
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button],
        button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden] {
            display: none
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        .absolute {
            position: absolute
        }

        .relative {
            position: relative
        }

        .-left-20 {
            left: -5rem
        }

        .top-0 {
            top: 0px
        }

        .-bottom-16 {
            bottom: -4rem
        }

        .-left-16 {
            left: -4rem
        }

        .-mx-3 {
            margin-left: -0.75rem;
            margin-right: -0.75rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .mt-6 {
            margin-top: 1.5rem
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .aspect-video {
            aspect-ratio: 16 / 9
        }

        .size-12 {
            width: 3rem;
            height: 3rem
        }

        .size-5 {
            width: 1.25rem;
            height: 1.25rem
        }

        .size-6 {
            width: 1.5rem;
            height: 1.5rem
        }

        .h-12 {
            height: 3rem
        }

        .h-40 {
            height: 10rem
        }

        .h-full {
            height: 100%
        }

        .min-h-screen {
            min-height: 100vh
        }

        .w-full {
            width: 100%
        }

        .w-\[calc\(100\%\+8rem\)\] {
            width: calc(100% + 8rem)
        }

        .w-auto {
            width: auto
        }

        .max-w-\[877px\] {
            max-width: 877px
        }

        .max-w-2xl {
            max-width: 42rem
        }

        .flex-1 {
            flex: 1 1 0%
        }

        .shrink-0 {
            flex-shrink: 0
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr))
        }

        .flex-col {
            flex-direction: column
        }

        .items-start {
            align-items: flex-start
        }

        .items-center {
            align-items: center
        }

        .items-stretch {
            align-items: stretch
        }

        .justify-end {
            justify-content: flex-end
        }

        .justify-center {
            justify-content: center
        }

        .gap-2 {
            gap: 0.5rem
        }

        .gap-4 {
            gap: 1rem
        }

        .gap-6 {
            gap: 1.5rem
        }

        .self-center {
            align-self: center
        }

        .overflow-hidden {
            overflow: hidden
        }

        .rounded-\[10px\] {
            border-radius: 10px
        }

        .rounded-full {
            border-radius: 9999px
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-md {
            border-radius: 0.375rem
        }

        .rounded-sm {
            border-radius: 0.125rem
        }

        .bg-\[\#FF2D20\]\/10 {
            background-color: rgb(255 45 32 / 0.1)
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .bg-gradient-to-b {
            background-image: linear-gradient(to bottom, var(--tw-gradient-stops))
        }

        .from-transparent {
            --tw-gradient-from: transparent var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(0 0 0 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .via-white {
            --tw-gradient-to: rgb(255 255 255 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), #fff var(--tw-gradient-via-position), var(--tw-gradient-to)
        }

        .to-white {
            --tw-gradient-to: #fff var(--tw-gradient-to-position)
        }

        .stroke-\[\#FF2D20\] {
            stroke: #FF2D20
        }

        .object-cover {
            object-fit: cover
        }

        .object-top {
            object-position: top
        }

        .p-6 {
            padding: 1.5rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem
        }

        .py-16 {
            padding-top: 4rem;
            padding-bottom: 4rem
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem
        }

        .pt-3 {
            padding-top: 0.75rem
        }

        .text-center {
            text-align: center
        }

        .font-sans {
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .text-sm\/relaxed {
            font-size: 0.875rem;
            line-height: 1.625
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .font-semibold {
            font-weight: 600
        }

        .text-black {
            --tw-text-opacity: 1;
            color: rgb(0 0 0 / var(--tw-text-opacity))
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .underline {
            -webkit-text-decoration-line: underline;
            text-decoration-line: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .shadow-\[0px_14px_34px_0px_rgba\(0\2c 0\2c 0\2c 0\.08\)\] {
            --tw-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            --tw-shadow-colored: 0px 14px 34px 0px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .ring-1 {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
        }

        .ring-transparent {
            --tw-ring-color: transparent
        }

        .ring-white\/\[0\.05\] {
            --tw-ring-color: rgb(255 255 255 / 0.05)
        }

        .drop-shadow-\[0px_4px_34px_rgba\(0\2c 0\2c 0\2c 0\.06\)\] {
            --tw-drop-shadow: drop-shadow(0px 4px 34px rgba(0, 0, 0, 0.06));
            filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)
        }

        .drop-shadow-\[0px_4px_34px_rgba\(0\2c 0\2c 0\2c 0\.25\)\] {
            --tw-drop-shadow: drop-shadow(0px 4px 34px rgba(0, 0, 0, 0.25));
            filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)
        }

        .transition {
            transition-property: color, background-color, border-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .duration-300 {
            transition-duration: 300ms
        }

        .selection\:bg-\[\#FF2D20\] *::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(255 45 32 / var(--tw-bg-opacity))
        }

        .selection\:text-white *::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .selection\:bg-\[\#FF2D20\]::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(255 45 32 / var(--tw-bg-opacity))
        }

        .selection\:text-white::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .hover\:text-black:hover {
            --tw-text-opacity: 1;
            color: rgb(0 0 0 / var(--tw-text-opacity))
        }

        .hover\:text-black\/70:hover {
            color: rgb(0 0 0 / 0.7)
        }

        .hover\:ring-black\/20:hover {
            --tw-ring-color: rgb(0 0 0 / 0.2)
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px
        }

        .focus-visible\:ring-1:focus-visible {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
        }

        .focus-visible\:ring-\[\#FF2D20\]:focus-visible {
            --tw-ring-opacity: 1;
            --tw-ring-color: rgb(255 45 32 / var(--tw-ring-opacity))
        }

        @media (min-width: 640px) {
            .sm\:size-16 {
                width: 4rem;
                height: 4rem
            }

            .sm\:size-6 {
                width: 1.5rem;
                height: 1.5rem
            }

            .sm\:pt-5 {
                padding-top: 1.25rem
            }
        }

        @media (min-width: 768px) {
            .md\:row-span-3 {
                grid-row: span 3 / span 3
            }
        }

        @media (min-width: 1024px) {
            .lg\:col-start-2 {
                grid-column-start: 2
            }

            .lg\:h-16 {
                height: 4rem
            }

            .lg\:max-w-7xl {
                max-width: 80rem
            }

            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .lg\:flex-col {
                flex-direction: column
            }

            .lg\:items-end {
                align-items: flex-end
            }

            .lg\:justify-center {
                justify-content: center
            }

            .lg\:gap-8 {
                gap: 2rem
            }

            .lg\:p-10 {
                padding: 2.5rem
            }

            .lg\:pb-10 {
                padding-bottom: 2.5rem
            }

            .lg\:pt-0 {
                padding-top: 0px
            }

            .lg\:text-\[\#FF2D20\] {
                --tw-text-opacity: 1;
                color: rgb(255 45 32 / var(--tw-text-opacity))
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:block {
                display: block
            }

            .dark\:hidden {
                display: none
            }

            .dark\:bg-black {
                --tw-bg-opacity: 1;
                background-color: rgb(0 0 0 / var(--tw-bg-opacity))
            }

            .dark\:bg-zinc-900 {
                --tw-bg-opacity: 1;
                background-color: rgb(24 24 27 / var(--tw-bg-opacity))
            }

            .dark\:via-zinc-900 {
                --tw-gradient-to: rgb(24 24 27 / 0) var(--tw-gradient-to-position);
                --tw-gradient-stops: var(--tw-gradient-from), #18181b var(--tw-gradient-via-position), var(--tw-gradient-to)
            }

            .dark\:to-zinc-900 {
                --tw-gradient-to: #18181b var(--tw-gradient-to-position)
            }

            .dark\:text-white\/50 {
                color: rgb(255 255 255 / 0.5)
            }

            .dark\:text-white {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .dark\:text-white\/70 {
                color: rgb(255 255 255 / 0.7)
            }

            .dark\:ring-zinc-800 {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(39 39 42 / var(--tw-ring-opacity))
            }

            .dark\:hover\:text-white:hover {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .dark\:hover\:text-white\/70:hover {
                color: rgb(255 255 255 / 0.7)
            }

            .dark\:hover\:text-white\/80:hover {
                color: rgb(255 255 255 / 0.8)
            }

            .dark\:hover\:ring-zinc-700:hover {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(63 63 70 / var(--tw-ring-opacity))
            }

            .dark\:focus-visible\:ring-\[\#FF2D20\]:focus-visible {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(255 45 32 / var(--tw-ring-opacity))
            }

            .dark\:focus-visible\:ring-white:focus-visible {
                --tw-ring-opacity: 1;
                --tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity))
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <header>
        <h1>@yield('header')</h1>
    </header>
    <main>
        <nav class="bg-gray-800 text-white p-4">
            <div class="container mx-auto flex items-center justify-between">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold">MyLogo</a>
                </div>
                <!-- Navigation Tabs -->
                {{-- <div class="space-x-4">
                <a href="/" class="hover:text-gray-400">Home</a>
                <a href="/about" class="hover:text-gray-400">About</a>
                <a href="/services" class="hover:text-gray-400">Services</a>
                <a href="/contact" class="hover:text-gray-400">Contact</a>
            </div> --}}
            </div>
        </nav>
        <div class="container mx-auto p-4">
            <!-- Main Banner -->
            <section class="relative bg-cover bg-center h-96"
                style="background-image: url('https://via.placeholder.com/1500x600');">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="relative container mx-auto flex items-center justify-center h-full">
                    <div class="text-center text-white px-4">
                        <h1 class="text-4xl font-bold mb-4">Welcome to Our Website</h1>
                        <p class="text-lg mb-6">Discover amazing content and features designed just for you.</p>
                        <a href="#learn-more"
                            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Learn More</a>
                    </div>
                </div>
            </section>
            <!-- End Main Banner -->
            <!-- Carousel for product 1 -->
            <section class="my-8 relative group">
                <div class=" mb-4">
                    <h2 class="text-2xl font-bold">Featured Products</h2> <!-- Change text accordingly -->
                </div>
                <div class="carousel-wrapper relative overflow-hidden">
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                        <!-- Carousel Items -->
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 1"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 1</h3>
                                <p class="text-sm mt-2">Description for card 1.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 2"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 2</h3>
                                <p class="text-sm mt-2">Description for card 2.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 3"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 3</h3>
                                <p class="text-sm mt-2">Description for card 3.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 4"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 4</h3>
                                <p class="text-sm mt-2">Description for card 4.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 5"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 5</h3>
                                <p class="text-sm mt-2">Description for card 5.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Carousel Controls -->
                <button
                    class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    id="prevBtn">&#10094;</button>
                <button
                    class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    id="nextBtn">&#10095;</button>

                <!-- Indicators (dynamic dots will be inserted here) -->
                <div class="flex justify-center mt-4 indicator-container">
                    <!-- Dynamic dots will be generated by JavaScript -->
                </div>
            </section>
            <!-- Carousel for product 2 -->
            <section class="my-8 relative group">
                <div class=" mb-4">
                    <h2 class="text-2xl font-bold">Featured Products</h2> <!-- Change text accordingly -->
                </div>
                <div class="carousel-wrapper relative overflow-hidden">
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                        <!-- Carousel Items -->
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 1"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 1</h3>
                                <p class="text-sm mt-2">Description for card 1.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 2"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 2</h3>
                                <p class="text-sm mt-2">Description for card 2.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 3"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 3</h3>
                                <p class="text-sm mt-2">Description for card 3.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 4"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 4</h3>
                                <p class="text-sm mt-2">Description for card 4.</p>
                            </div>
                        </div>
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="https://via.placeholder.com/256x160" alt="Image 5"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Card 5</h3>
                                <p class="text-sm mt-2">Description for card 5.</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Carousel Controls -->
                <button
                    class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    id="prevBtn">&#10094;</button>
                <button
                    class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    id="nextBtn">&#10095;</button>

                <!-- Indicators (dynamic dots will be inserted here) -->
                <div class="flex justify-center mt-4 indicator-container">
                    <!-- Dynamic dots will be generated by JavaScript -->
                </div>
            </section>
            <!-- About Us Section -->
            <section class="my-12">
                <div class="flex flex-col md:flex-row items-center">
                    <!-- Left Side: Image -->
                    <div class="w-full md:w-1/2 mb-8 md:mb-0">
                        <img src="https://via.placeholder.com/400x400" alt="Company Image"
                            class="w-full h-auto rounded-lg shadow-lg object-cover">
                    </div>
                    <!-- Right Side: Company Info -->
                    <div class="w-full md:w-1/2 md:pl-8">
                        <h2 class="text-3xl font-bold mb-4">About Our Company</h2>
                        <p class="text-lg mb-6">
                            We are a leading company in the industry, dedicated to providing top-notch services and
                            innovative solutions to our customers.
                        </p>
                        <p class="text-lg mb-6">
                            With years of experience and a commitment to excellence, we have established ourselves as a
                            trusted name in the market.
                        </p>
                        <p class="text-lg">
                            Our vision is to continue growing and evolving with the times, always keeping our customers
                            at the heart of everything we do.
                        </p>
                    </div>
                </div>
            </section>
            <!-- End About Us Section -->
        </div>
    </main>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        $(document).ready(function() {
            let currentIndex = 0;
            const itemsPerView = 4; // Number of visible cards at a time
            const totalItems = $('.carousel-item').length;
            const totalPages = Math.ceil(totalItems / itemsPerView);

            // Dynamically create dots based on total pages
            for (let i = 0; i < totalPages; i++) {
                $('.indicator-container').append(
                    `<span class="dot w-3 h-3 bg-gray-400 rounded-full mx-1 cursor-pointer" data-slide="${i}"></span>`
                );
            }

            // Update carousel function
            function updateCarousel() {
                const offset = -(currentIndex * 100) / itemsPerView;
                $('.carousel-track').css('transform', `translateX(${offset}%)`);

                // Update dots
                $('.dot').removeClass('active');
                const activeIndex = Math.floor(currentIndex / itemsPerView);
                $('.dot').eq(activeIndex).addClass('active');
            }

            // Next Button
            $('#nextBtn').click(function() {
                if (currentIndex >= totalItems - itemsPerView) {
                    currentIndex = 0; // Reset to first card when last card is reached
                } else {
                    currentIndex++;
                }
                updateCarousel();
            });

            // Previous Button
            $('#prevBtn').click(function() {
                if (currentIndex <= 0) {
                    currentIndex = totalItems - itemsPerView; // Jump to the last card from the first
                } else {
                    currentIndex--;
                }
                updateCarousel();
            });

            // Dots click event
            $('.dot').click(function() {
                const slideIndex = $(this).data('slide') * itemsPerView;
                currentIndex = slideIndex;
                updateCarousel();
            });

            // Initial setup for indicators
            $('.dot').eq(0).addClass('active');
        });
    </script>
    <footer>
        @yield('footer')
    </footer>
    @vite('resources/js/app.js')
</body>
</html>
