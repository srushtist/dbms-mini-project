<?php require('config.php');
		require('mysqlDB.php');
 

switch ($_POST['function']) {
	case 'customerAdd':
			$sql = "INSERT INTO st_customer (first_name, last_name, address,phone_number ,email_id)
				  VALUES (:first_name, :last_name, :address, :phone_number, :email_id)";
				  $pre = $conn->prepare($sql);
				  $pre->bindParam('first_name', $_POST['first_name']);
					$pre->bindParam('last_name', $_POST['last_name']);
					$pre->bindParam('address', $_POST['address']);
					$pre->bindParam('phone_number', $_POST['phone_number']);
					$pre->bindParam('email_id', $_POST['email_id']);
				  $pre->execute();
				  header('Location: customer.php');
		break;
	case 'customerEdit':
		$sql = "UPDATE st_customer SET first_name=:first_name, last_name=:last_name, address=:address,
					phone_number=:phone_number ,email_id=:email_id
					WHERE customer_id = :customer_id";
				  $pre = $conn->prepare($sql);
				  $pre->bindParam('customer_id', $_POST['customer_id']);
				  $pre->bindParam('first_name', $_POST['first_name']);
					$pre->bindParam('last_name', $_POST['last_name']);
					$pre->bindParam('address', $_POST['address']);
					$pre->bindParam('phone_number', $_POST['phone_number']);
					$pre->bindParam('email_id', $_POST['email_id']);
				  $pre->execute();
				  header('Location: customer.php');
		break;
	case 'dealAdd':
		$sql = "INSERT INTO st_deals (customer_id, vehicle_id, sales_person_id,price ,delivery_date)
				  VALUES (:customer_id, :vehicle_id, :sales_person_id, :price, :delivery_date)";
				  $pre = $conn->prepare($sql);
				  $pre->bindParam('customer_id', $_POST['customer']);
					$pre->bindParam('vehicle_id', $_POST['vehicle']);
					$pre->bindParam('sales_person_id', $_POST['sales_person']);
					$pre->bindParam('price', $_POST['price']);
					$pre->bindParam('delivery_date', $_POST['delivery_date']);
				  $pre->execute();
				  header('Location: index.php');
	break;
	case 'dealEdit':
		$sql = "UPDATE st_deals SET customer_id=:customer_id, vehicle_id=:vehicle_id, sales_person_id=:sales_person_id,price=:price ,delivery_date=:delivery_date WHERE deal_id=:deal_id";
				  $pre = $conn->prepare($sql);
				  $pre->bindParam('deal_id', $_POST['deal_id']);
				  $pre->bindParam('customer_id', $_POST['customer']);
					$pre->bindParam('vehicle_id', $_POST['vehicle']);
					$pre->bindParam('sales_person_id', $_POST['sales_person']);
					$pre->bindParam('price', $_POST['price']);
					$pre->bindParam('delivery_date', $_POST['delivery_date']);
				  $pre->execute();
				  header('Location: index.php');
	break;
	default:
		# code...
		break;
}




?>