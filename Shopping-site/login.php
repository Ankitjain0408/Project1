<?php
session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "shopdb"; // Use your main database

    // Create a connection to the database
    $conn = mysqli_connect($server, $dbUsername, $dbPassword, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Validate input
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    // If no errors, proceed to login
    if (empty($errors)) {
        // SQL query to fetch user based on username
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die('Error preparing statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if user exists and password is correct
        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                // Store user information in session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Check if there's a redirect URL stored in session
                if (isset($_SESSION['redirect_after_login'])) {
                    $redirect = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    header("Location: " . $redirect);
                } else {
                    // Redirect based on role
                    if ($user['role'] === 'admin') {
                        header("Location: admin/features.php");
                    } else {
                        header("Location: index.php");
                    }
                }
                exit();
            } else {
                $errors['login'] = "Invalid username or password.";
            }
        } else {
            $errors['login'] = "User not found.";
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: 'Inter', sans-serif;
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
  <body class="bg-white">
    
    <?php if (!empty($errors)): ?>
      <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
        <!-- <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
          <h2 class="text-2xl font-bold mb-6 text-center">Login</h2> -->
    <div class="flex min-h-screen">
      <!-- Left side - Form -->
      <div class="flex flex-1 flex-col justify-center px-8 sm:px-12 md:px-16 lg:px-24">
        <div class="mx-auto w-full max-w-sm sm:max-w-md">
          <h1 class="text-4xl font-bold mb-8 md:text-5xl text-gray-900">Log in to your account.</h1>
          
          <form id="loginForm" class="space-y-6" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="space-y-2">
              <div class="relative">
                <input
                  type="text"
                  id="username"
                  name="username"
                  placeholder="Username"
                  class="flex w-full rounded-md border border-gray-200 bg-gray-50 px-4 pr-10 py-6 text-base focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent"
                  value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
              </div>
            </div>
            
            <div class="space-y-2">
              <div class="relative">
                <input
                  type="password"
                  id="password"
                  placeholder="Password"
                  name="password"
                  class="flex w-full rounded-md border border-gray-200 bg-gray-50 px-4 pr-10 py-6 text-base focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent"
                />
                <button
                  type="button"
                  id="togglePassword"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"
                  tabindex="-1"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-off-icon hidden">
                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                    <line x1="2" x2="22" y1="2" y2="22"></line>
                  </svg>
                </button>
              </div>
            </div>
            
            <div class="text-right">
              <a href="forgot-password.html" class="text-sm text-gray-500 hover:text-gray-700">
                Forgot your password?
              </a>
            </div>
            
            <button 
              type="submit" 
              class="w-full bg-design-teal hover:bg-design-teal/90 text-white px-4 py-2 rounded-md"
              name="login"
            >
              Login
            </button>
          </form>
          
          <p class="mt-10 text-center text-sm text-gray-500">
            Don't have an account?
            <a href="signup.php" class="font-medium text-gray-900 hover:underline ml-1">
              Create Account
            </a>
          </p>
        </div>
      </div>
      
      <!-- Right side - Image -->
      <div class="relative hidden md:block md:flex-1">
        <img
          src="Images/balcony2.avif"
          alt="Modern living room with fireplace"
          class="absolute inset-0 h-full w-full object-cover"
        />
      </div>
    </div>

    <script>
      // Toggle password visibility
      document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.querySelector('.eye-icon');
        const eyeOffIcon = document.querySelector('.eye-off-icon');
        
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          eyeIcon.classList.add('hidden');
          eyeOffIcon.classList.remove('hidden');
        } else {
          passwordInput.type = 'password';
          eyeIcon.classList.remove('hidden');
          eyeOffIcon.classList.add('hidden');
        }
      });
    </script>
  </body>
</html>