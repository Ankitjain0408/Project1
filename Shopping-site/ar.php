<?php session_start(); ?>
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
                <a href="ar.php" class="text-design-teal font-medium">AR Studio</a>
                <a href="aboutus.php" class="text-design-dark hover:text-design-teal transition-colors">About us</a>
            </div>
            
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
                        <button class="bg-design-teal hover:bg-design-teal/90 text-white px-4 py-2 rounded-md">Logout</button>
                    </a>
                <?php else: ?>
                    <a href="login.php">
                        <button class="bg-design-teal hover:bg-design-teal/90 text-white px-4 py-2 rounded-md">Login</button>
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
        <div class="mobile-menu hidden md:hidden absolute top-full left-0 right-0 bg-white border-t border-gray-100">
            <div class="container mx-auto px-4 py-2">
                <a href="index.php" class="block py-2 text-design-dark hover:text-design-teal">Home</a>
                <a href="shop.php" class="block py-2 text-design-dark hover:text-design-teal">Shop</a>
                <a href="design.php" class="block py-2 text-design-dark hover:text-design-teal">Designs</a>
                <a href="ar.php" class="block py-2 text-design-teal font-medium">AR Studio</a>
                <a href="aboutus.php" class="block py-2 text-design-dark hover:text-design-teal">About us</a>
                <a href="orders.php" class="block py-2 text-design-dark hover:text-design-teal">
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
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-20">
        <!-- Title -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-design-dark mb-4">Design Your Space</h1>
            <p class="text-gray-600">Upload your room photo and add furniture to visualize your design</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Design Area -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-4">
                <!-- Image Upload Area -->
                <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center mb-4">
                    <input type="file" 
                           id="roomImage" 
                           accept="image/*" 
                           class="hidden" 
                           onchange="handleImageUpload(event)">
                    <label for="roomImage" class="cursor-pointer">
                        <div class="space-y-4">
                            <i class="fas fa-cloud-upload-alt text-4xl text-design-teal"></i>
                            <p class="text-gray-600">Click to upload your room photo or drag and drop</p>
                            <button class="bg-design-teal text-white px-6 py-2 rounded-md hover:bg-design-teal/90 transition-colors">
                                Select Photo
                            </button>
                        </div>
                    </label>
                </div>

                <!-- Design Canvas -->
                <div id="designArea" class="design-area h-[500px] bg-gray-100 rounded-lg relative hidden">
                    <!-- Room Image Container -->
                    <img id="roomImageDisplay" class="w-full h-full object-contain" src="" alt="Room Preview">
                    <!-- Furniture items will be added here dynamically -->
                </div>

                <!-- Controls -->
                <div class="flex justify-between mt-4">
                    <button onclick="undoLastAction()" class="text-gray-600 hover:text-design-teal">
                        <i class="fas fa-undo mr-2"></i>Undo
                    </button>
                    <!-- <button onclick="saveDesign()" class="bg-design-coral text-white px-6 py-2 rounded-md hover:bg-design-coral/90 transition-colors">
                        <i class="fas fa-download mr-2"></i>Save Design
                    </button> -->
                </div>
            </div>

            <!-- Furniture Panel -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-design-dark">Furniture Items</h2>
                
                <!-- Furniture Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Sofa -->
                    <div class="furniture-option p-4 bg-gray-50 rounded-lg text-center cursor-pointer hover:bg-gray-100 transition-colors"
                         onclick="addFurniture('sofa')">
                        <img src="Images/sofa (2).png" 
                             alt="Modern Sofa" 
                             class="w-full h-32 object-contain mb-2">
                        <p class="font-medium">Modern Sofa</p>
                        <p class="text-sm text-gray-600">₹24,999</p>
                    </div>

                    <!-- Chair -->
                    <div class="furniture-option p-4 bg-gray-50 rounded-lg text-center cursor-pointer hover:bg-gray-100 transition-colors"
                         onclick="addFurniture('chair')">
                        <img src="Images/chair (2).png" 
                             alt="Accent Chair" 
                             class="w-full h-32 object-contain mb-2">
                        <p class="font-medium">Accent Chair</p>
                        <p class="text-sm text-gray-600">₹12,999</p>
                    </div>

                    <!-- Table -->
                    <div class="furniture-option p-4 bg-gray-50 rounded-lg text-center cursor-pointer hover:bg-gray-100 transition-colors"
                         onclick="addFurniture('table')">
                        <img src="Images/table.png" 
                             alt="Coffee Table" 
                             class="w-full h-32 object-contain mb-2">
                        <p class="font-medium">Coffee Table</p>
                        <p class="text-sm text-gray-600">₹8,999</p>
                    </div>

                    <!-- Lamp -->
                    <div class="furniture-option p-4 bg-gray-50 rounded-lg text-center cursor-pointer hover:bg-gray-100 transition-colors"
                         onclick="addFurniture('lamp')">
                        <img src="Images/lamp (2).png" 
                             alt="Floor Lamp" 
                             class="w-full h-32 object-contain mb-2">
                        <p class="font-medium">Floor Lamp</p>
                        <p class="text-sm text-gray-600">₹4,999</p>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-semibold text-design-dark mb-2">How to use:</h3>
                    <ol class="text-gray-600 space-y-2 text-sm">
                        <li>1. Upload your room photo</li>
                        <li>2. Click on furniture items to add them</li>
                        <li>3. Drag items to position them</li>
                        <li>4. Use scroll wheel to resize items</li>
                        <li>5. Double-click to remove items</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update the furniture items data with transparent background image URLs
        const furnitureItems = {
            sofa: { 
                src: 'Images/sofa (2).png',
                width: 250,
                price: 24999
            },
            chair: { 
                src: 'Images/chair (2).png',
                width: 180,
                price: 12999
            },
            table: { 
                src: 'Images/table.png',
                width: 200,
                price: 8999
            },
            lamp: { 
                src: 'Images/lamp (2).png',
                width: 150,
                price: 4999
            }
        };

        let actionHistory = [];
        const designArea = document.getElementById('designArea');
        const uploadArea = document.getElementById('uploadArea');
        const roomImageDisplay = document.getElementById('roomImageDisplay');

        // Handle image upload
        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    roomImageDisplay.src = e.target.result;
                    designArea.classList.remove('hidden');
                    uploadArea.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Enable drag and drop for room image
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('uploadArea');

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-design-teal');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-design-teal');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-design-teal');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        roomImageDisplay.src = e.target.result;
                        designArea.classList.remove('hidden');
                        uploadArea.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });

        // Add furniture to design area
        function addFurniture(type) {
            const item = furnitureItems[type];
            if (!item) {
                console.error('Furniture type not found:', type);
                return;
            }

            console.log('Adding furniture:', type, 'with src:', item.src);

            // Create loading indicator
            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-design-teal';
            loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin fa-2x"></i>';
            designArea.appendChild(loadingIndicator);

            const furniture = document.createElement('img');
            furniture.src = item.src;
            furniture.className = 'furniture-item absolute';
            furniture.style.width = item.width + 'px';
            furniture.style.left = '50%';
            furniture.style.top = '50%';
            furniture.style.transform = 'translate(-50%, -50%)';
            furniture.style.zIndex = '10';
            furniture.draggable = false;
            
            // Add error handling for image loading
            furniture.onload = () => {
                console.log('Furniture image loaded successfully:', type);
                loadingIndicator.remove();
                designArea.appendChild(furniture);
                makeDraggable(furniture);
                actionHistory.push(furniture);
            };
            
            furniture.onerror = (error) => {
                console.error('Error loading furniture image:', item.src, error);
                loadingIndicator.remove();
                alert('Failed to load furniture image. Please check the console for details.');
            };

            // Add event listeners for interaction
            furniture.addEventListener('dblclick', () => {
                furniture.remove();
                actionHistory = actionHistory.filter(item => item !== furniture);
            });

            furniture.addEventListener('wheel', (e) => {
                e.preventDefault();
                const width = parseInt(furniture.style.width);
                const newWidth = width + (e.deltaY > 0 ? -10 : 10);
                if (newWidth >= 50 && newWidth <= 400) {
                    furniture.style.width = newWidth + 'px';
                }
            });
        }

        // Update the makeDraggable function
        function makeDraggable(element) {
            let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            
            element.onmousedown = dragMouseDown;

            function dragMouseDown(e) {
                e.preventDefault();
                // Get the mouse cursor position at startup
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e.preventDefault();
                // Calculate the new cursor position
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // Set the element's new position
                const newTop = element.offsetTop - pos2;
                const newLeft = element.offsetLeft - pos1;
                
                // Keep the element within the design area bounds
                const designAreaRect = designArea.getBoundingClientRect();
                const elementRect = element.getBoundingClientRect();
                
                if (newTop >= 0 && newTop + elementRect.height <= designAreaRect.height) {
                    element.style.top = newTop + "px";
                }
                if (newLeft >= 0 && newLeft + elementRect.width <= designAreaRect.width) {
                    element.style.left = newLeft + "px";
                }
            }

            function closeDragElement() {
                // Stop moving when mouse button is released
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }

        // Undo last action
        function undoLastAction() {
            const lastItem = actionHistory.pop();
            if (lastItem) {
                lastItem.remove();
            }
        }

        // Save design
        function saveDesign() {
            html2canvas(designArea).then(canvas => {
                const link = document.createElement('a');
                link.download = 'room-design.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }

        // Add loading animation styles
        const loadingStyles = document.createElement('style');
        loadingStyles.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .fa-spin {
                animation: spin 1s linear infinite;
            }
        `;
        document.head.appendChild(loadingStyles);

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');

            if(mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', (e) => {
                    if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
