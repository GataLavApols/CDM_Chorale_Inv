<?php
// Set error reporting to show errors during development
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable error display
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Function to output error popup HTML
function outputErrorPopup($message) {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error - CDM Chorale</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            body {
                font-family: Tahoma, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                background: url("bgpic2.png") no-repeat center center fixed;
                background-size: cover;
                overflow-x: hidden;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(5, 5, 5, 0.637);
                z-index: 999;
            }
            .popup {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #b3b3b3f5;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                z-index: 1000;
                text-align: center;
                min-width: 300px;
                border: 4px solid #ffcc00;
            }
            .popup-header {
                background-color: rgba(44, 36, 116, 0.9);
                color: white;
                padding: 15px;
                margin: -30px -30px 20px -30px;
                border-radius: 10px 10px 0 0;
                border-bottom: 4px solid #ffcc00;
            }
            .popup-header h2 {
                margin: 0;
                font-size: 24px;
                font-weight: normal;
            }
            .popup-message {
                margin: 20px 0;
                color: #000;
                font-size: 16px;
            }
            .popup-button {
                background-color: #ffcc00;
                color: #000;
                border: none;
                padding: 10px 25px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                transition: background-color 0.3s;
            }
            .popup-button:hover {
                background-color: #e6b800;
            }
            .popup-button:active {
                transform: translateY(1px);
            }
        </style>
    </head>
    <body>
        <div class="popup-overlay"></div>
        <div class="popup">
            <div class="popup-header">
                <h2><i class="fas fa-exclamation-circle"></i> Error</h2>
            </div>
            <div class="popup-message">' . htmlspecialchars($message) . '</div>
            <button class="popup-button" onclick="window.history.back()">OK</button>
        </div>
    </body>
    </html>';
    exit();
}

// Custom error handler function
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Log the error
    error_log("Error [$errno] $errstr on line $errline in file $errfile");
    
    // Show error popup
    outputErrorPopup("Error: Please fill out all fields correctly.");
    
    return true; // Let PHP handle the error as well
}

// Set the custom error handler
set_error_handler("customErrorHandler");

// Function to handle database errors
function handleDatabaseError($error) {
    error_log("Database Error: " . $error);
    outputErrorPopup("Error: Please fill out all fields correctly.");
    return true;
}

// Function to handle validation errors
function handleValidationError($message = null) {
    outputErrorPopup("Error: Please fill out all fields correctly.");
    return true;
}

// Enable error display for exceptions
set_exception_handler(function($e) {
    error_log("Uncaught Exception: " . $e->getMessage());
    outputErrorPopup("Error: Please fill out all fields correctly.");
});
?> 