<!doctype html>
<html lang="{{ $locale->htmlLang() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    @if($cspContent ?? false)
        <meta http-equiv="Content-Security-Policy" content="{{ $cspContent }}">
    @endif
    @include('exports.parts.styles', ['format' => $format, 'engine' => $engine ?? ''])
    @include('exports.parts.custom-head')
</head>
<body class="export export-format-{{ $format }} export-engine-{{ $engine ?? 'none' }}">
    <header style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <!-- Logo à esquerda -->
            <div style="flex: 1; text-align: left;">
                <!-- Pega do .env via APP_URL -->
                <img src="https://help.sendsolutions.com.br/uploads/images/gallery/2025-03/pQyxsuO2MH32TBg9-send.png"

                     alt="Logo"
                     style="max-height: 80px;">
            </div>

            <!-- Ícone do Instagram centralizado -->
            <div style="flex: 1; text-align: center;">
                <a href="https://www.instagram.com/send_solutions" target="_blank">
                    <img src="https://help.sendsolutions.com.br/uploads/images/gallery/2025-03/UkwtZygvR6ghquCs-instagram.png"
                         alt="Instagram"
                         style="max-height: 40px;">
                </a>
            </div>

            <!-- Link do site à direita -->
            <div style="flex: 1; text-align: right;">
                <a href="https://sendsolutions.com.br/solucoes/send-educacional/" target="_blank">
                    sendsolutions.com.br
                </a>
            </div>
        </div>
    </header>
    
    @include('layouts.parts.export-body-start')
    <div class="page-content" dir="auto">
        @yield('content')
    </div>
    @include('layouts.parts.export-body-end')
</body>
</html>
