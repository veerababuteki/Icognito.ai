<div class="bg-white rounded-lg shadow-lg p-8 max-w-3xl mx-auto">
    <!-- Success Animation -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">🎉 Your Chatbot is Ready!</h2>
        <p class="text-gray-600 text-lg mb-8">Congratulations! You've successfully set up your chatbot.</p>
    </div>

    <!-- Next Steps Section -->
    <div class="bg-gray-50 p-6 rounded-lg mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Next Steps:</h3>
        <ol class="list-decimal list-inside space-y-3 text-gray-700">
            <li>Log in to your dashboard to manage your chatbot</li>
            <li>Configure additional bot settings and preferences</li>
            <li>Test your chatbot's responses</li>
            <li>Copy and paste the widget code to your website</li>
        </ol>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-center space-x-4">
        <a href="admin/login.php" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Login to Dashboard
        </a>
        <a href="chatform.php?step=1" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create Another Bot
        </a>
    </div>
</div>

<style>
    /* Additional Animations */
    @keyframes slideIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .bg-white {
        animation: slideIn 0.5s ease-out;
    }

    /* Hover Effects */
    .bg-purple-600:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
    }

    .bg-gray-200:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Adjustments */
    @media (max-width: 640px) {
        .flex {
            flex-direction: column;
        }
        .space-x-4 {
            margin-top: 1rem;
        }
        .space-x-4 > * {
            margin: 0.5rem 0;
        }
    }
</style> 