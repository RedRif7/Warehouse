<?php
require_once 'vendor/autoload.php'; // Include Composer's autoload file
require_once 'Users.php'; // Include Users class
require_once 'StorageUnit.php'; // Include StorageUnit class
require_once 'Product.php'; // Include Product class

session_start();

echo "Welcome to the Warehouse Management System!\n";

$user = new Users('dummy', 0); // Dummy instance to access the method

function isLoggedIn() {
    return isset($_SESSION['username']);
}

while (true) {
    if (isLoggedIn()) {
        echo "\nSelect an option:\n";
        echo "1. Logout\n";
        echo "2. Display Storage Units\n";
        echo "3. Create Storage Unit\n";
        echo "4. Access Storage Unit\n";
        echo "5. Create Product\n";
        echo "6. Display Products in Storage\n";
        echo "7. Edit Product\n";
        echo "8. Delete Product\n";
        echo "9. View Product Change Log\n";
        echo "10. Exit\n";
    } else {
        echo "\nSelect an option:\n";
        echo "1. Register\n";
        echo "2. Login\n";
        echo "3. Exit\n";
    }

    echo "Enter your choice: ";
    $choice = trim(fgets(STDIN));

    if (isLoggedIn()) {
        switch ($choice) {
            case '1':
                $user->logout();
                break;
            case '2':
                $user->displayStorageUnits();
                break;
            case '3':
                echo "Enter storage unit name: ";
                $unitName = trim(fgets(STDIN));
                echo "Enter number of products: ";
                $productCount = (int)trim(fgets(STDIN));
                $user->createStorageUnit($unitName, $productCount);
                break;
            case '4':
                echo "Enter access code: ";
                $accessCode = (int)trim(fgets(STDIN));
                $user->accessStorageUnit($accessCode);
                break;
            case '5':
                echo "Enter product name: ";
                $productName = trim(fgets(STDIN));
                echo "Enter quantity: ";
                $quantity = (int)trim(fgets(STDIN));
                echo "Enter storage unit name: ";
                $storageUnitName = trim(fgets(STDIN));
                $user->createProduct($productName, $quantity, $storageUnitName);
                break;
            case '6':
                echo "Enter storage unit name: ";
                $storageUnitName = trim(fgets(STDIN));
                $user->displayProductsInStorageUnit($storageUnitName);
                break;
            case '7':
                echo "Enter product ID to edit: ";
                $productId = (int)trim(fgets(STDIN));
                echo "Enter new product name: ";
                $newProductName = trim(fgets(STDIN));
                echo "Enter new quantity: ";
                $newQuantity = (int)trim(fgets(STDIN));
                Product::editProduct($productId, $newProductName, $newQuantity);
                break;
            case '8':
                echo "Enter product ID to delete: ";
                $productId = (int)trim(fgets(STDIN));
                Product::deleteProduct($productId);
                break;
            case '9':
                $logEntries = json_decode(file_get_contents('productChangesLog.json'), true);
                echo "Product Change Log:\n";
                foreach ($logEntries as $entry) {
                    echo "Product ID: {$entry['id']}\n";
                    echo "Changes:\n";
                    foreach ($entry['changes'] as $change) {
                        echo "- $change\n";
                    }
                    echo "Timestamp: {$entry['timestamp']}\n";
                    echo "----------------------\n";
                }
                break;
            case '10':
                echo "Goodbye!\n";
                exit;
            default:
                echo "Invalid choice. Please try again.\n";
                break;
        }
    } else {
        switch ($choice) {
            case '1':
                echo "Enter username: ";
                $username = trim(fgets(STDIN));
                echo "Enter password: ";
                $password = trim(fgets(STDIN));
                $user->addUser($username, $password);
                break;
            case '2':
                echo "Enter username: ";
                $username = trim(fgets(STDIN));
                echo "Enter password: ";
                $password = trim(fgets(STDIN));
                $user->userLogin($username, $password);
                break;
            case '3':
                echo "Goodbye!\n";
                exit;
            default:
                echo "Invalid choice. Please try again.\n";
                break;
        }
    }
}
