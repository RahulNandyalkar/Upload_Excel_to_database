<?php
	require('DB_conn.php');
	
	// Pagination logic
	$limit = $_POST['length'];
	$offset = $_POST['start'];

	$result = $conn->query("SELECT * FROM employee_mst, employee_directory, contact_details 
								WHERE employee_mst.employee_id = employee_directory.master_id 
								AND employee_mst.employee_id = contact_details.master_id LIMIT $limit OFFSET $offset");
	$totalRecords = $conn->query("SELECT COUNT(*) AS count FROM employee_mst")->fetch_assoc()['count'];

	$data = [];
	while ($row = $result->fetch_assoc()) {
		$joining_date =	null;		
		if($row['joining_date'] != null)
		{
			$joining_date = date('d-m-Y',strtotime($row['joining_date']));
		}
		$date_of_birth = null;
		if($row['date_of_birth'] != null)
		{	
			$date_of_birth = date('d-m-Y',strtotime($row['date_of_birth']));
		}
		$data[] = [
			$row['employee_id'],
			$row['first_name'],
			$row['last_name'],
			$row['department'],
			$joining_date,
			$date_of_birth,
			$row['contect_no'],
			$row['email_id']
		];
	}

	echo json_encode([
		"draw" => intval($_POST['draw']),
		"recordsTotal" => $totalRecords,
		"recordsFiltered" => $totalRecords,
		"data" => $data
	]);

	$conn->close();
?>
