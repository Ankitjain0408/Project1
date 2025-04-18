<?php
session_start();
include('../includes/auth_check.php');
include('../includes/db_connect.php');

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$success_message = '';
$error_message = '';

// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = intval($_POST['product_id']);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // First, get the image path to delete the file
        $get_image = "SELECT image FROM products WHERE id = ?";
        $stmt = $conn->prepare($get_image);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if ($product) {
            // Delete from order_items first (if exists)
            $delete_order_items = "DELETE FROM order_items WHERE product_id = ?";
            $stmt = $conn->prepare($delete_order_items);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();

            // Then delete the product
            $delete_sql = "DELETE FROM products WHERE id = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $product_id);
            
            if ($stmt->execute()) {
                // Delete the image file if it exists
                if ($product['image'] && file_exists('../' . $product['image'])) {
                    unlink('../' . $product['image']);
                }
                $success_message = "Product deleted successfully!";
                $conn->commit();
            } else {
                throw new Exception("Error deleting product");
            }
        } else {
            throw new Exception("Product not found");
        }
    } catch (Exception $e) {
        $conn->rollback();
        $error_message = "Error: " . $e->getMessage() . ". Please try again.";
    }
}

// Get all products with their categories
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY c.name, p.name";
$result = $conn->query($sql);

// First, let's add the status column to products table if it doesn't exist
$check_status_column = "SHOW COLUMNS FROM products LIKE 'status'";
$status_exists = $conn->query($check_status_column);
if ($status_exists->num_rows === 0) {
    $add_status_column = "ALTER TABLE products ADD COLUMN status VARCHAR(20) DEFAULT 'active'";
    $conn->query($add_status_column);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Products - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        design: {
                            slate: '#475569',
                            beige: '#f5f5dc',
                            teal: '#0d9488',
                            coral: '#f97316',
                            light: '#f8fafc',
                            dark: '#1e293b'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="w-full bg-white shadow-sm py-4 fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="flex items-center space-x-2">
                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-design-teal to-design-coral flex items-center justify-center">
                            <span class="text-white font-bold text-xl">DV</span>
                        </div>
                        <span class="text-xl font-semibold text-design-dark">Admin Dashboard</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="features.php" class="text-gray-600 hover:text-design-teal">Dashboard</a>
                    <a href="../logout.php" class="bg-design-teal text-white px-4 py-2 rounded-md hover:bg-design-teal/90 transition-colors">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 pt-24 pb-8">
        <?php if ($success_message): ?>
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Manage Products</h2>
                
                <?php if ($result && $result->num_rows > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php 
                        $current_category = '';
                        while ($product = $result->fetch_assoc()):
                            if ($current_category !== $product['category_name']):
                                $current_category = $product['category_name'];
                        ?>
                                <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                    <h3 class="text-xl font-semibold text-design-teal mb-4 mt-4">
                                        <?php echo htmlspecialchars($current_category); ?>
                                    </h3>
                                </div>
                            <?php endif; ?>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="aspect-w-16 aspect-h-9 mb-4">
                                    <img 
                                        src="../<?php echo htmlspecialchars($product['image']); ?>" 
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        class="object-cover w-full h-48 rounded-md"
                                        onerror="this.src='../images/placeholder.jpg'"
                                    >
                                </div>
                                <h4 class="font-semibold text-gray-800 mb-2">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </h4>
                                <p class="text-gray-600 mb-4">
                                    ₹<?php echo number_format($product['price'], 2); ?>
                                </p>
                                <form onsubmit="return confirmDelete('<?php echo htmlspecialchars($product['name']); ?>')" method="POST" class="text-right">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button 
                                        type="submit" 
                                        name="delete_product" 
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors"
                                    >
                                        Remove Product
                                    </button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(productName) {
        return confirm(`Are you sure you want to delete "${productName}"? This action cannot be undone.`);
    }
    </script>
</body>
</html>
