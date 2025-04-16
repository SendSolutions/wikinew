@extends('layouts.simple')

@section('body')
<div class="container small">

    <div class="py-m">
        <div class="card content-wrap auto-height">
            <h1 class="list-heading">Cadastro documentações da Send Solutions</h1>
            <p class="text-muted">Preencha os dados abaixo para criar sua conta dessa forma será possível visualizar todos os conteúdos <strong>{{ $company->name }}</strong>.</p>

            @if (session('error'))
                <div class="notification danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Note que aqui alteramos 'slug' para usar $company->slug -->
            <form action="{{ route('company.register', ['slug' => $company->slug]) }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input
                        name="name"
                        id="name"
                        type="text"
                        placeholder="Seu nome completo"
                        value="{{ old('name') }}"
                        required
                        pattern="^\S+(\s+\S+)+$"
                        title="Informe nome e sobrenome">
                    @if($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" id="email" type="email" placeholder="Seu e-mail" value="{{ old('email') }}" required>
                    @if($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input name="password" id="password" type="password" placeholder="Senha (mínimo 8 caracteres)" required>
                    @if($errors->has('password'))
                        <div class="text-danger">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Senha</label>
                    <input name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirme sua senha" required>
                </div>

                <div class="text-right">
                    <button class="button" type="submit">Criar Conta</button>
                </div>

                <div class="mt-m">
                    <p class="text-muted text-small mb-none">Já possui uma conta? <a href="{{ url('/login') }}">Faça login</a></p>
                </div>
            </form>

        </div>
    </div>

</div>
@stop
