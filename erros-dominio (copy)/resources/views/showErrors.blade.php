@extends('layout')

@section('title', 'Listar Erros')

@section('content')
    <div class="returnbtn">
        <a class="btn btn-outline-primary" href="/">Voltar</a>
    </div>
    <div class="title">
        <h2><strong>Lista de Erros</strong></h2>
    </div>
    @foreach($lines as $error)
        <div class="row justify-content-center">
            <div class="card shadow-nohover">
                <div class="card-block">
                    <p class="card-text">
                        @foreach($error as $line)
                            {{ $line }}
                            <br>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
        <div class="void">

        </div>
    @endforeach
    <div class="row justify-content-center">
        <a class="btn btn-outline-primary" href="/">Envie outros arquivos.</a>
    </div>
@endsection
