<?php include('../includes/auth_check.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Features</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white p-10 rounded-lg shadow-lg flex flex-col items-center space-y-8">
    <h1 class="text-3xl font-bold mb-4 text-gray-800">Admin Features</h1>
    <div class="flex flex-col space-y-4 w-full">
      <a href="add_category.php" class="w-full">
        <button class="w-full py-4 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-lg font-semibold transition-colors">
          Add Category
        </button>
      </a>
      <a href="add_product.php" class="w-full">
        <button class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-lg font-semibold transition-colors">
          Add Product
        </button>
      </a>
      <a href="remove_product.php" class="w-full">
        <button class="w-full py-4 bg-red-500 hover:bg-red-600 text-white rounded-lg text-lg font-semibold transition-colors">
          Remove Products
        </button>
      </a>
      <a href="orders.php" class="w-full">
        <button class="w-full py-4 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-lg font-semibold transition-colors flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
          View Orders
        </button>
      </a>
      <a href="../logout.php" class="w-full">
        <button class="w-full py-4 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-lg font-semibold transition-colors flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          Logout
        </button>
      </a>
    </div>
  </div>
</body>
</html>

