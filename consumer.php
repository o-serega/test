<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'password');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";


require_once __DIR__ . '/system/config.php';
require_once __DIR__ . '/system/mysql.php';

		

		$db = new mysqli(DB_LOCAL,DB_USERNAME,DB_PASSWORD,DB_BASE);
        //если произошла ошибка то выводим сообщение
        $db->ping();

        if (!$db)
            throw new Exception('Не удалось подключиться к базе данных.');





	$callback = function ($msg) {
		
		echo ' [x] Received ', $msg->body, "\n";
		
		global $db;
		
		$arrQuery = explode('|', $msg->body);
		
		sleep(substr_count($msg->body, '.'));
		$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
		
		$mySql = new mySql;
		$mySql->query($db, 'INSERT INTO `check` (number_kassa, data_check, sum_check) VALUES ("'.$arrQuery[0].'","'.$arrQuery[1].'","'.$arrQuery[2].'")');
		
	};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>