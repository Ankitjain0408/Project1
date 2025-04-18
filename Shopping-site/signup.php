<?php
$errors = [];
$success = '';

// Add session start at the top
session_start();

// Add this at the beginning to check if we need to reset the form
if(isset($_POST['reset_form'])) {
    // Clear all verification-related session variables
    unset($_SESSION['show_verification']);
    unset($_SESSION['verification_code']);
    unset($_SESSION['temp_username']);
    unset($_SESSION['temp_email']);
    unset($_SESSION['temp_password']);
    unset($_SESSION['code_expiry']);
    // Redirect to clear POST data
    header("Location: signup.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "shopdb"; // Use your main database

    $conn = mysqli_connect($server, $dbUsername, $dbPassword, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Handle Generate Code button click
    if(isset($_POST['generate_code'])) {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        // Validation
        if (empty($username)) {
            $errors['username'] = "Username is required.";
        }

        if (empty($email)) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }

        if (empty($password)) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Password must be at least 6 characters long.";
        }

        // Check if email already exists
        if (empty($errors)) {
            $check_email = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($check_email);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $errors['email'] = "Email already exists.";
            }
            $stmt->close();
        }

        // If no errors, generate code and send email
        if (empty($errors)) {
            $verification_code = rand(100000, 999999);
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['temp_username'] = $username;
            $_SESSION['temp_email'] = $email;
            $_SESSION['temp_password'] = $password;
            $_SESSION['show_verification'] = true;
            $_SESSION['code_expiry'] = time() + (10 * 60); // 10 minutes expiry

            // Send email
            $to = $email;
            $subject = "Verification Code for Sign Up";
            $message = "Your verification code is: " . $verification_code . "\n\n";
            $message .= "This code will expire in 10 minutes.";
            $headers = "From: your-email@domain.com";

            if(mail($to, $subject, $message, $headers)) {
                $success = "Verification code sent to your email.";
            } else {
                $errors['email'] = "Failed to send verification code.";
            }
        }
    }

    // Handle verification code submission
    if(isset($_POST['verify_code'])) {
        $entered_code = trim($_POST['verification_code']);
        $current_time = time();
        
        // Debug information
        error_log("Entered Code: " . $entered_code);
        error_log("Stored Code: " . $_SESSION['verification_code']);
        error_log("Expiry Time: " . $_SESSION['code_expiry']);
        error_log("Current Time: " . $current_time);

        // Check if code has expired
        if(!isset($_SESSION['code_expiry']) || $current_time > $_SESSION['code_expiry']) {
            $errors['verification'] = "Verification code has expired. Please request a new code.";
            unset($_SESSION['verification_code']);
        }
        // Check if code matches
        elseif(!isset($_SESSION['verification_code']) || $entered_code != $_SESSION['verification_code']) {
            $errors['verification'] = "Invalid verification code. Please try again.";
        }
        // If code is valid and not expired
        else {
            $username = $_SESSION['temp_username'];
            $email = $_SESSION['temp_email'];
            $password = $_SESSION['temp_password'];
            
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user';

            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $passwordHash, $role);

            if (mysqli_stmt_execute($stmt)) {
                // Clear all session variables
                unset($_SESSION['verification_code']);
                unset($_SESSION['temp_username']);
                unset($_SESSION['temp_email']);
                unset($_SESSION['temp_password']);
                unset($_SESSION['show_verification']);
                unset($_SESSION['code_expiry']);
                
                $_SESSION['success_message'] = "Account created successfully! Please login.";
                header("Location: login.php");
                exit();
            } else {
                $errors['db'] = "Error creating account: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Handle resend code
    if(isset($_POST['resend_code']) && isset($_SESSION['temp_email'])) {
        $verification_code = rand(100000, 999999);
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['code_expiry'] = time() + (10 * 60); // Reset expiry time
        
        $to = $_SESSION['temp_email'];
        $subject = "New Verification Code for Sign Up";
        $message = "Your new verification code is: " . $verification_code . "\n\n";
        $message .= "This code will expire in 10 minutes.";
        $headers = "From: your-email@domain.com";
        
        if(mail($to, $subject, $message, $headers)) {
            $success = "New verification code has been sent to your email.";
        } else {
            $errors['email'] = "Failed to send new verification code.";
        }
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
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
    <script>
        // Function to show alert with verification code
        function showVerificationCode(code) {
            alert(code);
        }
    </script>
  </head>
  <body class="bg-white">
    <?php
    // Show verification code in alert if it exists
    if(isset($_SESSION['show_code']) && $_SESSION['show_code']) {
        echo "<script>showVerificationCode('" . $_SESSION['code_message'] . "');</script>";
        $_SESSION['show_code'] = false; // Reset the flag
    }
    ?>

    <div class="flex min-h-screen">
      <!-- Left side - Form -->
      <div class="flex flex-1 flex-col justify-center px-8 sm:px-12 md:px-16 lg:px-24">
        <div class="mx-auto w-full max-w-sm sm:max-w-md">
          <h1 class="text-4xl font-bold mb-8 md:text-5xl text-gray-900">Create new account.</h1>
          
          <?php if (!empty($errors)): ?>
            <div class="bg-red-100 text-red-700 px-6 py-4 rounded mb-6">
                <ul class="list-disc pl-5">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
          <?php endif; ?>
          
          <form id="signupForm" class="space-y-6" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <!-- Username Input -->
            <div class="relative">
                <input
                    type="text"
                    id="firstName"
                    name="username"
                    placeholder="Username"
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    class="flex w-full rounded-md border border-gray-200 bg-gray-50 px-4 pr-10 py-6 text-base focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="5"></circle>
                    <path d="M20 21a8 8 0 0 0-16 0"></path>
                </svg>
            </div>

            <!-- Email Input -->
            <div class="relative">
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    class="flex w-full rounded-md border border-gray-200 bg-gray-50 px-4 pr-10 py-6 text-base focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
            </div>

            <!-- Password Input -->
            <div class="relative">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    class="flex w-full rounded-md border border-gray-200 bg-gray-50 px-4 pr-10 py-6 text-base focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-transparent"
                />
                <button
                    type="button"
                    id="togglePassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"
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

            <!-- Generate Code Button -->
            <?php if(!isset($_SESSION['show_verification'])): ?>
                <button 
                    type="submit" 
                    name="generate_code" 
                    class="w-full bg-design-teal hover:bg-design-teal/90 text-white px-4 py-3 rounded-md font-medium"
                >
                    Generate Verification Code
                </button>
            <?php endif; ?>
          </form>
          
          <?php if(isset($_SESSION['show_verification'])): ?>
              <!-- Verification form appears after code is generated -->
              <div id="verificationSection" class="mt-6 p-6 bg-gray-50 rounded-lg border border-gray-200">
                  <h3 class="text-lg font-semibold mb-4">Enter Verification Code</h3>
                  
                  <?php if (!empty($errors['verification'])): ?>
                      <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                          <?php echo htmlspecialchars($errors['verification']); ?>
                      </div>
                  <?php endif; ?>

                  <?php if (!empty($success)): ?>
                      <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                          <?php echo htmlspecialchars($success); ?>
                      </div>
                  <?php endif; ?>
                  
                  <!-- Add timer display -->
                  <div class="mb-4">
                      <p class="text-sm text-gray-600">Time remaining: 
                          <span id="timer" class="font-medium text-design-teal"></span>
                      </p>
                  </div>

                  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="space-y-4">
                      <div class="relative">
                          <input
                              type="text"
                              name="verification_code"
                              placeholder="Enter 6-digit code"
                              class="flex w-full rounded-md border border-gray-200 bg-white px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-design-teal focus:border-transparent"
                              maxlength="6"
                              pattern="\d{6}"
                              required
                          />
                      </div>
                      
                      <div class="flex gap-4">
                          <button 
                              type="submit" 
                              name="verify_code" 
                              class="flex-1 bg-design-teal hover:bg-design-teal/90 text-white px-4 py-3 rounded-md font-medium"
                          >
                              Verify & Create Account
                          </button>
                          
                          <button 
                              type="submit" 
                              name="resend_code" 
                              class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-3 rounded-md font-medium"
                          >
                              Resend Code
                          </button>
                      </div>
                      
                      <p class="text-sm text-gray-500 text-center mt-4">
                          Didn't receive the code? Check your spam folder or click "Resend Code"
                      </p>
                  </form>
              </div>

              <!-- Add JavaScript for countdown timer -->
              <script>
                  function updateTimer() {
                      const expiryTime = <?php echo $_SESSION['code_expiry'] ?? 0; ?> * 1000; // Convert to milliseconds
                      const now = new Date().getTime();
                      const timeLeft = expiryTime - now;

                      if (timeLeft <= 0) {
                          document.getElementById('timer').innerHTML = "Code expired";
                          return;
                      }

                      const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                      const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                      document.getElementById('timer').innerHTML = 
                          minutes + "m " + seconds + "s";

                      if (timeLeft > 0) {
                          setTimeout(updateTimer, 1000);
                      }
                  }

                  // Start the timer when page loads
                  updateTimer();
              </script>
          <?php endif; ?>
          
          <!-- Add a reset button if verification is shown but user wants to change details -->
          <?php if(isset($_SESSION['show_verification']) && $_SESSION['show_verification']): ?>
              <form method="post" class="mt-4">
                  <button 
                      type="submit" 
                      name="reset_form" 
                      class="text-design-teal hover:text-design-teal/90 text-sm"
                  >
                      Want to change your details? Click here to reset
                  </button>
              </form>
          <?php endif; ?>
          
          <p class="mt-10 text-center text-sm text-gray-500">
            Already have an account?
            <a href="login.php" class="font-medium text-blue-600 hover:underline ml-1">
              Log In
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

      // Form submission
      document.getElementById('signupForm').addEventListener('submit', function(e) {
        // e.preventDefault();
        
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!firstName || !lastName || !email || !password) {
          alert('Please fill in all fields');
          return;
        }
        
        // Show success message
        alert('Account created successfully!');
        
        // Reset form
        this.reset();
      });
    </script>
  </body>
</html>
