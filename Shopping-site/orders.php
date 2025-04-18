<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to continue";
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "shopdb");

// Handle order cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    $order_id = intval($_POST['order_id']);
    $user_id = $_SESSION['user_id'];

    // Verify that the order belongs to the user and is pending
    $check_sql = "SELECT status FROM orders WHERE order_id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $order_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        if ($order['status'] === 'Pending') {
            // Start transaction
            $conn->begin_transaction();
            try {
                // Update order status to 'Cancelled'
                $update_sql = "UPDATE orders SET status = 'Cancelled' WHERE order_id = ? AND user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ii", $order_id, $user_id);
                $update_stmt->execute();

                // Commit transaction
                $conn->commit();
                $_SESSION['message'] = "Order #" . $order_id . " has been cancelled successfully.";
            } catch (Exception $e) {
                // Rollback transaction on error
                $conn->rollback();
                $_SESSION['error'] = "Error cancelling order. Please try again.";
            }
        } else {
            $_SESSION['error'] = "Only pending orders can be cancelled.";
        }
    } else {
        $_SESSION['error'] = "Order not found or unauthorized.";
    }
    
    // Redirect to refresh the page
    header("Location: orders.php");
    exit();
}

// Initialize variables
$cart_products = [];
$cart_total = 0;

// Get cart items if they exist
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', $_SESSION['cart']));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    $products_by_id = [];
    while ($row = $result->fetch_assoc()) {
        $products_by_id[$row['id']] = $row;
    }
    // Count quantities
    $quantities = array_count_values($_SESSION['cart']);
    foreach ($quantities as $pid => $qty) {
        if (isset($products_by_id[$pid])) {
            $prod = $products_by_id[$pid];
            $prod['quantity'] = $qty;
            $prod['subtotal'] = $qty * $prod['price'];
            $cart_products[] = $prod;
            $cart_total += $prod['subtotal'];
        }
    }
}

// Process order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (empty($_POST['shipping_address']) || empty($_POST['phone'])) {
        $_SESSION['error'] = "Please fill in all required fields";
    } else {
        $shipping_address = $_POST['shipping_address'];
        $phone = $_POST['phone'];
        $payment_method = $_POST['payment_method'] ?? 'Cash on Delivery';

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert into orders table
            $sql = "INSERT INTO orders (user_id, total_amount, shipping_address, status) 
                    VALUES (?, ?, ?, 'Pending')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ids", $_SESSION['user_id'], $cart_total, $shipping_address);
            $stmt->execute();
            
            $order_id = $conn->insert_id;

            // Insert order items
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price_per_unit, subtotal) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            foreach($cart_products as $product) {
                $subtotal = $product['price'] * $product['quantity'];
                $stmt->bind_param("iiids", 
                    $order_id, 
                    $product['id'], 
                    $product['quantity'], 
                    $product['price'], 
                    $subtotal
                );
                $stmt->execute();
            }

            // Commit transaction
            $conn->commit();
            
            // Clear the cart
            unset($_SESSION['cart']);
            
            $_SESSION['message'] = "Order placed successfully! Your order number is #" . $order_id;
            header("Location: orders.php");
            exit();

        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $_SESSION['error'] = "Error placing order. Please try again.";
        }
    }
}

// Get user's previous orders
$user_id = $_SESSION['user_id'];
$orders_sql = "SELECT o.*, COUNT(oi.item_id) as total_items 
               FROM orders o 
               LEFT JOIN order_items oi ON o.order_id = oi.order_id 
               WHERE o.user_id = ? 
               GROUP BY o.order_id 
               ORDER BY o.order_date DESC";
$stmt = $conn->prepare($orders_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders & Checkout - DesignVision</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap">
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
    <nav class="w-full bg-white/90 backdrop-blur-md py-4 fixed top-0 left-0 right-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="h-10 w-10 rounded-md bg-gradient-to-br from-design-teal to-design-coral flex items-center justify-center text-white font-bold text-xl">
                    DV
                </div>
                <h1 class="text-xl font-display font-bold tracking-tight">DesignVision</h1>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-design-dark hover:text-design-teal transition-colors">Home</a>
                <a href="shop.php" class="text-design-dark hover:text-design-teal transition-colors">Shop</a>
                <a href="design.php" class="text-design-dark hover:text-design-teal transition-colors">Designs</a>
                <a href="aboutus.php" class="text-design-dark hover:text-design-teal transition-colors">About us</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <?php if(isset($_SESSION['username'])): ?>
                    <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="bg-design-teal hover:bg-design-teal/90 text-white px-4 py-2 rounded-md">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 mt-20">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Checkout Section (if cart is not empty) -->
            <?php if (!empty($cart_products)): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold mb-4">Checkout</h2>
                    
                    <!-- Cart Summary -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-3">Order Summary</h3>
                        <?php foreach($cart_products as $product): ?>
                            <div class="flex justify-between items-center border-b py-2">
                                <div>
                                    <p class="font-semibold"><?php echo htmlspecialchars($product['name']); ?></p>
                                    <p class="text-sm text-gray-600">
                                        ₹<?php echo number_format($product['price'], 2); ?> × <?php echo $product['quantity']; ?>
                                    </p>
                                </div>
                                <p class="font-semibold">₹<?php echo number_format($product['subtotal'], 2); ?></p>
                            </div>
                        <?php endforeach; ?>
                        <div class="mt-3 text-right">
                            <p class="text-lg font-bold">Total: ₹<?php echo number_format($cart_total, 2); ?></p>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <form method="POST" class="space-y-4">
                        <div>
                            <label for="shipping_address" class="block text-gray-700 font-semibold mb-2">
                                Shipping Address
                            </label>
                            <textarea 
                                name="shipping_address" 
                                id="shipping_address" 
                                required
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-design-teal"
                                rows="3"
                                placeholder="Enter your complete shipping address"
                            ></textarea>
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700 font-semibold mb-2">
                                Phone Number
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                id="phone" 
                                required
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-design-teal"
                                placeholder="Enter your phone number"
                            >
                        </div>

                        <div>
                            <label for="payment_method" class="block text-gray-700 font-semibold mb-2">
                                Payment Method
                            </label>
                            <select 
                                name="payment_method" 
                                id="payment_method" 
                                required
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-design-teal"
                            >
                                <option value="Cash on Delivery">Cash on Delivery</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <a href="shop.php" class="text-design-teal hover:text-design-teal/90">
                                ← Back to Shop
                            </a>
                            <button 
                                type="submit" 
                                name="place_order" 
                                class="bg-design-teal text-white py-2 px-6 rounded-lg hover:bg-design-teal/90 transition-colors"
                            >
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Previous Orders Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">Your Orders</h2>
                
                <?php if ($orders_result->num_rows > 0): ?>
                    <div class="space-y-4">
                        <?php while ($order = $orders_result->fetch_assoc()): ?>
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-semibold">Order #<?php echo $order['order_id']; ?></h3>
                                        <p class="text-sm text-gray-600">
                                            Placed on <?php echo date('F j, Y', strtotime($order['order_date'])); ?>
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Items: <?php echo $order['total_items']; ?>
                                        </p>
                                        <p class="text-sm font-medium mt-1">
                                            Total: ₹<?php echo number_format($order['total_amount'], 2); ?>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block px-3 py-1 rounded-full text-sm 
                                            <?php echo $order['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                    ($order['status'] === 'Cancelled' ? 'bg-red-100 text-red-800' : 
                                                    'bg-green-100 text-green-800'); ?>">
                                            <?php echo $order['status']; ?>
                                        </span>
                                        <?php if ($order['status'] === 'Pending'): ?>
                                            <form onsubmit="return confirmCancel()" method="POST" class="mt-2">
                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                <button 
                                                    type="submit"
                                                    name="cancel_order"
                                                    class="text-sm text-red-600 hover:text-red-800 font-medium"
                                                >
                                                    Cancel Order
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No orders found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    function confirmCancel() {
        return confirm('Are you sure you want to cancel this order? This action cannot be undone.');
    }
    </script>
</body>
</html>