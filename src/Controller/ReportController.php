<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Cake\Event\Event;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);

        $this->autoRender = false;

        $this->Auth->allow(['export']);
    }

    public function export() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        //$writer->save('/Applications/MAMP/htdocs/wowmua/webroot/hello world.xlsx');
        
        var_dump($writer);
    }

}
