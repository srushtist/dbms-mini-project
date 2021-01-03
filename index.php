<?php include('header.php') ?>

		  <div class="row">
		  	<div class="col-md-6"><h3>Deals</h1></div>
		  	<div class="col-md-6"><button type="button" class="btn btn-primary" style="float: right;" data-bs-toggle="modal" data-bs-target="#customerModal" id="add_customer">Add Deal</button></div>
		  </div>
	  	
	  	<br>
		
		<div class="table-responsive" style="height: 450px">
	  	<table class="table table-striped">
	  		<thead>
		    <tr>
		      <th scope="col">Deal ID</th>
		      <th scope="col">Mpdel</th>
		      <th scope="col">Customer</th>
		      <th scope="col">Sales Person</th>
		      <th scope="col">Price</th>
		      <th scope="col">Delivery Date</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php

		  $stmt = $conn->prepare("SELECT deals.*, customer.first_name as customer_fname, customer.last_name as customer_lname, vehicles.vehicle_model, sales_person.first_name as sales_person_fname ,sales_person.last_name as sales_person_lname 
		  										FROM st_deals deals
		  							LEFT JOIN st_customer customer ON deals.customer_id=customer.customer_id
		  							LEFT JOIN st_vehicles vehicles ON deals.vehicle_id=vehicles.vehicle_id
		  							LEFT JOIN st_sales_person sales_person ON deals.sales_person_id=sales_person.sales_person_id ");
		  $stmt->execute();
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  $result = $stmt->fetchAll();

		  $stmt = $conn->prepare("SELECT * FROM st_customer");
		  $stmt->execute();
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  $customerList = $stmt->fetchAll();

		  $stmt = $conn->prepare("SELECT * FROM st_sales_person");
		  $stmt->execute();
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  $sales_person_list = $stmt->fetchAll();

		  $stmt = $conn->prepare("SELECT * FROM st_vehicles");
		  $stmt->execute();
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  $vehicles_list = $stmt->fetchAll();

		 ?>
		 <?php foreach ($result as $key => $value) { ?>
		 	<tr>
		      <th scope="row"><?php echo $value['deal_id'] ?></th>
		      <td><?php echo $value['vehicle_model'] ?></td>
		      <td><?php echo $value['customer_fname'] ." ".$value['customer_lname']  ?></td>
		      <td><?php echo $value['sales_person_fname'] ." ".$value['sales_person_lname'] ?></td>
		      <td><?php echo $value['price'] ?></td>
		      <td><?php echo $value['delivery_date'] ?></td>
		      <td><a href="#" class="edit_customer" id="<?php echo $value['deal_id'] ?>"><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#customerModal"  ></i></a></td>
		    </tr>
		 <?php } ?>
		    
		  </table>
		</div>
	
<?php include('footer.php') ?>

<!-- Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customerModalLabel">Add Deal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="addOrEdit.php" method="post">
	      <div class="modal-body">
      		  <div class="mb-3">
			    <label for="customer" class="form-label">Customer</label>
			    <select class="form-select" id="customer" name="customer" aria-label="Default select example" required="">
				  <option value="" selected>Select Customer</option>
				  <?php foreach ($customerList as $key => $customer) {
				  	echo "<option value='".$customer['customer_id']."'>".$customer['first_name']." ".$customer['last_name']."</option>";
				  } ?>
				</select>

			  </div>
			  <div class="mb-3">Sales Person</label>
			    <select class="form-select" id="sales_person" name="sales_person" aria-label="Default select example" required="">
				  <option value="" selected>Select Sales Person</option>
				  <?php foreach ($sales_person_list as $key => $sales_person) {
				  	echo "<option value='".$sales_person['sales_person_id']."'>".$sales_person['first_name']." ".$customer['last_name']."</option>";
				  } ?>
				</select>
			  </div>
			  <div class="mb-3">
			    <label for="address" class="form-label">Vehicle</label>
			    <select class="form-select" id="vehicle" name="vehicle" aria-label="Default select example" required="">
				  <option value="" selected>Select Vehicle</option>
				  <?php foreach ($vehicles_list as $key => $vehicle) {
				  	echo "<option value='".$vehicle['vehicle_id']."'>".$vehicle['vehicle_model']."</option>";
				  } ?>
				</select>			  </div>
			  <div class="mb-3">
			    <label for="price" class="form-label">Price</label>
			    <input type="text" class="form-control" id="price" name="price" aria-describedby="emailHelp">
			  </div>
			  <div class="mb-3">
			    <label for="delivery_date" class="form-label">Delivery Date</label>
			    <input type="date" class="form-control" id="delivery_date" name="delivery_date" aria-describedby="emailHelp">
			  </div>
			 
			 <input type="hidden" name="deal_id" value="">
			 <input type="hidden" name="function" value="">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" id="customerSubmit">Add Deal</button>
	      </div>
		</form>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){

		$('#add_customer').click(function(){
		   $('#customerModalLabel').html('Add Deal'); 
		   $('#customerSubmit').html('Add Deal');     
		   $('input[name="function"]').val('dealAdd');
		   $('input[name="deal_id"]').val('');
			        $('select[name="customer"]').val('');
			        $('select[name="sales_person"]').val('');
			        $('select[name="vehicle"]').val('');
			        $('input[name="price"]').val('');
			        $('input[name="delivery_date"]').val('');
		});
		

	$('.edit_customer').click(function(){
		   $('#customerModalLabel').html('Edit Deal'); 
		   $('#customerSubmit').html('Update Deal');     


			var id = $(this).attr('id');

		   $.ajax({
			    url: '/stCars/ajax.php?function=dealList&id='+id,
			    type: "GET",
			    dataType: "json",
			    success: function (data) {
			    	$('input[name="function"]').val('dealEdit');
			        $('input[name="deal_id"]').val(data.deal_id);
			        $('select[name="customer"]').val(data.customer_id);
			        $('select[name="sales_person"]').val(data.sales_person_id);
			        $('select[name="vehicle"]').val(data.vehicle_id);
			        $('input[name="price"]').val(data.price);
			        $('input[name="delivery_date"]').val(data.delivery_date);
			    }
			});

		});
	})
</script>

