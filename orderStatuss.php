<?php

use Magento\Framework\App\Bootstrap;
 
/**
 * If your external file is in root folder
 */
require __DIR__ . '/app/bootstrap.php';
 
/**
 * If your external file is NOT in root folder
 * Let's suppose, your file is inside a folder named 'xyz'
 *
 * And, let's suppose, your root directory path is
 * /var/www/html/magento2
 */
// $rootDirectoryPath = '/var/www/html/magento2';
// require $rootDirectoryPath . '/app/bootstrap.php';

$params = $_SERVER;
 
$bootstrap = Bootstrap::create(BP, $params);
 
$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
 
// $om = \Magento\Framework\App\ObjectManager::getInstance();

$emailValidator = $objectManager->create('Magento\Framework\Validator\EmailAddress');

// $orderId = 9646; // here order id
$len = 21784;
$z = 1;
$start = 9650;
for ($k=9650; $k <=21784; $k++) {
    
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

    $order = $objectManager->create('\Magento\Sales\Model\Order')->load($k);

    $json = file_get_contents('ordersdata.json');
  
    // Decode the JSON file
    $json_data = json_decode($json,true);
    
    // Display data
    $len = sizeof($json_data);
    // exit(); 
    for ($i=0; $i < $len; $i++) {
        if($json_data[$i]['customer_email'] == $order->getCustomerEmail()){
            if($json_data[$i]['orderStatus'] == "New"){
                $order->setState("new")->setStatus("Pending");
                $order->save(); 
                echo "Order Staus :- ".$order->getId()." ";
                // $k = $k +1;
                break;
            }elseif($json_data[$i]['orderStatus'] == "Pending"){
                $order->setState("new")->setStatus("Pending");
                $order->save(); 
                echo "Order Staus :- ".$order->getId()." ";
                // $k = $k +1;
                break;
            }elseif($json_data[$i]['orderStatus'] == "Process"){
                $order->setState("processing")->setStatus("Processing");
                $order->save(); 
                echo "Order Staus :- ".$order->getId()." ";
                // $k = $k +1;
                break;
            }elseif($json_data[$i]['orderStatus'] == "Completed"){
                $order->setState("complete")->setStatus("Complete");
                $order->save(); 
                echo "Order Staus :- ".$order->getId()." ";
                // $k = $k +1;
                break;
            }elseif($json_data[$i]['orderStatus'] == "Cancelled"){
                $order->setState("canceled")->setStatus("Canceled");
                $order->save();
                echo "Order Staus :- ".$order->getId()." "; 
                // $k = $k +1;
                break;
            }elseif($json_data[$i]['orderStatus'] == "Error"){
                $order->setState("canceled")->setStatus("Canceled");
                $order->save(); 
                echo "Order Staus :- ".$order->getId()." ";
                // $k = $k +1;
                break;
            }elseif($json_data[$i]['orderStatus'] == "Backordered"){
                $order->setState("canceled")->setStatus("Canceled");
                $order->save();
                echo "Order Staus :- ".$order->getId()." "; 
                // $k = $k +1;
                break;
            }
            // else{
            //     // $k = $k +1;
            //     echo " ".$json_data[$i]['orderStatus'].",".$order->getId()." ";
            //     // break;
            // }
        }     
        
    }
        
    
}

 


?>