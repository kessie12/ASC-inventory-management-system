<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['itemImageItemNumber'])){
		
		$itemImageItemNumber = trim($_POST['itemImageItemNumber']);
		if (!preg_match('/^[a-zA-Z0-9_-]+$/', $itemImageItemNumber)) {
		    echo '<div class="alert alert-danger">Invalid item number.</div>';
		    exit();
		}

		$baseImageFolder = '../../data/item_images/';
		$itemImageFolder = '';
		
		if(!empty($itemImageItemNumber)){
			
			// Check if the user has selected an image
			if($_FILES['itemImageFile']['name'] != ''){
				// Both itemNumber and image file given. Hence, proceed to next steps
								
				// Check if itemNumber is in DB
				$itemNumberSql = 'SELECT * FROM item WHERE itemNumber = :itemNumber';
				$itemNumberStatement = $conn->prepare($itemNumberSql);
				$itemNumberStatement->execute(['itemNumber' => $itemImageItemNumber]);
				
				if($itemNumberStatement->rowCount() > 0){
					// Item is in the DB, hence proceed to next steps
					// Check the file .extension
					$arr = explode('.', $_FILES['itemImageFile']['name']);
					$extension = strtolower(end($arr));
					$allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
					$maxFileSize = 2 * 1024 * 1024; // 2 MB
					if ($_FILES['itemImageFile']['size'] > $maxFileSize) {
						echo '<div class="alert alert-danger">Image is too large. Maximum size is 2MB.</div>';
						exit();
					}
					
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$mimeType = finfo_file($finfo, $_FILES['itemImageFile']['tmp_name']);
					finfo_close($finfo);

					$allowedMimes = [
					    'image/jpeg' => 'jpg',
					    'image/png' => 'png',
					    'image/gif' => 'gif'
					];

					if (!array_key_exists($mimeType, $allowedMimes)) {
					    echo '<div class="alert alert-danger">Invalid image type.</div>';
					    exit();
					}

					if(in_array($extension, $allowedTypes)){
						// All good so far...
						
						$baseImageFolder = '../../data/item_images/';
						$itemImageFolder = '';
						$extension = $allowedMimes[$mimeType];
						$fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
						
						// Create image folder for uploading images
						$itemImageFolder = $baseImageFolder . $itemImageItemNumber . '/';
						if(is_dir($itemImageFolder)){
							// Folder already exists. Hence, do nothing
						} else {
							// Folder does not exist, Hence, create it
							mkdir($itemImageFolder, 0755, true);
						}
						
						$targetPath = $itemImageFolder . $fileName;
						//echo $targetPath;
						//exit();
						
						// Upload file to server
						if(move_uploaded_file($_FILES['itemImageFile']['tmp_name'], $targetPath)){
							
							// Update image url in item table
							$updateImageUrlSql = 'UPDATE item SET imageURL = :imageURL WHERE itemNumber = :itemNumber';
							$updateImageUrlStatement = $conn->prepare($updateImageUrlSql);
							$updateImageUrlStatement->execute(['imageURL' => $fileName, 'itemNumber' => $itemImageItemNumber]);
							
							echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Image uploaded successfully.</div>';
							exit();
							
						} else {
							echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Could not upload image.</div>';
							exit();
						}
						
					} else {
					// Image type is not allowed
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Image type is not allowed. Please select a valid image.</div>';
					exit();
					}
				}
				
			} else {
				// Image file not given
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select an image</div>';
				exit();
			}
		
		} else {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter item number</div>';
			exit();
		}

	}

?>