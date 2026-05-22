<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	require_once('../../inc/security.php');
	
	if(isset($_POST['id'])){
		
		$productID = $_POST['id'];
		
			
		$defaultImgFolder = 'data/item_images/';
		
		// Get all item details
		$sql = 'SELECT * FROM item WHERE productID = :productID';
		$stmt = $conn->prepare($sql);
		$stmt->execute(['productID' => $productID]);
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$output = '<p><img src="';
		
			if($row['imageURL'] === '' || $row['imageURL'] === 'imageNotAvailable.jpg'){
				$output .= 'data/item_images/imageNotAvailable.jpg" class="img-fluid"></p>';
			} else {
				$output .= 'data/item_images/' . e($row['itemNumber']) . '/' . e($row['imageURL']) . '" class="img-fluid"></p>';
			}
						
			$output .= '<span><strong>Name:</strong> ' . e($row['itemName']) . '</span><br>';
			$output .= '<span><strong>Price:</strong> ' . e($row['unitPrice']) . '</span><br>';
			$output .= '<span><strong>Discount:</strong> ' . e($row['discount']) . ' %</span><br>';
			$output .= '<span><strong>Stock:</strong> ' . e($row['stock']) . '</span><br>';
		}
		
		echo $output;
	}
?>