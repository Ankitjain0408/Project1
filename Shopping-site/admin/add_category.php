<?php include('../includes/auth_check.php'); ?>
<?php
include('../includes/db_connect.php');

$success_message = '';
$error_message = '';

if (isset($_POST['submit'])) {
    // Get category name
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    
    // Insert category
    $insert_category = "INSERT INTO categories (name) VALUES ('$category_name')";
    if (mysqli_query($conn, $insert_category)) {
        $category_id = mysqli_insert_id($conn);

        // Handle product image upload
        $product_image = $_FILES['product_image'];
        $image_path = '../uploads/' . basename($product_image['name']);
        if (move_uploaded_file($product_image['tmp_name'], $image_path)) {
            $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
            $product_price = (int)$_POST['product_price'];
            $image_db_path = 'uploads/' . basename($product_image['name']);

            $insert_product = "INSERT INTO products (category_id, name, price, image) 
                             VALUES ($category_id, '$product_name', $product_price, '$image_db_path')";
            if (mysqli_query($conn, $insert_product)) {
                $success_message = "Category and product added successfully!";
            } else {
                $error_message = "Error adding product: " . mysqli_error($conn);
            }
        } else {
            $error_message = "Failed to upload product image.";
        }
    } else {
        $error_message = "Error adding category: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Admin Dashboard</title>
    
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
    <main class="pt-20 pb-8">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
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
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-design-dark">Add New Category</h1>
                        <p class="text-gray-600 mt-1">Create a new category and add your first product</p>
                    </div>

                    <form action="add_category.php" method="post" enctype="multipart/form-data" class="space-y-6">
                        <!-- Category Section -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold text-design-dark mb-4">Category Details</h2>
                            <div>
                                <label for="category_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category Name
                                </label>
                                <input type="text" 
                                       id="category_name" 
                                       name="category_name" 
                                       required 
                                       class="w-full p-2 border border-gray-300 rounded">
                            </div>
                        </div>

                        <h3>Add Product in This Category</h3>
                        <input type="text" name="product_name" placeholder="Product Name" required>
                        <input type="number" name="product_price" placeholder="Price" required>
                        <input type="file" name="product_image" accept="image/*" required>
                        <button type="submit" name="submit">Add Category & Product</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>