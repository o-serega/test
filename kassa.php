<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$timestamp = 1546322400;
$day = 365; //365

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'password');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);


	for($i = 0; $i < $day; $i++){

            $kol_check = rand(400,800);

            for($ind = 0; $ind < $kol_check; $ind++){

                $number_kassa = rand(1,3);
                $sum_check = rand(80,150);

                $data_check = rand($timestamp, $timestamp + 50400);

  
				$data = implode(' ', array_slice($argv, 1));

				if (empty($data)) {
					$data = $number_kassa."|".date('Y-m-d H:i:s',$data_check)."|".$sum_check;
				}

				$msg = new AMQPMessage(

					$data,
					array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
					
				);

				$channel->basic_publish($msg, '', 'task_queue');

				echo ' [x] Sent ', $data, "\n";

            
            }

            $timestamp += 86400;

    }



$channel->close();
$connection->close();


?>