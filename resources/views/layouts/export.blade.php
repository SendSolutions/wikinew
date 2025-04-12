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

    @php
        // Obtém o link configurado no .env ou no arquivo de configuração
        $appLink = config('bookstack.app_link');
        // Caso o link contenha 'wiki.sendsolucions.com.br', usamos "senderp.png".
        // Do contrário, usamos "send.png".
        $logoFilename = (strpos($appLink, 'wiki.sendsolucions.com.br') !== false) ? 'senderp.png' : 'send.png';
        // O caminho da pasta permanece fixo; apenas o nome final varia.
        $logoPath = 'uploads/images/gallery/2025-03/' . $logoFilename;
    @endphp

    <header style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
        <div style="
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 40px;
        ">
            <!-- Exibe a logo, alterando somente o nome do arquivo conforme a variável -->
            <a href="https://sendsolutions.com.br/solucoes/send-educacional/" target="_blank">
                <img src="file://{{ public_path($logoPath) }}"
                     alt="Logo da Aplicação"
                     style="max-height: 50px;">
            </a>

            <!-- Ícone do Instagram (fixo) -->
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
    
    <!-- Rodapé com dados complementares -->
    <footer style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; text-align: center; font-size: 0.8em;">
        <p>
            Copyright 2025 -
            Send Solutions Ltda -
            CNPJ 67.843.169/0001-84 -
            <a href="https://aplicacao.sendsolutions.com.br/TimeSheet/" target="_blank">Abertura de chamados</a> -
            <a href="https://www.instagram.com/send_solutions" target="_blank">Instagram</a>
        </p>
    </footer>
    
</body>
</html>
