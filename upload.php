<?php
	use PhpOffice\PhpSpreadsheet\IOFactory;
	require 'vendor/autoload.php';
	require('DB_conn.php');

	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		if (isset($_FILES['file'])) 
		{
			$fileTmpPath = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['name'];
			
			// Load the Excel file
			$spreadsheet = IOFactory::load($fileTmpPath);
			$sheet = $spreadsheet->getActiveSheet();
			$rows = $sheet->toArray();
		
			// Initialize counters
			$totalRecords = count($rows) - 1;
			$duplicates = 0;
			$totalLoaded = 0;

			// Insert data into the database
			foreach ($rows as $index => $row) 
			{
				 if ($index == 0) continue; // Skip header row
				 
				// Check if record already exists (duplicate check)
				$identifier = $row[0];
				$checkQuery = "SELECT * FROM employee_mst WHERE employee_id = '$identifier'";
				$result = $conn->query($checkQuery);
				if ($result->num_rows > 0) 
				{
					$duplicates++;
					continue; 
				}
				$totalLoaded++;
				
				// Insert Data to all tables
				$conn->query("INSERT INTO employee_mst(`employee_id`, `first_name`, `middle_name`, `last_name`, `gender`, `department`)
								VALUES('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]')");
				
				$joining_date =	NULL;		
				if($row[6] != "")
				{
					$joining_date = date('Y-m-d',strtotime($row[6]));
				}
				$date_of_birth = "";
				if($row[7] != "")
				{	
					$date_of_birth = date('Y-m-d',strtotime($row[7]));
				}
				$conn->query("INSERT INTO `employee_directory`(`master_id`, `joining_date`, `date_of_birth`, `salary`, `marital_status`) 
							VALUES ('$row[0]','$joining_date','$date_of_birth','$row[8]','$row[9]')");
							
				$conn->query("INSERT INTO `contact_details`(`master_id`, `contect_no`, `email_id`) 
							VALUES ('$row[0]','$row[10]','$row[11]')");
			}
			echo json_encode([
				'status' => 'success',
				'duplicateRecords' => $duplicates,
				'totalRecords' => $totalRecords,
				'totalLoaded' => $totalLoaded
			]);
		} 
		else 
		{
			echo json_encode(['status' => 'error', 'error' => 'No file uploaded.']);
		}
	}
?>