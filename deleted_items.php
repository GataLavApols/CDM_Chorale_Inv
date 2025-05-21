<?php
// deleted_items.php
session_start();
include 'db_connect.php';

// Fetch deleted instruments
$instruments_sql = "SELECT * FROM deleted_instruments ORDER BY deleted_at DESC";
$instruments_result = $conn->query($instruments_sql);

// Fetch deleted accessories
$accessories_sql = "SELECT * FROM deleted_accessories ORDER BY deleted_at DESC";
$accessories_result = $conn->query($accessories_sql);

// Fetch deleted clothing
$clothing_sql = "SELECT * FROM deleted_clothing ORDER BY deleted_at DESC";
$clothing_result = $conn->query($clothing_sql);

// Fetch deleted members
$members_sql = "SELECT * FROM deleted_members ORDER BY deleted_at DESC";
$members_result = $conn->query($members_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archives</title>
    <link rel="stylesheet" href="instruments_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .table-container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: white;
            margin-bottom: 40px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #444;
        }
        th {
            background-color: rgba(44, 36, 116, 0.9);
            color: white;
            font-weight: bold;
        }
        td {
            background-color: rgba(5, 5, 5, 0.7);
        }
        tr:hover td {
            background-color: rgba(44, 36, 116, 0.7);
        }
        .section-title {
            color: white;
            text-align: center;
            margin: 20px 0;
            text-transform: uppercase;
            font-size: 24px;
        }
        .item-image {
            max-width: 80px;
            max-height: 80px;
            border-radius: 5px;
        }
        .type-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        .type-instrument {
            background-color: #4CAF50;
            color: white;
        }
        .type-accessory {
            background-color: #2196F3;
            color: white;
        }
        .type-clothing {
            background-color: #9C27B0;
            color: white;
        }
        .type-member {
            background-color: #8e44ad;
        }
        .profile-link {
            background-color: #ffcc00 !important;
            color: #000066 !important;
        }
        .profile-link:hover {
            background-color: #e6b800 !important;
        }

        /* Sidebar styles */
        .sidebar {
         width: 80px;
         background-color: rgba(44, 36, 116, 0.9); /* Semi-transparent blue background */
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 30px;
        position: fixed;
        left: 0;
        transition: width 0.3s ease;
        border-right: 4px solid #ffcc00; /* Yellow line at the right edge */
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
            margin-right: 15px;
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
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
            width: 170px;
        }
        /* Tabs styles */
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 10px;
        }
        .tab-btn {
            background: #2c2474;
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 5px 5px 0 0;
            cursor: pointer;
            font-size: 16px;
            outline: none;
            transition: background 0.2s;
        }
        .tab-btn.active, .tab-btn:hover {
            background: #ffcc00;
            color: #2c2474;
            font-weight: bold;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
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
        <?php $section_title = 'Archives'; include 'header.php'; ?>

       
            
            <?php
            // Display success message if set
            if (isset($_SESSION['success_message'])) {
                echo '<div class="alert success-alert" style="background-color: rgba(76, 175, 80, 0.8); color: white; padding: 12px; margin-bottom: 15px; border-radius: 5px; text-align: center;">';
                echo '<i class="fas fa-check-circle"></i> ' . $_SESSION['success_message'];
                echo '</div>';
                unset($_SESSION['success_message']); // Clear the message after displaying
            }
            
            // Display error message if set
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert error-alert" style="background-color: rgba(244, 67, 54, 0.8); color: white; padding: 12px; margin-bottom: 15px; border-radius: 5px; text-align: center;">';
                echo '<i class="fas fa-exclamation-triangle"></i> ' . $_SESSION['error_message'];
                echo '</div>';
                unset($_SESSION['error_message']); // Clear the message after displaying
            }
            ?>
            
            <!-- Tabs -->
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab(event, 'instruments')">Instruments</button>
                <button class="tab-btn" onclick="showTab(event, 'accessories')">Accessories</button>
                <button class="tab-btn" onclick="showTab(event, 'clothing')">Clothing</button>
                <button class="tab-btn" onclick="showTab(event, 'members')">Members</button>
            </div>

            <!-- Tab Contents -->
            <div id="tab-instruments" class="tab-content active">
                <h2 class="section-title">Archived Instruments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Reason</th>
                            <th>Archived By</th>
                            <th>Archived At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($instruments_result->num_rows > 0) {
                            while($row = $instruments_result->fetch_assoc()) {
                                $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'picture-1.png';
                                echo "<tr>";
                                echo "<td><img src='" . $imagePath . "' class='item-image' alt='Item image'></td>";
                                echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['condition_status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['reason'] ?? 'No reason provided') . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>";
                               
                                echo "<td>
                                    <button class='edit-btn' onclick='restoreInstrument(" . $row['id'] . ")'>
                                        <i class='fas fa-undo'></i> Restore
                                    </button>
                                    <button class='delete-btn' onclick='confirmDeleteInstrument(" . $row['id'] . ")' style='background-color: #f44336; margin-left: 5px;'>
                                        <i class='fas fa-trash'></i> Archive
                                    </button>
                                  </td>";
                            echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align: center;'>No Archived instruments found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
            </div>

            <div id="tab-accessories" class="tab-content">
                <h2 class="section-title">Archived Accessories</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Reason</th>
                            <th>Archived By</th>
                            <th>Archived At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($accessories_result->num_rows > 0) {
                            while($row = $accessories_result->fetch_assoc()) {
                                $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'picture-1.png';
                                echo "<tr>";
                                echo "<td><img src='" . $imagePath . "' class='item-image' alt='Item image'></td>";
                                echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['condition_status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['reason'] ?? 'No reason provided') . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>";
                               
                                echo "<td>
                                    <button class='edit-btn' onclick='restoreAccessory(" . $row['id'] . ")'>
                                        <i class='fas fa-undo'></i> Restore
                                    </button>
                                    <button class='delete-btn' onclick='confirmDeleteAccessory(" . $row['id'] . ")' style='background-color: #f44336; margin-left: 5px;'>
                                        <i class='fas fa-trash'></i> Archive
                                    </button>
                                  </td>";
                            echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align: center;'>No archived accessories found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
            </div>

            <div id="tab-clothing" class="tab-content">
                <h2 class="section-title">Archived Clothing</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Reason</th>
                            <th>Archived By</th>
                            <th>Archived At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($clothing_result->num_rows > 0) {
                            while($row = $clothing_result->fetch_assoc()) {
                                $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'picture-1.png';
                                echo "<tr>";
                                echo "<td><img src='" . $imagePath . "' class='item-image' alt='Item image'></td>";
                                echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['condition_status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['reason'] ?? 'No reason provided') . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>";
                                
                                echo "<td>
                                    <button class='edit-btn' onclick='restoreClothing(" . $row['id'] . ")'>
                                        <i class='fas fa-undo'></i> Restore
                                    </button>
                                    <button class='delete-btn' onclick='confirmDeleteClothing(" . $row['id'] . ")' style='background-color: #f44336; margin-left: 5px;'>
                                        <i class='fas fa-trash'></i> Archive
                                    </button>
                                  </td>";
                            echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align: center;'>No archived clothing found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
            </div>

            <div id="tab-members" class="tab-content">
                <h2 class="section-title">Archived Members</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Member Name</th>
                            <th>Reason</th>
                            <th>Archived By</th>
                            <th>Archived At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($members_result->num_rows > 0) {
                            while($row = $members_result->fetch_assoc()) {
                                $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'picture-1.png';
                                echo "<tr>";
                                echo "<td><img src='" . $imagePath . "' class='item-image' alt='Item image'></td>";
                                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                             
                                
                                echo "<td>" . htmlspecialchars($row['reason'] ?? 'No reason provided') . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>";
                               

                                echo "<td>
                                    <button class='edit-btn' onclick='restoreMember(" . $row['id'] . ")'>
                                        <i class='fas fa-undo'></i> Restore
                                    </button>
                                    <button class='delete-btn' onclick='confirmDeleteMember(" . $row['id'] . ")' style='background-color: #f44336; margin-left: 5px;'>
                                        <i class='fas fa-trash'></i> Archive
                                    </button>
                                  </td>";
                            echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align: center;'>No archived members found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button class="delete-btn" id="emptyTrashBtn" onclick="confirmDeleteAll()" style="background-color: #f44336; padding: 10px 15px;">
                    <i class="fas fa-trash-alt"></i> Empty Archive
                </button>
            </div>
            <input type="hidden" id="currentTrashType" value="instruments">
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <h2>Restore Item</h2>
            <p>Are you sure you want to restore this item to the inventory?</p>
            <div class="submit-container" style="display: flex; justify-content: space-between;">
                <button type="button" class="submit-btn" style="background-color: #ccc;" onclick="closeModal()">Cancel</button>
                <button type="button" class="submit-btn" id="confirmRestore">Restore</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Permanent Delete</h2>
            <p>Are you sure you want to permanently delete this item? This action cannot be undone.</p>
            <div class="submit-container" style="display: flex; justify-content: space-between;">
                <button type="button" class="submit-btn" style="background-color: #ccc;" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="submit-btn" style="background-color: #f44336;" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>

    <!-- Delete All Confirmation Modal -->
    <div id="deleteAllModal" class="modal">
        <div class="modal-content">
            <h2>Empty Archive</h2>
            <p>Are you sure you want to permanently delete ALL items in the trash? This action cannot be undone.</p>
            <div class="submit-container" style="display: flex; justify-content: space-between;">
                <button type="button" class="submit-btn" style="background-color: #ccc;" onclick="closeDeleteAllModal()">Cancel</button>
                <button type="button" class="submit-btn" style="background-color: #f44336;" id="confirmDeleteAll">Delete All</button>
            </div>
        </div>
    </div>

    <script>
    // Get the modals
    var modal = document.getElementById("confirmModal");
    var deleteModal = document.getElementById("deleteModal");
    var deleteAllModal = document.getElementById("deleteAllModal");
    var confirmButton = document.getElementById("confirmRestore");
    var confirmDeleteButton = document.getElementById("confirmDelete");
    var confirmDeleteAllButton = document.getElementById("confirmDeleteAll");
    var itemToRestore = null;
    var itemToDelete = null;

    function showTab(event, tab) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(function(el) {
            el.classList.remove('active');
        });
        // Remove active from all buttons
        document.querySelectorAll('.tab-btn').forEach(function(el) {
            el.classList.remove('active');
        });
        // Show selected tab and activate button
        document.getElementById('tab-' + tab).classList.add('active');
        event.target.classList.add('active');
        // Set the current type for Empty Trash
        document.getElementById('currentTrashType').value = tab;
    }

    function restoreInstrument(id) {
        itemToRestore = id;
        modal.style.display = "flex";
        
        // Set up the confirmation button
        confirmButton.onclick = function() {
            window.location.href = 'restore_deleted_item.php?type=instrument&id=' + itemToRestore;
        }
    }
    function restoreAccessory(id) {
        itemToRestore = id;
        modal.style.display = "flex";
        
        // Set up the confirmation button
        confirmButton.onclick = function() {
            window.location.href = 'restore_deleted_item.php?type=accessory&id=' + itemToRestore;
        }
    }
    function restoreClothing(id) {
        itemToRestore = id;
        modal.style.display = "flex";
        
        // Set up the confirmation button
        confirmButton.onclick = function() {
            window.location.href = 'restore_deleted_item.php?type=clothing&id=' + itemToRestore;
        }
    }
    function restoreMember(id) {
        itemToRestore = id;
        modal.style.display = "flex";
        
        // Set up the confirmation button
        confirmButton.onclick = function() {
            window.location.href = 'restore_deleted_item.php?type=member&id=' + itemToRestore;
        }
    }

    //DELETE ITEMS

    function confirmDeleteInstrument(id) {
        itemToDelete = id;
        deleteModal.style.display = "flex";
        
        // Set up the confirmation button
        confirmDeleteButton.onclick = function() {
            window.location.href = 'permanent_delete.php?type=instrument&id=' + itemToDelete;
        }
    }
    function confirmDeleteAccessory(id) {
        itemToDelete = id;
        deleteModal.style.display = "flex";
        
        // Set up the confirmation button
        confirmDeleteButton.onclick = function() {
            window.location.href = 'permanent_delete.php?type=accessory&id=' + itemToDelete;
        }
    }
    function confirmDeleteClothing(id) {
        itemToDelete = id;
        deleteModal.style.display = "flex";
        
        // Set up the confirmation button
        confirmDeleteButton.onclick = function() {
            window.location.href = 'permanent_delete.php?type=clothing&id=' + itemToDelete;
        }
    }
    function confirmDeleteMember(id) {
        itemToDelete = id;
        deleteModal.style.display = "flex";
        
        // Set up the confirmation button
        confirmDeleteButton.onclick = function() {
            window.location.href = 'permanent_delete.php?type=member&id=' + itemToDelete;
        }
    }

    function closeModal() {
        modal.style.display = "none";
    }
    
    function closeDeleteModal() {
        deleteModal.style.display = "none";
    }

    function confirmDeleteAll() {
        deleteAllModal.style.display = "flex";
        // Set up the confirmation button
        confirmDeleteAllButton.onclick = function() {
            var type = document.getElementById('currentTrashType').value;
            window.location.href = 'permanent_delete_all.php?type=' + type;
        }
    }

    function closeDeleteAllModal() {
        deleteAllModal.style.display = "none";
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
        }
        if (event.target == deleteAllModal) {
            deleteAllModal.style.display = "none";
        }
    }
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
$conn->close();
?> 
