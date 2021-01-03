<?php include('header.php') ?>

		  <div class="row">
		  	<div class="col-md-6"><h3>Customer</h1></div>
		  	<div class="col-md-6"><button type="button" class="btn btn-primary" style="float: right;" data-bs-toggle="modal" data-bs-target="#customerModal" id="add_customer">Add Customer</button></div>
		  </div>
	  	
	  	<br>
		
		<div class="table-responsive" style="height: 450px">
	  	<table class="table table-striped">
	  		<thead>
		    <tr>
		      <th scope="col">Customer ID</th>
		      <th scope="col">First Name</th>
		      <th scope="col">Last Name</th>
		      <th scope="col">Phone Number</th>
		      <th scope="col">Email</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php

		  $stmt = $conn->prepare("SELECT * FROM st_customer");
		  $stmt->execute();
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  $result = $stmt->fetchAll();

		 ?>
		 <?php foreach ($result as $key => $value) { ?>
		 	<tr>
		      <th scope="row"><?php echo $value['customer_id'] ?></th>
		      <td><?php echo $value['first_name'] ?></td>
		      <td><?php echo $value['last_name'] ?></td>
		      <td><?php echo $value['first_name'] ?></td>
		      <td><?php echo $value['email_id'] ?></td>
		      <td><a href="#" class="edit_customer" id="<?php echo $value['customer_id'] ?>"><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#customerModal"  ></i></a></td>
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
        <h5 class="modal-title" id="customerModalLabel">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="addOrEdit.php" method="post">
	      <div class="modal-body">
      		  <div class="mb-3">
			    <label for="first_name" class="form-label">First Name</label>
			    <input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="emailHelp" required>
			  </div>
			  <div class="mb-3">
			    <label for="first_name" class="form-label">Last Name</label>
			    <input type="text" class="form-control" id="last_name" name="last_name" aria-describedby="emailHelp">
			  </div>
			  <div class="mb-3">
			    <label for="address" class="form-label">Address</label>
			    <textarea class="form-control" id="address" name="address"></textarea>
			  </div>
			  <div class="mb-3">
			    <label for="phone_number" class="form-label">Phone Number</label>
			    <input type="text" class="form-control" id="phone_number" name="phone_number" aria-describedby="emailHelp">
			  </div>
			  <div class="mb-3">
			    <label for="exampleInputEmail1" class="form-label">Email address</label>
			    <input type="email" class="form-control" id="email_id" name="email_id" aria-describedby="emailHelp">
			    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
			  </div>
			 
			 <input type="hidden" name="customer_id" value="">
			 <input type="hidden" name="function" value="">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" id="customerSubmit">Add Customer</button>
	      </div>
		</form>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('#add_customer').click(function(){
		   $('#customerModalLabel').html('Add Customer'); 
		   $('#customerSubmit').html('Add Customer');     
		   $('input[name="function"]').val('customerAdd');
		   $('input[name="customer_id"]').val('');
	        $('input[name="first_name"]').val('');
	        $('input[name="last_name"]').val('');
	        $('textarea[name="address"]').val('');
	        $('input[name="phone_number"]').val('');
	        $('input[name="email_id"]').val(''); 
		});
		

	$('.edit_customer').click(function(){
		   $('#customerModalLabel').html('Edit Customer'); 
		   $('#customerSubmit').html('Update Customer');     


			var id = $(this).attr('id');

		   $.ajax({
			    url: '/stCars/ajax.php?function=customerList&id='+id,
			    type: "GET",
			    dataType: "json",
			    success: function (data) {
			    	$('input[name="function"]').val('customerEdit');
			        $('input[name="customer_id"]').val(data.customer_id);
			        $('input[name="first_name"]').val(data.first_name);
			        $('input[name="last_name"]').val(data.last_name);
			        $('textarea[name="address"]').val(data.address);
			        $('input[name="phone_number"]').val(data.phone_number);
			        $('input[name="email_id"]').val(data.email_id);
			    }
			});

		});
	})
</script>

