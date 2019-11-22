@extends('layout')

@section('title', 'Inserir Arquivos')

@section('content')
    <div class="form-group center-block">
        <img src="https://cdn0.trampos.co/companies/logos/85700/dabdd3638dd72f8d0f41be8e42b99292c172b1d8/medium/logo.png" class="center">
        <form action="/" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div>
                <h2><strong>PDF</strong></h2>
            <div class="custom-file">
                <input type="file" accept=".pdf" class="custom-file-input" id="customFile" name="pdf" required oninvalid="this.setCustomValidity('Hmm... tente um arquivo PDF.')"
                       oninput="setCustomValidity('')" data-toggle="tooltip" data-placement="bottom" title="">
                <label class="custom-file-label" for="customFile">Seu arquivo PDF vai aqui.</label>
            </div><br><br>
            <div>
                <h2><strong>Arquivo de Texto</strong></h2>
            </div>
            <div class="custom-file">
                <input type="file" accept=".txt" class="custom-file-input" id="customFile" name="txt" required oninvalid="this.setCustomValidity('Hmm... tente um arquivo de texto.')"
                       oninput="setCustomValidity('')" data-toggle="tooltip" data-placement="bottom" title="">
                <label class="custom-file-label" for="customFile">Seu arquivo txt vai aqui.</label>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-enviar">Enviar</button><br><br>
        </form>
    </div>
    </div>

    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        $(".custom-file").hover(
            function() {
                $(this).addClass('shadow').css('cursor', 'pointer');
            }, function() {
                $(this).removeClass('shadow');
            }
        );
    </script>
@endsection
