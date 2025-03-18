<div class="bg-white rounded-lg shadow p-6 text-center">
    <div class="mb-6">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-semibold mb-2">Oops! Something went wrong</h2>
        <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($error_msg); ?></p>
        
        <div class="space-x-4">
            <a href="chatform.php?step=1" class="inline-block px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Start Over
            </a>
            <a href="admin/support.php" class="inline-block px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Contact Support
            </a>
        </div>
    </div>
</div> 