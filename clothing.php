<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Inventory</title>
    <link rel="stylesheet" href="instruments_style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 80px;
            background-color: rgba(44, 36, 116, 0.9);
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 30px;
            position: fixed;
            left: 0;
            transition: width 0.3s ease;
            border-right: 4px solid #ffcc00;
        }
        .sidebar:hover {
            width: 200px;
        }
        .icon-btn {
            color: white;
            text-decoration: none;
            padding: 15px;
            width: 100%;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
        }
        .icon-btn i {
            font-size: 24px;
            margin-right: 12px;
            min-width: 24px;
            transition: opacity 0.3s ease;
        }
        .icon-btn span {
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            position: absolute;
            left: 60px;
        }
        .sidebar:hover .icon-btn span {
            opacity: 1;
        }
        .sidebar:hover .icon-btn i {
            opacity: 0;
        }
        .icon-btn:hover {
            background-color: rgba(255, 255, 255, 0.16);
            transform: translateX(5px);
            width: 170px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="instruments.php" class="icon-btn">
            <i class="fas fa-guitar"></i>
            <span>Instruments</span>
        </a>
        <a href="accessory.php" class="icon-btn">
            <i class="fas fa-gem"></i>
            <span>Accessories</span>
        </a>
        <a href="clothing.php" class="icon-btn">
            <i class="fas fa-tshirt"></i>
            <span>Clothing</span>
        </a>
        <a href="members.php" class="icon-btn">
            <i class="fas fa-user"></i>
            <span>Members</span>
        </a>
        <a href="report.php" class="icon-btn">
            <i class="fas fa-file-alt"></i>
            <span>Report</span>
        </a>
        <a href="history.php" class="icon-btn">
            <i class="fas fa-clock"></i>
            <span>History</span>
        </a>
        <a href="deleted_items.php" class="icon-btn">
            <i class="fas fa-trash-alt"></i>
            <span>Archives</span>
        </a>
        
        <a href="manage_users.php" class="icon-btn">
            <i class="fas fa-users-cog"></i>
            <span>Manage Users</span>
        </a>
        
    </div>


    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <?php $section_title = 'Clothing'; include 'header.php'; ?>

        <!-- Feedback Messages -->
        <?php
        if(isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">';
            echo $_SESSION['success_message'];
            echo '<button type="button" class="close" onclick="this.parentElement.style.display=\'none\';">&times;</button>';
            echo '</div>';
            unset($_SESSION['success_message']);
        }
        
        if(isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">';
            echo $_SESSION['error_message'];
            echo '<button type="button" class="close" onclick="this.parentElement.style.display=\'none\';">&times;</button>';
            echo '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <!-- Card Section -->
        <div class="card-container">
            <?php
            include 'db_connect.php';
            // Fetch clothing from database
            $sql = "SELECT * FROM clothing ORDER BY clothing_name ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Determine image to display
                    $imagePath = !empty($row["image_path"]) ? $row["image_path"] : 'picture-1.png';
                    
                    echo "<div class='card'>";
                    echo "<img src='" . $imagePath . "' alt='Clothing'>";
                    echo "<h3>" . $row["clothing_name"] . "</h3>";
                    echo "<p>Color: " . $row["clothing_color"] . "</p>";
                    echo "<p>Size: " . $row["clothing_size_id"] . "</p>";
                    echo "<p>Condition: " . $row["condition"] . "</p>";
                    echo "<p>Quantity: " . $row["quantity"] . "</p>";
                    
                    // Check if quantity is 0, if so disable the borrow button
                    if ($row["quantity"] > 0) {
                        echo "<button class='borrow-btn' data-name='" . $row["clothing_name"] . "'>Borrow</button>";
                    } else {
                        echo "<button class='borrow-btn disabled' disabled>Out of Stock</button>";
                    }
                    
                    echo "<div class='card-buttons'>";
                    echo "<button class='edit-btn' data-id='" . $row["clothing_id"] . "' 
                          data-name='" . $row["clothing_name"] . "' 
                          data-color='" . $row["clothing_color"] . "' 
                          data-size='" . $row["clothing_size_id"] . "' 
                          data-condition='" . $row["condition"] . "' 
                          data-quantity='" . $row["quantity"] . "'
                          data-image='" . $imagePath . "'>Edit</button>";
                    echo "<button class='delete-btn' data-id='" . $row["clothing_id"] . "' data-name='" . $row["clothing_name"] . "'>Delete</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No clothing found</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <!-- Action Buttons -->
    <div class="action-buttons">
            <button class="add-button" id="addButton">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>

    <!-- Modal -->
    <div id="borrowModal" class="modal">
        <div class="modal-content">
            <h2>Borrow item</h2>
            <form action="save_history.php" method="POST">
                <input type="hidden" name="type" value="BORROW">
                <div class="form-group">
                    <label for="borrowedBy">Borrowed by:</label>
                    <input type="text" id="borrowedBy" name="borrowedBy" required>
                </div>
                
                <div class="form-group">
                    <label for="date">Date to be Borrowed:</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="form-group">
                    <label for="date">Date to be Returned:</label>
                    <input type="date" id="date_return" name="date_return" required>
                </div>
                
                
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" class="form-select" onchange="loadItems()" required>
                        
                        <option value="Clothing" selected>Clothing</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="itemName">Item name:</label>
                    <input type="text" id="itemName" name="itemName" readonly required>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <select id="quantity" name="quantity" class="form-select" required>
                        <option value="">-- Select quantity --</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="sn">Student Number:</label>
                    <input type="text" id="sn" name="sn" minlength="10" maxlength="11" required>
                </div>
                
            
                
                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea id="remarks" name="remarks" rows="4"></textarea>
                </div>
                
                <div class="submit-container">
                    <button type="submit" class="submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add Clothing Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h2>Add Clothing</h2>
            <form action="save_clothing.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="addName">Name:</label>
                    <input type="text" id="addName" name="clothing_name" required>
                </div>
                
                <div class="form-group">
                    <label for="addColor">Color:</label>
                    <input type="text" id="addColor" name="clothing_color" required>
                </div>
                
                <div class="form-group">
                    <label for="addSize">Size:</label>
                    <input type="text" id="addSize" name="clothing_size_id" required>
                </div>
                
                <div class="form-group">
                    <label for="addCondition">Condition:</label>
                    <input type="text" id="addCondition" name="condition" required>
                </div>
                
                <div class="form-group">
                    <label for="addQuantity">Quantity:</label>
                    <input type="number" id="addQuantity" name="quantity" required min="1">
                </div>
                
                <div class="form-group">
                    <label for="clothingImage">Clothing Image:</label>
                    <input type="file" id="clothingImage" name="clothing_image" accept="image/*">
                </div>
                
                <div class="submit-container">
                    <button type="submit" class="submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Clothing Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Delete Clothing</h2>
            <form action="delete_clothing.php" method="POST">
                <input type="hidden" id="deleteClothingId" name="clothing_id">
                <div class="form-group">
                    <label>Are you sure you want to delete:</label>
                    <p id="deleteClothingName" class="selected-item-name"></p>
                </div>
                
                <div class="form-group">
                    <label for="delete_reason">Reason for deletion:</label>
                    <textarea id="delete_reason" name="delete_reason" rows="3" style="width: 100%; padding: 8px; border-radius: 4px; background: rgba(5, 5, 5, 0.7); color: white; border: 1px solid #444;" placeholder="Please provide a reason for deleting this item..." required></textarea>
                </div>
                
                <div class="submit-container">
                    <button type="submit" class="submit-btn" style="background-color: #ff4444; color: white;">Delete Clothing</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Clothing Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Edit Clothing</h2>
            <form action="update_clothing.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="editClothingId" name="clothing_id">
                <input type="hidden" id="currentImagePath" name="current_image_path">
                
                <div class="form-group">
                    <label for="editName">Name:</label>
                    <input type="text" id="editName" name="clothing_name" required>
                </div>
                
                <div class="form-group">
                    <label for="editColor">Color:</label>
                    <input type="text" id="editColor" name="clothing_color" required>
                </div>
                
                <div class="form-group">
                    <label for="editSize">Size:</label>
                    <input type="text" id="editSize" name="clothing_size_id" required>
                </div>
                
                <div class="form-group">
                    <label for="editCondition">Condition:</label>
                    <input type="text" id="editCondition" name="condition" required>
                </div>
                
                <div class="form-group">
                    <label for="editQuantity">Quantity:</label>
                    <input type="number" id="editQuantity" name="quantity">
                </div>
                
                <div class="form-group">
                    <label>Current Image:</label>
                    <div class="current-image-container">
                        <img id="currentImage" src="" alt="Current Clothing Image" style="max-width: 150px; max-height: 150px; margin-bottom: 10px;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="editClothingImage">Change Image:</label>
                    <input type="file" id="editClothingImage" name="clothing_image" accept="image/*">
                    <small>(Leave empty to keep current image)</small>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="removeImage" name="remove_image" value="5">
                        Remove current image (use default) 
                    </label>
                </div>
                
                <div class="submit-container">
                    <button type="submit" class="submit-btn">Update Clothing</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Borrow Modal
    var borrowModal = document.getElementById("borrowModal");
    var borrowBtns = document.getElementsByClassName("borrow-btn");
    
    // Edit Modal
    var editModal = document.getElementById("editModal");
    var editBtns = document.getElementsByClassName("edit-btn");
    
    // Add Modal
    var addModal = document.getElementById("addModal");
    var addButton = document.getElementById("addButton");
    
    // Delete Confirmation Modal
    var deleteModal = document.getElementById("deleteModal");
    var deleteBtns = document.getElementsByClassName("delete-btn");
    var closeButtons = document.querySelectorAll(".close, .close-modal, .cancel-btn");
    
    // Function to load items based on selected category
    function loadItems() {
        const category = document.getElementById('category').value;
        
        // Clear quantity options
        document.getElementById('quantity').innerHTML = '<option value="">-- Select quantity --</option>';
        
        // Fetch items for the selected category
        fetch('get_items.php?category=' + category)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data); // Debug output
                
                // Store the data for later use when selecting quantities
                window.itemsData = data;
                
                // If opened from a specific clothing item, update quantity options
                const preselectedItem = document.getElementById("itemName").value;
                if (preselectedItem) {
                    console.log('Preselected item:', preselectedItem); // Debug output
                    updateQuantityDropdown(preselectedItem);
                }
            })
            .catch(error => {
                console.error('Error loading items:', error);
                alert('Error loading items. Please try again.');
            });
    }
    
    // Function to fill in the user's full name from profile
    function loadUserFullName() {
        fetch('get_user_profile.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('borrowedBy').value = data.full_name;
                }
            })
            .catch(error => {
                console.error('Error loading user profile:', error);
            });
    }
    
    // Function to update quantity dropdown based on selected item
    function updateQuantityDropdown(itemName) {
        const quantitySelect = document.getElementById('quantity');
        
        // Clear existing options
        quantitySelect.innerHTML = '<option value="">-- Select quantity --</option>';
        
        if (itemName && window.itemsData) {
            console.log('Looking for item name:', itemName); // Debug output
            console.log('Available items:', window.itemsData); // Debug output
            
            // Find the selected item's data - first by exact match
            let itemData = window.itemsData.find(item => item.name === itemName);
            
            // If not found by exact match, try includes
            if (!itemData) {
                itemData = window.itemsData.find(item => {
                    return itemName.includes(item.name) || item.name.includes(itemName);
                });
            }
            
            console.log('Found item data:', itemData); // Debug output
            
            if (itemData) {
                const maxQuantity = parseInt(itemData.quantity);
                console.log('Max quantity:', maxQuantity); // Debug output
                
                // Create options from 1 to maxQuantity
                for (let i = 1; i <= maxQuantity; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    quantitySelect.appendChild(option);
                }
                
                // Select the first quantity option by default
                if (maxQuantity > 0) {
                    quantitySelect.value = "1";
                }
            }
        }
    }
    
    for (var i = 0; i < borrowBtns.length; i++) {
        borrowBtns[i].onclick = function() {
            borrowModal.style.display = "flex";
            
            // Set category to Clothing by default
            document.getElementById("category").value = "Clothing";
            
            // Set the item name directly in the text field
            const itemName = this.getAttribute("data-name");
            document.getElementById("itemName").value = itemName;
            
            // Load the user's full name
            loadUserFullName();
            
            // Load the items and update quantity dropdown
            loadItems();
        }
    }
    
    for (var i = 0; i < editBtns.length; i++) {
        editBtns[i].onclick = function() {
            // Populate the edit form with clothing data
            document.getElementById("editClothingId").value = this.getAttribute("data-id");
            document.getElementById("editName").value = this.getAttribute("data-name");
            document.getElementById("editColor").value = this.getAttribute("data-color");
            document.getElementById("editSize").value = this.getAttribute("data-size");
            document.getElementById("editCondition").value = this.getAttribute("data-condition");
            document.getElementById("editQuantity").value = this.getAttribute("data-quantity");
            
            // Handle image
            var imagePath = this.getAttribute("data-image");
            document.getElementById("currentImage").src = imagePath;
            document.getElementById("currentImagePath").value = imagePath;
            
            // Reset remove image checkbox
            document.getElementById("removeImage").checked = false;
            document.getElementById("editClothingImage").disabled = false;
            
            editModal.style.display = "flex";
        }
    }
    
    // Handle checkbox for removing image
    document.getElementById('removeImage').addEventListener('change', function() {
        document.getElementById('editClothingImage').disabled = this.checked;
        
        // Clear the file input if checkbox is checked
        if (this.checked) {
            document.getElementById('editClothingImage').value = '';
            // Show the default image in the preview
            document.getElementById('currentImage').src = 'picture-1.png';
        } else {
            // Restore the original image path
            document.getElementById('currentImage').src = document.getElementById('currentImagePath').value;
        }
    });
    
    // Handle file input for uploading image
    document.getElementById('editClothingImage').addEventListener('change', function() {
        if (this.value) {
            document.getElementById('removeImage').disabled = true;
        } else {
            document.getElementById('removeImage').disabled = false;
        }
    });
    
    // Delete confirmation
    for (var i = 0; i < deleteBtns.length; i++) {
        deleteBtns[i].onclick = function() {
            // Get the clothing id and name from data attributes
            var clothingId = this.getAttribute("data-id");
            var clothingName = this.getAttribute("data-name");
            
            // Set the values in the delete form
            document.getElementById("deleteClothingId").value = clothingId;
            document.getElementById("deleteClothingName").textContent = clothingName;
            
            // Show the delete modal
            deleteModal.style.display = "flex";
            return false; // Prevent default action
        };
    }
    
    // Close modals when clicking close buttons
    closeButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            deleteModal.style.display = "none";
            // Add other modals here if needed
        });
    });
    
    addButton.onclick = function() {
        addModal.style.display = "flex";
    }
    
    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target == borrowModal) {
            borrowModal.style.display = "none";
        }
        if (event.target == addModal) {
            addModal.style.display = "none";
        }
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
        }
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
    
    // Load items on page load for the borrow modal
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize items if the borrow modal is shown immediately
        if (borrowModal.style.display === "flex") {
            loadItems();
        }
    });

    // Get the modal
    var modal = document.getElementById("borrowModal");

    // Get all buttons that should open the modal
    var btns = document.getElementsByClassName("borrow-btn");
    
    // Student Number validation
    document.getElementById('sn').addEventListener('input', function() {
        var value = this.value;
        if (value.length > 0 && (value.length < 10 || value.length > 11)) {
            this.setCustomValidity('Student Number must be 10-11 characters long');
        } else {
            this.setCustomValidity('');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const header = document.querySelector('.header');
    
    sidebar.addEventListener('mouseenter', function() {
        sidebar.style.width = '200px';
       
        header.style.marginLeft = '110px'; // Push header to match sidebar expansion
    });
    
    sidebar.addEventListener('mouseleave', function() {
        sidebar.style.width = '80px';
       
        header.style.marginLeft = '-10px';
    });
});
    </script>
</body>
</html>

<?php

?>