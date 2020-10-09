<!DOCTYPE html>
<html>
<head>
	<title>TEST</title>
</head>
<body>
	<?php
	foreach ($absensi as $data) {
		$a = min($data->time);
		$b = max($data->time);
	}
	?>
	<p><?php echo $a; ?></p>
	<p><?php echo $b; ?></p>
</body>
</body>
</html>