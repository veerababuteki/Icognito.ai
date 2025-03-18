<?php
require('connection.inc.php');

$msg = '';
$success = false;

if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    // Check if admin user already exists
    $check_sql = "SELECT * FROM admin_users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($con, $check_sql);

    if(mysqli_num_rows($result) > 0) {
        $msg = "Admin user or email already exists!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert admin user
        $sql = "INSERT INTO admin_users (username, password, email, role) VALUES ('$username', '$hashed_password', '$email', '$role')";
        
        if(mysqli_query($con, $sql)) {
            $success = true;
            $msg = "Admin user created successfully!";
        } else {
            $msg = "Error creating admin user: " . mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin - BotControl Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="text-center text-3xl font-extrabold text-gray-700">BotControl Hub</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Create Admin Account</p>
        </div>
        
        <?php if($msg != '') { ?>
            <div class="<?php echo $success ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'; ?> px-4 py-3 rounded relative border" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($msg); ?></span>
            </div>
        <?php } ?>

        <form class="mt-8 space-y-6" method="post" autocomplete="off">
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username" required
                               class="appearance-none rounded relative block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-500 focus:border-gray-500 focus:z-10 sm:text-sm"
                               placeholder="Enter username">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email" required
                               class="appearance-none rounded relative block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-500 focus:border-gray-500 focus:z-10 sm:text-sm"
                               placeholder="Enter email">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="appearance-none rounded relative block w-full px-3 py-2 pl-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-500 focus:border-gray-500 focus:z-10 sm:text-sm"
                               placeholder="Enter password">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-semibold mb-2">Role</label>
                    <select id="role" name="role" class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-500 focus:border-gray-500 focus:z-10 sm:text-sm">
                        <option value="subscriber">Subscriber</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>
            </div>

            <div>
                <button type="submit" name="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-gray-500 group-hover:text-gray-400"></i>
                    </span>
                    Create Admin Account
                </button>
            </div>
            
            <?php if($success) { ?>
                <div class="text-center mt-4">
                    <a href="login.php" class="text-sm text-gray-600 hover:text-gray-500">
                        Go to Login Page
                    </a>
                </div>
            <?php } ?>
        </form>
    </div>
</body>
</html> 