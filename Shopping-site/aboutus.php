<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - DesignVision</title>
    <meta name="description" content="Transform your space with augmented reality design tools">
    <meta name="author" content="DesignVision">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        /* Base styles */
        :root {
            --background: 210 20% 98%;
            --foreground: 215 25% 27%;
            --card: 0 0% 100%;
            --card-foreground: 215 25% 27%;
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
        
        /* Gradient heading style */
        .gradient-heading {
            background-image: linear-gradient(to right, #475569, #0d9488, #f97316);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        /* Card hover animation */
        .card-hover {
            transition: all 0.3s;
            border: 1px solid hsl(var(--border));
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
    <!-- Updated Navigation Bar -->
    <nav class="w-full bg-white/90 backdrop-blur-md py-4 fixed top-0 left-0 right-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-2">
                <div class="h-10 w-10 rounded-md bg-gradient-to-br from-design-teal to-design-coral flex items-center justify-center text-white font-bold text-xl">
                    DV
                </div>
                <h1 class="text-xl font-display font-bold tracking-tight">DesignVision</h1>
            </div>
            
            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-design-dark hover:text-design-teal transition-colors">Home</a>
                <a href="shop.php" class="text-design-dark hover:text-design-teal transition-colors">Shop</a>
                <a href="design.php" class="text-design-dark hover:text-design-teal transition-colors">Designs</a>
                <a href="ar.php" class="text-design-dark hover:text-design-teal transition-colors">AR Studio</a>
                <a href="aboutus.php" class="text-design-teal font-medium">About us</a>
            </div>
            
            <!-- Right Side Items -->
            <div class="flex items-center space-x-4">
                <!-- Cart Button with Counter -->
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

                <!-- User Authentication -->
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

        <!-- Mobile Menu Button -->
        <div class="md:hidden absolute right-4 top-4">
            <button class="mobile-menu-button p-2 focus:outline-none">
                <svg class="h-6 w-6 text-design-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu hidden md:hidden absolute top-full left-0 right-0 bg-white border-t border-gray-100 shadow-lg">
            <div class="container mx-auto px-4 py-2">
                <a href="index.php" class="block py-2 text-design-dark hover:text-design-teal">Home</a>
                <a href="shop.php" class="block py-2 text-design-dark hover:text-design-teal">Shop</a>
                <a href="design.php" class="block py-2 text-design-dark hover:text-design-teal">Designs</a>
                <a href="ar.php" class="block py-2 text-design-dark hover:text-design-teal">AR Studio</a>
                <a href="aboutus.php" class="block py-2 text-design-teal font-medium">About us</a>
                <a href="orders.php" class="block py-2 text-design-dark hover:text-design-teal flex items-center">
                    Your Cart
                    <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="ml-2 bg-design-coral text-white text-xs rounded-full px-2 py-1">
                            <?php echo count($_SESSION['cart']); ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </nav>
      <!-- About Us Section -->
<section id="about" class="pt-32 pb-20 bg-design-light">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-4xl font-bold gradient-heading mb-4">Meet Our Team</h2>
      <p class="text-lg text-design-dark mb-12">The people behind DesignVision</p>
      <div class="grid md:grid-cols-3 gap-10">
        
        <!-- Team Member 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg card-hover">
          <img src="Images/ankit.png" alt="ankit jain" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
          <h3 class="text-xl font-bold mb-1">Ankit Jain</h3>
          <p class="text-design-dark mb-2">
            Email: <a href="mailto:jaina4522@gmail.com" class="text-design-teal hover:text-design-coral">jaina4522@gmail.com</a>
          </p>
          
          <p class="text-design-dark mb-4">Phone: +917077937791</p>
          <div class="flex justify-center space-x-4">
            <a href="https://www.linkedin.com/in/ankit-jain-70898b283/" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-linkedin"></i></a>
    <a href="https://www.instagram.com/ankitjain_0408/" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-instagram"></i></a>
    <a href="https://github.com/ankitjain" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-github"></i></a>
          </div>
        </div>
        
        <!-- Team Member 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg card-hover">
          <img src="Images/sakshi.jpeg" alt="sakshi priya" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
          <h3 class="text-xl font-bold mb-1">Sakshi Priya</h3>
          <p class="text-design-dark mb-2">
            Email: <a href="mailto:sakshiswati9430@gmail.com" class="text-design-teal hover:text-design-coral">sakshiswati9430@gmail.com</a>
          </p>
          
          <p class="text-design-dark mb-4">Phone: +918102617211</p>
          <div class="flex justify-center space-x-4">
            <a href="https://www.linkedin.com/in/sakshi-priya-b68137284/" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-linkedin"></i></a>
    <a href="https://www.instagram.com/sakshi___priya/" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-instagram"></i></a>
    <a href="https://github.com/Sakshi283" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-github"></i></a>
          </div>
        </div>
        
        <!-- Team Member 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg card-hover">
          <img src="Images/soumya.jpeg" alt="saumya katiyar" class="w-40 h-40 rounded-full mx-auto mb-4 object-cover">
          <h3 class="text-xl font-bold mb-1">Saumya Katiyar</h3>
          <p class="text-design-dark mb-2">
            Email: <a href="mailto:saumyakatiyar@gmail.com" class="text-design-teal hover:text-design-coral">saumyakatiyar@gmail.com</a>
          </p>
          
          <p class="text-design-dark mb-4">Phone: +916396564986</p>
          
          <div class="flex justify-center space-x-4">
            <a href="https://www.linkedin.com/in/saumya-katiyar-302b80271/" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-linkedin"></i></a>
    <a href="https://www.instagram.com/saumya_s4/" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-instagram"></i></a>
    <a href="https://github.com/sau0mya" target="_blank" class="text-design-teal hover:text-design-coral text-3xl"><i class="fab fa-github"></i></a>
          </div>
        </div>
  
      </div>
    </div>
  </section>
   
  <!-- Footer Section -->
<footer class="bg-design-dark text-white py-12 mt-12">
  <div class="container mx-auto px-4">
    <div class="grid md:grid-cols-3 gap-12">
      
      <!-- Contact Info Section -->
      <div>
        <h3 class="text-2xl font-bold mb-4">Contact Us</h3>
        <p class="text-lg mb-2">Email: <a href="mailto:jaina4522@gmail.com" class="text-design-teal hover:text-design-coral">jaina4522@gmail.com</a></p>
        <p class="text-lg mb-2">Phone: 917077937791</p>
        
      </div>

      <!-- Quick Links Section -->
      <div>
        <h3 class="text-2xl font-bold mb-4">Quick Links</h3>
        <ul class="space-y-2">
          <li><a href="#about" class="text-lg text-white hover:text-design-teal transition-colors">About Us</a></li>
          <li><a href="#features" class="text-lg text-white hover:text-design-teal transition-colors">Features</a></li>
          <li><a href="#how-it-works" class="text-lg text-white hover:text-design-teal transition-colors">How It Works</a></li>
          <li><a href="#gallery" class="text-lg text-white hover:text-design-teal transition-colors">Gallery</a></li>
        </ul>
      </div>

      <!-- Social Media Links Section -->
      <div>
        <h3 class="text-2xl font-bold mb-4">Follow Us</h3>
        <div class="flex space-x-6">
          <a href="https://www.linkedin.com/in/sakshi-priya-b68137284/" target="_blank" class="text-white hover:text-design-coral text-3xl"><i class="fab fa-linkedin"></i></a>
          <a href="https://www.saumya_s4" target="_blank" class="text-white hover:text-design-coral text-3xl"><i class="fab fa-instagram"></i></a>
          <a href="https://Sakshi283" target="_blank" class="text-white hover:text-design-coral text-3xl"><i class="fab fa-github"></i></a>
        </div>
      </div>

    </div>

    <div class="mt-12 border-t border-design-beige pt-6 text-center">
      <p class="text-lg">&copy; 2025 DesignVision. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<!-- Add this script before closing body tag -->
<script>
    // Mobile menu toggle with improved functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        if(mobileMenuButton && mobileMenu) {
            // Toggle menu on button click
            mobileMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Close menu when window is resized to desktop view
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) { // md breakpoint
                    mobileMenu.classList.add('hidden');
                }
            });

            // Prevent menu close when clicking inside menu
            mobileMenu.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }
    });
</script>

<!-- Optional: Add this to your CSS for smoother transitions -->
<style>
    .mobile-menu {
        transition: all 0.3s ease-in-out;
    }

    .mobile-menu.hidden {
        opacity: 0;
        transform: translateY(-10px);
    }

    .mobile-menu:not(.hidden) {
        opacity: 1;
        transform: translateY(0);
    }

    /* Enhance cart badge animation */
    @keyframes cartBadgePulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .group:hover .group-hover\:scale-110 {
        animation: cartBadgePulse 0.5s ease-in-out;
    }
</style>

</body>  
</html>