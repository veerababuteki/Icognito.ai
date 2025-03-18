<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold mb-6">Create Your Account</h2>
    <form method="post" action="">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="space-y-4">
            <div>
                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name/Username</label>
                <input type="text" id="business_name" name="business_name" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                <p class="text-sm text-gray-500 mt-1">This will be your display name in the chat widget</p>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                <p class="text-sm text-gray-500 mt-1">You'll use this email to log in to your account</p>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required minlength="8"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                <p class="text-sm text-gray-500 mt-1">Must be at least 8 characters long</p>
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>
            <div class="flex justify-between">
                <a href="chatform.php?step=2" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Back</a>
                <button type="submit" name="step3_submit" 
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Create Account</button>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});
</script> 