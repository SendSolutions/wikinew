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
        <div style="
            display: flex;
            align-items: center;
            /* Para evitar quebra de linha caso a largura fique menor */
            flex-wrap: nowrap;
            /* Ajuste de espaçamento horizontal entre as imagens, se quiser */
            gap: 40px;
        ">
            <!-- Logo Send (à esquerda) -->
            <a href="https://sendsolutions.com.br/solucoes/send-educacional/" target="_blank">
                <img src="file://{{ public_path('uploads/images/gallery/2025-03/send.png') }}"
                     alt="Logo Send"
                     style="max-height: 50px;">
            </a>

            <!-- Ícone Instagram (à direita) -->
            <a href="https://www.instagram.com/send_solutions" target="_blank">
                <img src="file://{{ public_path('uploads/images/gallery/2025-03/instagram.png') }}"
                     alt="Instagram"
                     style="max-height: 20px;">
            </a>
           
        </div>
    </header>
    
    @include('layouts.parts.export-body-start')
    <div class="page-content" dir="auto">
        @yield('content')
    </div>
    @include('layouts.parts.export-body-end')
</body>
</html>
