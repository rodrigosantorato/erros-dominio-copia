<?php


namespace App\Services;

use App\EmployeeIntegrationCode;

class FormatErrors
{
    protected $txtLines;
    protected $lineNumbers;
    protected $errorMessages;
    protected $formattedErrors;
    protected $employeeCodes;

    public function __construct(ManageFiles $manageFiles)
    {
        $this->txtLines = $manageFiles->txtLines;
        $this->lineNumbers = $manageFiles->lineNumbers;
        $this->errorMessages = array_combine($manageFiles->lineNumbers, $manageFiles->errorMessages);
    }

    public function findAndFormat()
    {
        $isEmpty = true;
        foreach($this->txtLines as $key => $line){
            if(in_array($key, $this->lineNumbers) && $key !== null){
                if(strlen($this->txtLines[$key-1]) == 23){
                    for($i = 2; strlen($this->txtLines[$key-$i]) <= 23; $i++){
                        $isEmpty = false;
                        if (HandleErrors::handleErrors($key, $this->txtLines, $key-$i, $this->errorMessages[$key]) != null){
                            $this->formattedErrors[] = HandleErrors::handleErrors($key, $this->txtLines, $key-$i, $this->errorMessages[$key]);
                        }
                    }
                }
                if(strlen($this->txtLines[$key-1]) == 17){
                    $isEmpty = false;
                    $this->formattedErrors[] = HandleErrors::handleErrors($key, $this->txtLines, $key-1, $this->errorMessages[$key]);
                }
                if(strlen($this->txtLines[$key-1]) == 44 && $this->txtLines[$key-1] != null){
                    $isEmpty = false;
                    $this->formattedErrors[] = HandleErrors::handleErrors($key, $this->txtLines, $key, $this->errorMessages[$key]);
                }
            }
        }
        if($isEmpty == true){
            return 'Não achei nenhum erro nesses arquivos';
        }
        return true;
    }
    public function getEmployeeCodes()
    {
        foreach($this->formattedErrors as $key => $value){
            $this->employeeCodes[] = ltrim(ltrim($value[1], 'Código do empregado: '), '0');
        }
        return $this->employeeCodes;
    }
    public function replaceCodeWithName()
    {
        $i = 0;
        foreach($this->employeeCodes as $key => $code){
            $employeeIntegrationCode = EmployeeIntegrationCode::where('code', $code)->with('employee')->first();
            $this->formattedErrors[$i][1] = 'Nome do colaborador: ' . $employeeIntegrationCode->employee->full_name;
            $i++;
        }
        return $this->formattedErrors;
    }
}
