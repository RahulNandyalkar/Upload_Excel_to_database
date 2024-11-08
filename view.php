<!DOCTYPE html>
<html>
	<head>
		<title>View Records</title>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container mt-5">
			<button class="btn btn-primary" onclick="history.back()">back</button><br>
			<h2>View Records</h2>
			<div class="card">
				<div class="card-body">
					<table id="recordsTable" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>EMP_NO</th>
							<th>FIRST_NAME</th>	
							<th>LAST_NAME</th>
							<th>DEPT</th>
							<th>JOINING_DATE</th>	
							<th>DOB</th>	
							<th>CONTECT_NO</th>
							<th>EMAIL_ID</th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>

		<script>
			$(document).ready(function() {
				$('#recordsTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": {
						"url": "fetch_records.php",
						"type": "POST"
					},
					"pageLength": 10
				});
			});
		</script>
	</body>
</html>
