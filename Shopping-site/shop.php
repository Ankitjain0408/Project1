<?php include('includes/auth_check.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop - DesignVision</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-heading {
      background-image: linear-gradient(to right, #475569, #0d9488, #f97316);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    :root {
      --background: 210 20% 98%;
      --foreground: 215 25% 27%;
      --card: 0 0% 100%;
      --card-foreground: 215 25% 27%;
      --popover: 0 0% 100%;
      --popover-foreground: 215 25% 27%;
      --primary: 215 25% 27%;
      --primary-foreground: 210 20% 98%;
      --secondary: 41 100% 92%;
      --secondary-foreground: 215 25% 27%;
      --muted: 220 14% 96%;
      --muted-foreground: 220 8% 46%;
      --accent: 169 89% 32%;
      --accent-foreground: 210 20% 98%;
      --destructive: 0 84% 60%;
      --destructive-foreground: 210 20% 98%;
      --border: 220 13% 91%;
      --input: 220 13% 91%;
      --ring: 169 89% 32%;
      --radius: 0.5rem;
    }
    
    * {
      border-color: hsl(var(--border));
    }
    
    body {
      background-color: hsl(var(--background));
      color: hsl(var(--foreground));
      font-family: 'Inter', sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6 {
      font-family: 'Montserrat', sans-serif;
    }
    
    /* Custom components */
    .gradient-heading {
      background-image: linear-gradient(to right, #475569, #0d9488, #f97316);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    
    .ar-button {
      position: relative;
      overflow: hidden;
      background-color: #0d9488;
      color: white;
      font-weight: 500;
      padding: 0.75rem 1.5rem;
      border-radius: 0.375rem;
      transition: all 0.3s;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .ar-button:hover {
      background-color: rgba(13, 148, 136, 0.9);
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .card-hover {
      transition: all 0.3s;
    }
    .card-hover {
  border: 1px solid hsl(var(--border));
  transition: transform 0.3s, box-shadow 0.3s;
}

    
    .card-hover:hover {
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      transform: translateY(-4px);
    }
    
    /* Animation */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
  </style>
  
  <!-- Tailwind Config -->
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
        <a href="shop.php" class="text-design-teal font-medium">Shop</a>
        <a href="design.php" class="text-design-dark hover:text-design-teal transition-colors">Designs</a>
        <a href="ar.php" class="text-design-dark hover:text-design-teal transition-colors">AR Studio</a>
        <a href="aboutus.php" class="text-design-dark hover:text-design-teal transition-colors">About us</a>
        <!-- <a href="#testimonials" class="text-design-dark hover:text-design-teal transition-colors">Testimonials</a> -->
      </div>
        <div class="flex items-center space-x-4">
            <a href="orders.php" class="flex items-center text-design-dark hover:text-design-teal transition-colors group">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-design-coral text-white text-xs rounded-full w-5 h-5 flex items-center justify-center transform scale-100 group-hover:scale-110 transition-transform">
                            <?php echo count($_SESSION['cart']); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <span class="hidden sm:inline group-hover:text-design-teal transition-colors">Your Cart</span>
            </a>

            <?php if(isset($_SESSION['username'])): ?>
                <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php">
                    <button class="bg-design-teal hover:bg-design-teal/90 text-white px-4 py-2 rounded-md transition-all duration-300 hover:shadow-md">
                        Logout
                    </button>
                </a>
            <?php else: ?>
                <a href="login.php">
                    <button class="bg-design-teal hover:bg-design-teal/90 text-white px-4 py-2 rounded-md transition-all duration-300 hover:shadow-md">
                        Login
                    </button>
                </a>
            <?php endif; ?>
          </div>
        </div>
      </nav>

  <?php
  session_start();
  $conn = new mysqli("localhost", "root", "", "shopdb");

  // Handle add to cart
  $addedToCart = false;
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
      $product_id = (int)$_POST['product_id'];
      if (!isset($_SESSION['cart'])) {
          $_SESSION['cart'] = [];
      }
      $_SESSION['cart'][] = $product_id;
      $addedToCart = true;
  }

  // Handle remove from cart
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
      $remove_id = (int)$_POST['remove_product_id'];
      if (isset($_SESSION['cart'])) {
          // Remove only one instance of the product
          $key = array_search($remove_id, $_SESSION['cart']);
          if ($key !== false) {
              unset($_SESSION['cart'][$key]);
              $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
          }
      }
  }

  // Prepare cart data
  $cart_products = [];
  $cart_total = 0;
  if (!empty($_SESSION['cart'])) {
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
  ?>

  <main class="pt-24 pb-12 container mx-auto px-4">
    <h2 class="text-4xl font-bold gradient-heading mb-10 text-center">Shop Products</h2>
    <?php
    // Display categories and products
    $cat_result = $conn->query("SELECT * FROM categories");
    while ($cat = $cat_result->fetch_assoc()) {
        echo "<section class='mb-16 pb-8 border-b border-gray-200'>";
        echo "<h3 class='text-2xl font-semibold text-gray-800 mb-6'>" . htmlspecialchars($cat['name']) . "</h3>";
        $cat_id = $cat['id'];
        $prod_result = $conn->query("SELECT * FROM products WHERE category_id = $cat_id");
        if ($prod_result->num_rows > 0) {
            echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8'>";
            while ($prod = $prod_result->fetch_assoc()) {
                echo "<div class='bg-white rounded-lg shadow-md p-4 flex flex-col items-center transition-transform hover:-translate-y-1 hover:shadow-lg'>
                        <img src='" . htmlspecialchars($prod['image']) . "' alt='" . htmlspecialchars($prod['name']) . "' class='w-full h-48 object-cover rounded mb-4'>
                        <strong class='text-lg text-gray-900 mb-2'>" . htmlspecialchars($prod['name']) . "</strong>
                        <span class='text-teal-600 font-bold text-xl mb-4'>₹" . htmlspecialchars($prod['price']) . "</span>
                        <form method='post' action='' class='w-full'>
                            <input type='hidden' name='product_id' value='" . $prod['id'] . "'>
                            <button type='submit' class='w-full py-2 bg-teal-600 hover:bg-teal-700 text-white rounded transition-colors'>Add to Cart</button>
                        </form>
                      </div>";
            }
            echo "</div>";
        } else {
            echo "<p class='text-gray-500 mb-8'>No products in this category yet.</p>";
        }
        echo "</section>";
    }
    ?>
    <!-- Cart feedback message -->
    <div id="cartMessage" class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50 text-lg font-semibold transition-all duration-300 <?php echo $addedToCart ? '' : 'hidden'; ?>">
      Product added to cart!
    </div>
  </main>

  <!-- Cart Section -->
  <?php if (!empty($cart_products)): ?>
      <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
          <h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>
          <?php foreach ($cart_products as $product): ?>
              <div class="flex justify-between items-center border-b py-4">
                  <div class="flex items-center">
                      <?php if (!empty($product['image'])): ?>
                          <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                               alt="<?php echo htmlspecialchars($product['name']); ?>" 
                               class="w-16 h-16 object-cover rounded">
                      <?php endif; ?>
                      <div class="ml-4">
                          <h3 class="font-semibold"><?php echo htmlspecialchars($product['name']); ?></h3>
                          <p class="text-gray-600">₹<?php echo number_format($product['price'], 2); ?> × <?php echo $product['quantity']; ?></p>
                      </div>
                  </div>
                  <div class="flex items-center">
                      <p class="font-semibold mr-4">₹<?php echo number_format($product['subtotal'], 2); ?></p>
                      <form method="POST" class="inline">
                          <input type="hidden" name="remove_product_id" value="<?php echo $product['id']; ?>">
                          <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                      </form>
                  </div>
              </div>
          <?php endforeach; ?>
          
          <div class="mt-6">
              <div class="flex justify-between items-center mb-4">
                  <span class="text-xl font-bold">Total:</span>
                  <span class="text-xl font-bold">₹<?php echo number_format($cart_total, 2); ?></span>
              </div>
              
              <?php if(isset($_SESSION['user_id'])): ?>
                  <!-- User is logged in, show checkout button -->
                  <a href="orders.php" 
                     class="block w-full bg-design-teal text-white text-center py-3 rounded-md hover:bg-design-teal/90 transition-colors">
                      Proceed to Checkout
                  </a>
              <?php else: ?>
                  <!-- User is not logged in, show login button -->
                  <div class="text-center">
                      <p class="text-gray-600 mb-2">Please log in to checkout</p>
                      <a href="login.php" 
                         class="block w-full bg-design-teal text-white text-center py-3 rounded-md hover:bg-design-teal/90 transition-colors">
                          Log in to Checkout
                      </a>
                  </div>
              <?php endif; ?>
          </div>
      </div>
  <?php else: ?>
      <div class="text-center py-8">
          <p class="text-gray-600">Your cart is empty</p>
          <a href="shop.php" class="text-design-teal hover:text-design-teal/90 mt-2 inline-block">Continue Shopping</a>
      </div>
  <?php endif; ?>

  <!-- Mobile Menu Button (Add if needed) -->
  <div class="md:hidden">
      <button class="mobile-menu-button p-2 focus:outline-none">
          <svg class="h-6 w-6 text-design-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
      </button>
  </div>

  <!-- Mobile Menu (Hidden by default) -->
  <div class="mobile-menu hidden md:hidden">
      <a href="index.php" class="block py-2 px-4 text-sm hover:bg-gray-50">Home</a>
      <a href="shop.php" class="block py-2 px-4 text-sm hover:bg-gray-50">Shop</a>
      <a href="design.php" class="block py-2 px-4 text-sm hover:bg-gray-50">Designs</a>
      <a href="ar.php" class="block py-2 px-4 text-sm hover:bg-gray-50">AR Studio</a>
      <a href="aboutus.php" class="block py-2 px-4 text-sm hover:bg-gray-50">About us</a>
  </div>

  <!-- Optional: Add JavaScript for Mobile Menu Toggle -->
  <script>
      // Mobile menu toggle
      const mobileMenuButton = document.querySelector('.mobile-menu-button');
      const mobileMenu = document.querySelector('.mobile-menu');

      if(mobileMenuButton && mobileMenu) {
          mobileMenuButton.addEventListener('click', () => {
              mobileMenu.classList.toggle('hidden');
          });
      }
  </script>
</body>
</html>
