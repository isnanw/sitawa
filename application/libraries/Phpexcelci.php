<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Phpexcelci
{
    public function __construct()
    {
        require_once APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
		require_once APPPATH.'third_party/PHPExcel-1.8/Classes/ChunkReadFilter.php';
    }
}