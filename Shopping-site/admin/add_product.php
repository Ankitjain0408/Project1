<?php 
include('../includes/auth_check.php');
include('../includes/db_connect.php');
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$success_message = '';
$error_message = '';

if (isset($_POST['submit'])) {
    $category_id = (int)$_POST['category_id'];
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = (int)$_POST['product_price'];

    // Handle product image upload
    $product_image = $_FILES['product_image'];
    $image_path = '../uploads/' . basename($product_image['name']);
    if (move_uploaded_file($product_image['tmp_name'], $image_path)) {
        $image_db_path = 'uploads/' . basename($product_image['name']);
        $insert_product = "INSERT INTO products (category_id, name, price, image) 
                           VALUES ($category_id, '$product_name', $product_price, '$image_db_path')";
        if (mysqli_query($conn, $insert_product)) {
            $success_message = "Product added successfully!";
        } else {
            $error_message = "Error adding product: " . mysqli_error($conn);
        }
    } else {
        $error_message = "Failed to upload product image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Dashboard</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
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
    <div class="min-h-screen pt-20 pb-8">
        <div class="max-w-xl mx-auto px-4">
            <!-- Messages -->
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

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Add New Product</h2>
                    <p class="text-gray-600 mt-1">Fill in the product details below</p>
                </div>

                <form action="add_product.php" method="post" enctype="multipart/form-data" class="space-y-4">
                    <!-- Category Select -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Category
                        </label>
                        <select 
                            name="category_id" 
                            id="category_id" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-design-teal focus:border-design-teal bg-white"
                        >
                            <option value="">Choose a category</option>
                            <?php
                            $result = $conn->query("SELECT id, name FROM categories");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name
                        </label>
                        <input 
                            type="text" 
                            name="product_name" 
                            id="product_name" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-design-teal focus:border-design-teal"
                            placeholder="Enter product name"
                        >
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="product_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Price
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">₹</span>
                            <input 
                                type="number" 
                                name="product_price" 
                                id="product_price" 
                                required 
                                class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-design-teal focus:border-design-teal"
                                placeholder="0.00"
                            >
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="product_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Image
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-design-teal transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="product_image" class="relative cursor-pointer rounded-md font-medium text-design-teal hover:text-design-teal/80">
                                        <span>Upload a file</span>
                                        <input id="product_image" name="product_image" type="file" accept="image/*" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            name="submit" 
                            class="w-full bg-design-teal text-white py-2 px-4 rounded-md hover:bg-design-teal/90 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-design-teal"
                        >
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 