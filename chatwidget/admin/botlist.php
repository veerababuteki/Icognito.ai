<?php
require_once(__DIR__ . '/includes/Config.php');
require_once(__DIR__ . '/includes/Database.php');
require_once(__DIR__ . '/includes/Security.php');
require_once(__DIR__ . '/includes/AuthMiddleware.php');
require_once(__DIR__ . '/includes/helpers.php');

use Admin\Includes\AuthMiddleware;
use Admin\Includes\Database;
use Admin\Includes\Security;

// Initialize authentication
$auth = AuthMiddleware::getInstance();
$auth->authenticate();

// Initialize database connection
$db = Database::getInstance();

// Get user's bots
$user_id = $_SESSION['user_id'] ?? 0;
$role = $_SESSION['user_role'] ?? '';

try {
    // Prepare SQL based on user role
    if ($role === 'admin') {
        $sql = "SELECT s.*, u.username as owner_name 
                FROM settings s 
                JOIN admin_users u ON s.user_id = u.id 
                ORDER BY s.created_at DESC";
        $stmt = $db->prepare($sql);
    } else {
        $sql = "SELECT s.*, u.username as owner_name 
                FROM settings s 
                JOIN admin_users u ON s.user_id = u.id 
                WHERE s.user_id = ? 
                ORDER BY s.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $user_id);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $bots = $result->fetch_all(MYSQLI_ASSOC);
    
} catch (\Exception $e) {
    $error_msg = "Error fetching bot list: " . $e->getMessage();
    log_error('Bot list error', ['error' => $e->getMessage()]);
}

include 'top.php';
?>

<!-- Main Content Area -->
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Bot List</h1>
        <a href="addbot.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Create New Bot
        </a>
    </div>

    <?php if (isset($error_msg)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($bots)): ?>
        <div class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-3 rounded">
            <p>No bots found. Create your first bot to get started!</p>
        </div>
    <?php else: ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">BOT NAME</th>
                        <!-- <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">DOMAIN</th> -->
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">STATUS</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">CREATED ON</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($bots as $bot): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($bot['company_name']); ?>
                                </div>
                            </td>
                           <!--  <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">
                                    <?php echo htmlspecialchars($bot['api_url']); ?>
                                </div>
                            </td> -->
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php echo $bot['status'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $bot['status'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php echo date('d M Y', strtotime($bot['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="widget_code.php?id=<?php echo $bot['id']; ?>" 
                                   class="text-indigo-600 hover:text-indigo-900" title="Get Code">
                                    <i class="fas fa-code"></i> Get Code 
                                </a>
                                <a href="edit_bot.php?id=<?php echo $bot['id']; ?>" 
                                   class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    edit
                                </a>
                                <a href="../index.php?id=<?php echo $bot['id']; ?>" 
                                   class="text-green-600 hover:text-green-900" title="Preview" target="_blank">
                                    <i class="fas fa-eye"></i> Preview
                                </a>
                                <button onclick="deleteBot(<?php echo $bot['id']; ?>)" 
                                        class="text-red-600 hover:text-red-900" title="Delete">
                                    <i class="fas fa-trash"></i> delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
function deleteBot(botId) {
    if (confirm('Are you sure you want to delete this bot? This action cannot be undone.')) {
        fetch('delete_bot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                bot_id: botId,
                csrf_token: '<?php echo $_SESSION['csrf_token']; ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error deleting bot');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting bot');
        });
    }
}
</script>

<?php
// Close the main content div from top.php
echo '</div></div>';
?>