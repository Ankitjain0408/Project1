<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DesignVision - AR Interior Design</title>
    <meta name="description" content="Transform your space with augmented reality design tools">
    <meta name="author" content="DesignVision">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap">
    
    <!-- Custom Styles -->
    <style>
        /* Base styles */
        :root {
            --background: 210 20% 98%;
            --foreground: 215 25% 27%;
            --card: 0 0% 100%;
            --card-foreground: 215 25% 27%;
            --primary: 215 25% 27%;
            --secondary: 41 100% 92%;
            --accent: 169 89% 32%;
            --border: 220 13% 91%;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        
        .gradient-heading {
            background-image: linear-gradient(to right, #475569, #0d9488, #f97316);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
    
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
<body>
    <!-- Navigation Bar -->
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
                <a href="index.php" class="text-design-teal font-medium">Home</a>
                <a href="shop.php" class="text-design-dark hover:text-design-teal transition-colors">Shop</a>
                <a href="design.php" class="text-design-dark hover:text-design-teal transition-colors">Designs</a>
                <a href="ar.php" class="text-design-dark hover:text-design-teal transition-colors">AR Studio</a>
                <a href="aboutus.php" class="text-design-dark hover:text-design-teal transition-colors">About us</a>
            </div>
            
            <!-- Right Side Items -->
            <div class="flex items-center space-x-4">
                <!-- Cart Button -->
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

    <main>
        <!-- Hero Section -->
        <section class="relative pt-24 pb-16 md:pt-32 md:pb-24 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-white via-design-beige/20 to-design-beige/30 z-0"></div>
            <div class="container mx-auto px-4 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold mb-6 leading-tight gradient-heading">
                            Reimagine Your Space with AR
                        </h1>
                        <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-lg mx-auto md:mx-0">
                            Transform your home with our augmented reality design tool. Visualize furniture, colors, and layouts before making any changes.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                            <a href="design.php" class="inline-block">
                                <button class="bg-design-teal hover:bg-design-teal/90 text-white px-8 py-4 rounded-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    Explore Designs
                                </button>
                            </a>
                            <a href="shop.php" class="inline-block">
                                <button class="border border-design-teal text-design-teal hover:bg-design-teal/10 px-8 py-4 rounded-md transition-all duration-300">
                                    Shop Now
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="relative mt-8 md:mt-0">
                        <div class="relative rounded-xl overflow-hidden shadow-2xl animate-float">
                            <img 
                                src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=2000&q=80" 
                                alt="Interior Design Preview" 
                                class="w-full h-auto rounded-xl"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                                <div class="absolute bottom-6 left-6">
                                    <div class="bg-white/90 backdrop-blur-md rounded-lg p-4 max-w-xs">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="w-3 h-3 bg-design-teal rounded-full"></div>
                                            <p class="text-sm font-medium text-design-dark">Premium Designs</p>
                                        </div>
                                        <p class="text-xs text-design-dark/80">Explore our curated collection of interior designs</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-design-coral/10 rounded-full blur-2xl"></div>
                        <div class="absolute -top-6 -left-6 w-32 h-32 bg-design-teal/10 rounded-full blur-2xl"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Services</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Discover our range of interior design services and products
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Interior Design -->
                    <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-design-teal/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-design-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Interior Design</h3>
                        <p class="text-gray-600">Professional interior design services for your home or office</p>
                    </div>

                    <!-- Furniture Shop -->
                    <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-design-coral/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-design-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Furniture Shop</h3>
                        <p class="text-gray-600">Quality furniture and decor items for your space</p>
                    </div>

                    <!-- Design Consultation -->
                    <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-design-slate/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-design-slate" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Design Consultation</h3>
                        <p class="text-gray-600">Expert advice and consultation for your design projects</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-design-teal/10 to-design-coral/10">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Transform Your Space?</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    Start your design journey today with our expert team and premium furniture collection
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="design.php" class="inline-block">
                        <button class="bg-design-teal hover:bg-design-teal/90 text-white px-8 py-4 rounded-md transition-all duration-300 hover:shadow-lg">
                            View Designs
                        </button>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="h-8 w-8 rounded-md bg-gradient-to-br from-design-teal to-design-coral flex items-center justify-center text-white font-bold">
                            DV
                        </div>
                        <span class="font-bold">DesignVision</span>
                    </div>
                    <p class="text-gray-600 text-sm">
                        Transform your space with our expert interior design services and premium furniture collection.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="index.php" class="text-gray-600 hover:text-design-teal">Home</a></li>
                        <li><a href="shop.php" class="text-gray-600 hover:text-design-teal">Shop</a></li>
                        <li><a href="design.php" class="text-gray-600 hover:text-design-teal">Designs</a></li>
                        <li><a href="aboutus.php" class="text-gray-600 hover:text-design-teal">About Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>Email: sample@gmail.com</li>
                        <li>Phone: +91 1234567890</li>
                        <li>Address: Phagwara</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-design-teal">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-design-teal">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-design-teal">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t mt-12 pt-8 text-center text-sm text-gray-600">
                <p>&copy; 2024 DesignVision. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>