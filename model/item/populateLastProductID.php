<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	require_once('../../inc/security.php');
	
	$sql = "SELECT MAX(productID) FROM item";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo e($row['MAX(productID)']);
	$stmt->closeCursor();
?>