<?php


namespace App\Services;
use Smalot\PdfParser\Parser;

class ManageFiles
{
    protected $pdf;
    protected $txt;
    protected $pdfContent;
    public $txtLines;
    public $lineNumbers;
    public $errorMessages;

    public function __construct($pdfPath, $txtPath)
    {
        $this->pdf = $pdfPath;
        $this->txt = $txtPath;
    }

    public function read()
    {
        if($this->validatePdf() === false){
            return 'pdfError';
        }
        if($this->validateTxt() === false){
            return 'txtError';
        }
        $this->readPdf();

        return true;
    }

    public function validatePdf()
    {
        $parser = new Parser();

        try {
            $pdf = $parser->parseFile($this->pdf);
        } catch (\Exception $e) {
            return false;
        }
        $pages = $pdf->getPages();
        foreach ($pages as $page) {
            $this->pdfContent[] = $page->getText();
        }
        return true;
    }
    public function validateTxt()
    {
        try {
            $txt = fopen($this->txt, 'r');
        } catch (\Exception $e) {
            return false;
        }
        if ($txt != true) {
            return false;
        }
        while ($line = fgets($txt)) {
            $this->txtLines[] = $line;
        }
        return true;
    }
    public function readPdf()
    {
        foreach ($this->pdfContent as $page){
            $Page[] = explode('Descri', $page);
        }
        foreach ($Page as $key => $array){
            foreach ($array as $key => $page){
                if($key == 1){
                    $linesPerPage[] = explode('------------------------------------------------------------------------------', $page);
                }
            }
        }
        foreach($linesPerPage as $key => $page){
            array_pop($linesPerPage[$key]);
        }
        foreach($linesPerPage as $key => $page){
            foreach($page as $key => $line){
                for($i = 0; !is_numeric($line[$i]); $i++){
                }$trimmedLines[] = substr($line, $i);
            }
        }
        foreach($trimmedLines as $key => $line){
            for($x = 1; is_numeric($line[$x]); $x++){
            }$this->lineNumbers[] = (int)substr($line, 0, $x);
            $this->errorMessages[] = substr($line, $x);
        }
        sort($this->lineNumbers);
    }
}
