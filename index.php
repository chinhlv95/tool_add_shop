<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Setting Shop</title>
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
	<div class="form-style">
		<h2>Setting Shop</h2>
		    <form method="POST" id="form" action="./upload.php" enctype="multipart/form-data">
				<input type="text" name="corporation" placeholder="Corporation (Ex: cmper)" required> </br>
			    <input type="file" name="fileToUpload" required> </br>
			    <input type="submit" value="UPLOAD">
		    </form>
	</div>
	<script src="public/js/jquery-3.2.1.min.js"></script>
	<script src="public/js/scripts.js"></script>
</body>
</html>
