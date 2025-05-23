<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the type first to determine required fields
    $type = $_POST['type'] ?? '';
    
    // Different required fields based on type
    $required_fields = ['type', 'borrowedBy', 'date', 'category', 'itemName', 'quantity'];
    
    // Only require date_return for BORROW operations
    if ($type === 'BORROW') {
        $required_fields[] = 'date_return';
    }
    
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        die("Error: Missing required fields: " . implode(', ', $missing_fields));
    }

    // Get form data
    $borrowed_by = $_POST['borrowedBy'];
    $date = $_POST['date'];
    // Set date_return to null by default, use the POST value if provided
    $date_return = isset($_POST['date_return']) && !empty($_POST['date_return']) ? $_POST['date_return'] : null;
    $category = $_POST['category'];
    $item_name = $_POST['itemName'];
    $quantity = $_POST['quantity'];
    $sn = isset($_POST['sn']) ? $_POST['sn'] : null;
    
    // Validate student number length (10-11 characters)
    if (!empty($sn) && (strlen($sn) < 10 || strlen($sn) > 11)) {
        die("Error: Student Number must be 10-11 characters long.");
    }
    
    // Ensure status is a valid enum value
    $valid_statuses = ['needs replacement', 'needs repair', 'not working', 'repaired', 'working', 'other'];
    $status = isset($_POST['status']) ? $_POST['status'] : 'working';
    
    // Handle custom status when "other" is selected
    if ($status === 'other' && isset($_POST['custom_status']) && !empty($_POST['custom_status'])) {
        $status = $_POST['custom_status'];
    } elseif ($status === 'other') {
        $status = 'custom status'; // Default if "other" selected but no custom text
    }
    
    if (!in_array($status, $valid_statuses) && $status !== 'custom status') {
        // If status is not one of the predefined values but is a custom entry, that's OK
        // We only default to "working" if the status is completely invalid and not a custom entry
        if (empty($status)) {
            $status = 'working';
        }
    }
    
    $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : null;
    
    // Set default condition value
    $condition = isset($_POST['condition']) ? $_POST['condition'] : 'good';

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare and execute the SQL statement for history
        $stmt = $conn->prepare("INSERT INTO history (type, borrowed_by, date, date_return, category, item_name, quantity, sn, status, remarks, `condition`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssissss", $type, $borrowed_by, $date, $date_return, $category, $item_name, $quantity, $sn, $status, $remarks, $condition);
        $stmt->execute();
        $stmt->close();

        // If this is a borrow operation, update the inventory
        if ($type === 'BORROW') {
            // Determine which table to update based on category
            $table = '';
            switch(strtolower($category)) {
                case 'instruments':
                    $table = 'instruments';
                    $name_field = 'instrument_name';
                    break;
                case 'clothing':
                    $table = 'clothing';
                    $name_field = 'clothing_name';
                    break;
                case 'accessories':
                    $table = 'accessories';
                    $name_field = 'deco_name';
                    break;
                default:
                    throw new Exception("Invalid category");
            }

            // Update the quantity in the respective table
            $update_stmt = $conn->prepare("UPDATE $table SET quantity = quantity - ? WHERE $name_field = ?");
            $update_stmt->bind_param("is", $quantity, $item_name);
            $update_stmt->execute();
            $update_stmt->close();
        }

        // Commit transaction
        $conn->commit();

        // Determine which page to redirect to based on the HTTP referer
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        
        if (strpos($referer, '_nonadmin') !== false) {
            // Redirect to non-admin history page if coming from a non-admin page
            header("Location: history_nonadmin.php");
        } else {
            // Redirect to admin history page
            header("Location: history.php");
        }
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid request method");
}

$conn->close();
?> 