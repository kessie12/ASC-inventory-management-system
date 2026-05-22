<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	require_once('../../inc/security.php');

	
	$sql = "SELECT MAX(purchaseID) FROM purchase";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo e($row['MAX(purchaseID)']);
?>