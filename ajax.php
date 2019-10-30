<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");


require_once __DIR__ . '/system/config.php';
require_once __DIR__ . '/system/mysql.php';


class controller {

    public function __construct() {

    
		if(isset($_GET['inquiry'])) $inquiry = $_GET['inquiry'];
        if(isset($_GET['month_num'])) $month_num = $_GET['month_num'];
		
		$db = new mysqli(DB_LOCAL,DB_USERNAME,DB_PASSWORD,DB_BASE);
        //если произошла ошибка то выводим сообщение
        $db->ping();

        if (!$db)
            throw new Exception('Не удалось подключиться к базе данных.');
		
		
		

		if($inquiry == 'month'){

			$mySql = new mySql;

			$result = $mySql->query($db, "SELECT t1.number_kassa, 
                                                 MONTH(CONVERT_TZ(t1.data_check, t2.tive_zone_kassa, '+03:00')) as month, 
                                                 SUM(t1.sum_check) as sum 
                                          FROM `check` t1 
                                          LEFT JOIN kassa t2 
                                          ON t1.number_kassa = t2.number_kassa 
                                          GROUP BY month, t1.number_kassa");

			$json = json_encode($result);
			echo $json;
			
		}else if($inquiry == 'day'){

			$mySql = new mySql;

			$result = $mySql->query($db, "SELECT t1.number_kassa, DATE_FORMAT((CONVERT_TZ(t1.data_check, t2.tive_zone_kassa, '+03:00')), '%d.%m.%Y') as month, 
                                                 SUM(t1.sum_check) as sum 
                                          FROM `check` t1 
                                          LEFT JOIN kassa t2 
                                          ON t1.number_kassa = t2.number_kassa 
                                          WHERE MONTH(CONVERT_TZ(t1.data_check, t2.tive_zone_kassa, '+03:00')) = ".$month_num." 
                                          GROUP BY month, t1.number_kassa 
                                          ORDER BY `month` DESC");


			$json = json_encode($result);
			echo $json;
			
		}else if($inquiry == 'cheks'){
			
			$mySql = new mySql;

            $result = $mySql->query($db, "SELECT t1.number_kassa, DATE_FORMAT((CONVERT_TZ(t1.data_check, t2.tive_zone_kassa, '+03:00')), '%d.%m.%Y %H:%i:%s') as month, 
                                                 t1.sum_check as sum 
                                          FROM `check` t1 
                                          LEFT JOIN kassa t2 
                                          ON t1.number_kassa = t2.number_kassa 
                                          WHERE DATE_FORMAT((CONVERT_TZ(t1.data_check, t2.tive_zone_kassa, '+03:00')), '%d.%m.%Y') = '".$month_num."'");


			$json = json_encode($result);
			echo $json;
			
		}


    }

}

$controller = new controller;

?>