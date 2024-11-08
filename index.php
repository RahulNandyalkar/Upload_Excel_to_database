<!DOCTYPE html>
<html>
	<head>
		<title>Excel Upload and Record Management</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container mt-5">
			<h2>Upload Excel File</h2>
			<form id="upload" enctype="multipart/form-data">
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<label for="file">Choose Excel File (Max 5MB):</label>
							<input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls" required>
						</div>
						<button type="submit" class="btn btn-primary">Upload</button>
				
						<div class="mt-4" id="progressSection" style="display: none;">
							<h4>Upload Progress:</h4>
							<p id="progressText"></p>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar"></div>
							</div>
						</div>
						<div class="mt-4" id="resultSection" style="display: none;">
							<h4>Summary:</h4>
							<p id="summaryText"></p>
							<button class="btn btn-success" id="viewRecords">View Records</button>
						</div>
					</div>
				</div>
			</form>
		</div>


		<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
		<!-- script to validatedation  and row count -->
			<script>
				document.getElementById('file').addEventListener('change', function(event) {
					const file = event.target.files[0];
					if (file) 
					{
						const reader = new FileReader();
						reader.onload = function(e) {
							const data = new Uint8Array(e.target.result);
							const workbook = XLSX.read(data, { type: 'array' });
							const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
							const rowCount = XLSX.utils.sheet_to_json(firstSheet).length;
							 alert("Number of Records: " + rowCount);
						};
						reader.readAsArrayBuffer(file);
					}
					
					 // Validation for file size (5MB) and format
					  let fileInput = $('#file')[0].files[0];
					if (fileInput.size > 5242880) 
					{
						alert("File size should be less than 5MB.");
						document.getElementById('file').value = "";
					}
					
					let fileExtension = fileInput.name.split('.').pop().toLowerCase();
					if (fileExtension !== 'xlsx' && fileExtension !== 'xls') 
					{
						alert("Only .xlsx and .xls formats are allowed.");
						document.getElementById('file').value = "";
					}
				});
			</script>


		<script>
			$(document).ready(function() {
				$("#upload").submit(function(e) {
					e.preventDefault();
					let fileInput = $('#file')[0].files[0];
					
					let formData = new FormData(this);
					$("#progressSection").show();
					$("#progressBar").css("width", "0%");
					$("#progressText").text("0 out of 0 records processed");

					$.ajax({
						url: 'upload.php',
						type: 'POST',
						data: formData,
						contentType: false,
						processData: false,
						xhr: function() {
							let xhr = new window.XMLHttpRequest();
							xhr.upload.addEventListener("progress", function(evt) {
								if (evt.lengthComputable) {
									let percentComplete = Math.round((evt.loaded / evt.total) * 100);
									$("#progressBar").css("width", percentComplete + "%");
								}
							}, false);
							return xhr;
						},
						success: function(response) {
							let res = JSON.parse(response);
						   if (res.status === 'success') {
								$("#progressBar").css("width", "100%");
								$("#progressText").text(res.totalRecords + " out of " + res.totalRecords + " records processed");
								$("#summaryText").text("Duplicates: " + res.duplicateRecords);
								$("#resultSection").show();
							} else {
								alert("Error: ".text(res.error));
							}
						},
						error: function() {
							alert("An error occurred while uploading.");
						}
					});
				});

				$("#viewRecords").click(function() {
					window.location.href = 'view.php';
				});
			});
		</script>
	</body>
</html>
