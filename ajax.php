<?php require('config.php');
		require('mysqlDB.php');
 
$id = $_GET['id'];
		
switch ($_GET['function']) {
	case 'customerList':
			$stmt = $conn->prepare("SELECT * FROM st_customer where customer_id=".$id);
		  $stmt->execute();
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  echo json_encode($stmt->fetch());
		break;
	case 'dealList':
		$stmt = $conn->prepare("SELECT * FROM st_deals where deal_id=".$id);
		  $stmt->execute();
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  echo json_encode($stmt->fetch());
		break;
	default:
		# code...
		break;
}




?>