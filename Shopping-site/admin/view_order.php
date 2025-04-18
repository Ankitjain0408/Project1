<?php
session_start();
require_once '../includes/db_connect.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Get all orders with user details and items
$sql = "SELECT o.*, u.username, u.email,
        GROUP_CONCAT(CONCAT(p.name, ' (', oi.quantity, ')') SEPARATOR ', ') as items,
        SUM(oi.price_per_unit * oi.quantity) as total_amount
        FROM orders o
        JOIN users u ON o.user_id = u.id
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        LEFT JOIN products p ON oi.product_id = p.id
        GROUP BY o.order_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $update_sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $order_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Order status updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating order status.";
    }
    
    // Redirect to refresh the page
    header("Location: view_order.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Admin Dashboard</title>
    
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
                    <a href="index.php" class="text-gray-600 hover:text-design-teal">Dashboard</a>
                    <a href="../logout.php" class="bg-design-teal text-white px-4 py-2 rounded-md hover:bg-design-teal/90 transition-colors">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                <?php unset($_SESSION['success']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                <?php unset($_SESSION['error']); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="space-y-8">
            <h2 class="text-2xl font-bold">All Orders</h2>
            
            <?php while($order = $result->fetch_assoc()): ?>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <!-- Order Header -->
                    <div class="flex justify-between items-center border-b pb-4">
                        <div>
                            <h3 class="text-lg font-semibold">Order #<?php echo $order['order_id']; ?></h3>
                            <p class="text-sm text-gray-500">
                                <?php echo date('F j, Y g:i A', strtotime($order['order_date'])); ?>
                            </p>
                        </div>
                        <form method="POST" class="flex items-center space-x-2">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <select name="new_status" 
                                    onchange="this.form.submit()" 
                                    class="text-sm border rounded px-2 py-1 
                                           <?php echo match($order['status']) {
                                               'Pending' => 'bg-yellow-100',
                                               'Processing' => 'bg-blue-100',
                                               'Shipped' => 'bg-purple-100',
                                               'Delivered' => 'bg-green-100',
                                               'Cancelled' => 'bg-red-100',
                                               default => 'bg-gray-100'
                                           }; ?>">
                                <option value="Pending" <?php echo ($order['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo ($order['status'] === 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?php echo ($order['status'] === 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo ($order['status'] === 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo ($order['status'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </form>
                    </div>

                    <!-- Customer Information -->
                    <div class="grid grid-cols-2 gap-4 py-4 border-b">
                        <div>
                            <h4 class="font-medium text-gray-900">Customer Details</h4>
                            <p class="text-sm text-gray-600">Name: <?php echo htmlspecialchars($order['username']); ?></p>
                            <p class="text-sm text-gray-600">Email: <?php echo htmlspecialchars($order['email']); ?></p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Shipping Address</h4>
                            <p class="text-sm text-gray-600 whitespace-pre-line">
                                <?php echo htmlspecialchars($order['shipping_address']); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="py-4">
                        <h4 class="font-medium text-gray-900 mb-2">Order Items</h4>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($order['items']); ?></p>
                        <div class="mt-2 text-right">
                            <p class="text-sm font-medium text-gray-900">
                                Total Amount: ₹<?php echo number_format($order['total_amount'], 2); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
