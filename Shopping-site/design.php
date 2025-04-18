<?php
session_start();
require_once 'includes/db_connect.php';

// Array of room categories with their descriptions and multiple images for each category
$room_categories = [
    'living-room' => [
        'title' => 'Living Room',
        'description' => 'Modern and comfortable living room designs that blend style with functionality.',
        'image' => 'https://images.unsplash.com/photo-1618219908412-a29a1bb7b86e',
        'gallery' => [
            'https://images.unsplash.com/photo-1618219740975-d40978bb7378',
            'https://images.unsplash.com/photo-1618219944342-824e40a13285',
            'https://images.unsplash.com/photo-1618219908412-a29a1bb7b86e'
        ]
    ],
    'bedroom' => [
        'title' => 'Bedroom',
        'description' => 'Peaceful and relaxing bedroom designs for your perfect sanctuary.',
        'image' => 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0',
        'gallery' => [
            'https://images.unsplash.com/photo-1616486029423-aaa4789e8c9a'
        ]
    ],
    'kitchen' => [
        'title' => 'Kitchen',
        'description' => 'Efficient and stylish kitchen designs that make cooking a pleasure.',
        'image' => 'https://images.unsplash.com/photo-1556912167-f556f1f39fdf',
        'gallery' => [
            'https://images.unsplash.com/photo-1556912173-3bb406ef7e77',
            'https://images.unsplash.com/photo-1556911220-e15b29be8c8f',
            'https://images.unsplash.com/photo-1556909212-d5b604d0c90d'
        ]
    ],
    'bathroom' => [
        'title' => 'Bathroom',
        'description' => 'Elegant bathroom designs that combine luxury with practicality.',
        'image' => 'https://images.unsplash.com/photo-1620626011761-996317b8d101',
        'gallery' => [
            'https://images.unsplash.com/photo-1584622650111-993a426fbf0a',
            'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14',
            'https://images.unsplash.com/photo-1620626011761-996317b8d101'
        ]
    ],
    'dining-room' => [
        'title' => 'Dining Room',
        'description' => 'Welcoming dining room designs for memorable family gatherings.',
        'image' => 'https://images.unsplash.com/photo-1617806118233-18e1de247200',
        'gallery' => [
            'https://images.unsplash.com/photo-1617806118233-18e1de247200',
            'https://images.unsplash.com/photo-1615920606214-6428b3324c74',
            'https://images.unsplash.com/photo-1616137466211-f939a420be84',
            'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace'
        ]
    ],
    'garden' => [
        'title' => 'Garden & Outdoor',
        'description' => 'Beautiful garden and outdoor space designs for natural living.',
        'image' => 'https://images.unsplash.com/photo-1558521558-037f1cb027c5',
        'gallery' => [
            'https://images.unsplash.com/photo-1558521558-037f1cb027c5',
            'https://images.unsplash.com/photo-1598902108854-10e335adac99'
        ]
    ],
    'office' => [
        'title' => 'Home Office',
        'description' => 'Productive and comfortable home office designs for remote work.',
        'image' => 'https://images.unsplash.com/photo-1486946255434-2466348c2166',
        'gallery' => [
            'https://images.unsplash.com/photo-1486946255434-2466348c2166',
            'https://images.unsplash.com/photo-1524758631624-e2822e304c36',
            'https://images.unsplash.com/photo-1511203466129-824e631920d7',
            'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd'
        ]
    ],
    'kids-room' => [
        'title' => 'Kids Room',
        'description' => 'Fun and functional kids room designs that grow with your child.',
        'image' => 'https://images.unsplash.com/photo-1632829882891-5047ccc421bc',
        'gallery' => [
            'https://images.unsplash.com/photo-1632829882891-5047ccc421bc'
        ]
    ]
];

// Hero section image
$hero_image = 'https://images.unsplash.com/photo-1618219908412-a29a1bb7b86e';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Designs - DesignVision</title>
    <meta name="description" content="Explore our curated collection of room designs">
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
                <a href="shop.php" class="text-design-dark hover:text-design-teal transition-colors">Shop</a>
                <a href="design.php" class="text-design-teal font-medium">Designs</a>
                <a href="ar.php" class="text-design-dark hover:text-design-teal transition-colors">AR Studio</a>
                <a href="aboutus.php" class="text-design-dark hover:text-design-teal transition-colors">About us</a>
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

        <div class="md:hidden">
            <button class="mobile-menu-button p-2 focus:outline-none">
                <svg class="h-6 w-6 text-design-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div class="mobile-menu hidden md:hidden">
            <a href="index.php" class="block py-2 px-4 text-sm hover:bg-gray-50">Home</a>
            <a href="shop.php" class="block py-2 px-4 text-sm hover:bg-gray-50">Shop</a>
            <a href="design.php" class="block py-2 px-4 text-sm hover:bg-gray-50">Designs</a>
            <a href="ar.php" class="block py-2 px-4 text-sm hover:bg-gray-50">AR Studio</a>
            <a href="aboutus.php" class="block py-2 px-4 text-sm hover:bg-gray-50">About us</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-16">
        <div class="absolute inset-0 h-[500px]">
            <img src="<?php echo $hero_image; ?>" alt="Interior Design" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-design-teal to-design-coral opacity-75"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Room Designs</h1>
            <p class="mt-6 text-xl text-gray-100 max-w-3xl">
                Explore our curated collection of room designs. Find inspiration for every space in your home.
            </p>
        </div>
    </div>

    <!-- Room Categories Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($room_categories as $slug => $category): ?>
            <div class="group relative bg-white rounded-lg shadow-sm overflow-hidden transform transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="relative h-80 w-full overflow-hidden image-card">
                    <img src="<?php echo htmlspecialchars($category['image']); ?>" 
                         alt="<?php echo htmlspecialchars($category['title']); ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        <?php echo htmlspecialchars($category['title']); ?>
                    </h3>
                    <p class="text-gray-500 mb-4">
                        <?php echo htmlspecialchars($category['description']); ?>
                    </p>
                    <button onclick="openGallery('<?php echo $slug; ?>')" 
                            class="inline-flex items-center text-design-teal hover:text-design-coral transition-colors">
                        View Designs
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div id="galleryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-lg max-w-6xl w-full mx-auto shadow-xl">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button onclick="closeGallery()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <h2 id="galleryTitle" class="text-2xl font-bold mb-4"></h2>
                    <div id="galleryContent" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Images will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to open the gallery modal
        function openGallery(slug) {
            const categories = <?php echo json_encode($room_categories); ?>;
            const category = categories[slug];
            
            if (!category) return;
            
            // Set the title
            document.getElementById('galleryTitle').textContent = category.title + ' Designs';
            
            // Clear previous content
            const galleryContent = document.getElementById('galleryContent');
            galleryContent.innerHTML = '';
            
            // Add images to the gallery
            category.gallery.forEach(imageUrl => {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative aspect-[4/3] overflow-hidden rounded-lg';
                
                const img = document.createElement('img');
                img.src = imageUrl;
                img.alt = category.title;
                img.className = 'w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer';
                
                // Add click event to show full-size image
                img.onclick = () => showFullImage(imageUrl);
                
                imgContainer.appendChild(img);
                galleryContent.appendChild(imgContainer);
            });
            
            // Show the modal
            document.getElementById('galleryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Function to close the gallery modal
        function closeGallery() {
            document.getElementById('galleryModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Function to show full-size image
        function showFullImage(imageUrl) {
            const fullImageModal = document.createElement('div');
            fullImageModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90';
            fullImageModal.onclick = () => fullImageModal.remove();
            
            const img = document.createElement('img');
            img.src = imageUrl;
            img.className = 'max-h-[90vh] max-w-[90vw] object-contain';
            
            fullImageModal.appendChild(img);
            document.body.appendChild(fullImageModal);
        }

        // Close modal when clicking outside
        document.getElementById('galleryModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('galleryModal')) {
                closeGallery();
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeGallery();
            }
        });

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