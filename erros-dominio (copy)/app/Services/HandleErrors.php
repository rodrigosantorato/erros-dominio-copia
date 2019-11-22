<?php


namespace App\Services;


abstract class HandleErrors
{
    static function handleErrors($lineNumber, $txtLines, $key, $errorMessage)
    {
        $hasError = false;
        $echo = [];
        if(strlen($txtLines[$key-1]) == 44){
            $echo[] = 'Linha '. $lineNumber. utf8_encode($errorMessage);
            $echo[] = 'Código do empregado: ' . substr($txtLines[$key-1], 2, 10);
            $echo[] = 'Código da Rúbrica: ' . substr($txtLines[$key-1], 18, 4);
            $echo[] = 'Valor: R$ ' . ltrim(substr($txtLines[$key-1], 24, 7), '0'). ','. substr($txtLines[$key-1], 31, 2);

            if(strlen($txtLines[$key]) == 17){
                $echo[] = 'Evento referente à plano de saúde ou odonto.';

                if(strpos($txtLines[$key], 'x') == true || strpos($txtLines[$key], ' ') == true) {
                    $hasError = true;
                    $echo[] = 'Erro de CNPJ: Número inválido ou incompleto.';
                }

                for($i = 1; strlen($txtLines[$key+$i]) == 23; $i++){
                    if(strpos($txtLines[$key+$i], 'x') == true || strpos($txtLines[$key+$i], ' ') == true) {
                        $hasError = true;
                        $beneficiario = strpos($txtLines[$key+$i], 'T') ? 'Titular' : 'Dependente';
                        $echo[] = 'Erro de Colaborador #' . $i . ': Código do '. $beneficiario .' inválido ou não cadastrado.';
                    }
                }
                if($hasError == false){
                    if($errorMessage = 'Registro duplicado'){
                        $echo[] = '*Registro duplicado.';
                    }else{
                        $echo[] = '*Confirmar com a contabilidade se a rúbrica acima é de um benefício de saúde ou odonto.';
                    }
                }
            }
        }
        return $echo;
    }
}
