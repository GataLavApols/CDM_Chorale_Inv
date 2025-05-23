<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clothing_id'])) {
    $clothing_id = $_POST['clothing_id'];
    $clothing_name = $_POST['clothing_name'];
    $clothing_color = $_POST['clothing_color'];
    $clothing_size_id = $_POST['clothing_size_id'];
    $condition = $_POST['condition'];
    $quantity = $_POST['quantity'];
    $current_image_path = $_POST['current_image_path'];
    
    // Default to current image path
    $image_path = $current_image_path;
    
    // Check if remove_image checkbox is checked
    if(isset($_POST['remove_image']) && $_POST['remove_image'] == '5') {
        // Set image path to default image
        $image_path = 'picture-1.png';
        
        // Delete the old image if it exists and is not already the default
        if (!empty($current_image_path) && file_exists($current_image_path) && 
            $current_image_path != 'picture-1.png' && $current_image_path != 'barong.png') {
            unlink($current_image_path);
        }
    }
    // Handle image upload if a new image is provided and remove_image is not checked
    elseif(isset($_FILES['clothing_image']) && $_FILES['clothing_image']['error'] == 0) {
        // Create the clothing_images directory if it doesn't exist
        if(!file_exists('clothing_images')) {
            mkdir('clothing_images', 0777, true);
        }
        
        // Generate a unique filename
        $file_ext = pathinfo($_FILES['clothing_image']['name'], PATHINFO_EXTENSION);
        $filename = 'clothing_' . $clothing_id . '_' . time() . '.' . $file_ext;
        $target_file = "clothing_images/" . $filename;
        
        // Move the uploaded file to the target location
        if(move_uploaded_file($_FILES['clothing_image']['tmp_name'], $target_file)) {
            // If upload successful, delete the old image if it exists and is not the default
            if (!empty($current_image_path) && file_exists($current_image_path) && 
                $current_image_path != 'picture-1.png' && $current_image_path != 'barong.png') {
                unlink($current_image_path); // Delete the old image file
            }
            
            // Update image path to the new image
            $image_path = $target_file;
        }
    }
    
    // Update the clothing in the database with image path
    $stmt = $conn->prepare("UPDATE clothing SET clothing_name = ?, clothing_color = ?, clothing_size_id = ?, `condition` = ?, quantity = ?, image_path = ? WHERE clothing_id = ?");
    $stmt->bind_param("ssssssi", $clothing_name, $clothing_color, $clothing_size_id, $condition, $quantity, $image_path, $clothing_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Clothing updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating clothing: " . $conn->error;
    }
    
    $stmt->close();
    
    // Redirect back to clothing page
    header("Location: clothing.php");
    exit();
} else {
    // Not a valid POST request
    header("Location: clothing.php");
    exit();
}

$conn->close();
?> 