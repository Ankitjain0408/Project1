<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DesignVision - Interior Design Visualizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .bg-gradient {
            background: linear-gradient(135deg, rgba(13,148,136,0.1) 0%, rgba(249,115,22,0.1) 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient"></div>
        <div class="absolute top-10 left-10 w-32 h-32 bg-design-teal/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-design-coral/10 rounded-full blur-3xl"></div>
        
        <!-- Main Content -->
        <div class="relative z-10 text-center max-w-3xl px-6">
            <!-- Logo and Brand -->
            <div class="mb-12 floating">
                <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-design-teal to-design-coral flex items-center justify-center text-white font-bold text-3xl mx-auto shadow-lg">
                    DV
                </div>
            </div>

            <!-- Heading and Description -->
            <h1 class="text-6xl font-extrabold mb-8 gradient-heading leading-tight">
                Transform Your Space
            </h1>
            
            <div class="space-y-6 mb-12">
                <p class="text-2xl text-gray-600 leading-relaxed">
                    Experience the future of interior design with our innovative AR platform
                </p>
                <div class="flex justify-center gap-8 text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-vr-cardboard text-design-teal text-xl"></i>
                        <span>AR Visualization</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-paint-roller text-design-coral text-xl"></i>
                        <span>Room Design</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-couch text-design-teal text-xl"></i>
                        <span>Furniture Preview</span>
                    </div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="login.php" 
                   class="inline-block bg-design-teal text-white px-8 py-4 rounded-xl font-semibold hover:bg-design-teal/90 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
                    Start Exploring
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <!-- <a href="aboutus.php" 
                   class="inline-block border-2 border-design-teal text-design-teal px-8 py-4 rounded-xl font-semibold hover:bg-design-teal/10 transition-all duration-300">
                    Learn More
                </a> -->
            </div>

            <!-- Feature Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-16">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-design-teal/10 rounded-lg flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-wand-magic-sparkles text-design-teal text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Easy to Use</h3>
                    <p class="text-gray-600 text-sm">Upload your room photo and start designing instantly</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-design-coral/10 rounded-lg flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-cube text-design-coral text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">3D Preview</h3>
                    <p class="text-gray-600 text-sm">View furniture in your space before buying</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-design-teal/10 rounded-lg flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-palette text-design-teal text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Custom Design</h3>
                    <p class="text-gray-600 text-sm">Personalize colors and arrangements</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
