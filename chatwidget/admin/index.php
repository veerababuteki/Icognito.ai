<?php
require('connection.inc.php');
require('functions.inc.php');

// Check admin authentication
check_admin_auth();

require('top.php');
?>

            <!-- Dashboard Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Stats Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <i class="fas fa-robot text-blue-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500">Total Bots</p>
                                <p class="text-2xl font-bold"><?php echo $botCount; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 mr-4">
                                <i class="fas fa-comments text-green-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500">Total Conversations</p>
                                <p class="text-2xl font-bold">125</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 mr-4">
                                <i class="fas fa-users text-purple-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500">Active Users</p>
                                <p class="text-2xl font-bold">48</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bot Activity -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="border-b p-4">
                        <h2 class="font-semibold">Recent Bot Activity</h2>
                    </div>
                    <div class="p-4">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4">Bot Name</th>
                                    <th class="text-left py-3 px-4">Last Active</th>
                                    <th class="text-left py-3 px-4">Messages</th>
                                    <th class="text-left py-3 px-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4"><?php echo $row['company_name']; ?></td>
                                    <td class="py-3 px-4">Today, 10:30 AM</td>
                                    <td class="py-3 px-4">42</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if ($settingsCount == 0) { ?>
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No bots found. <a href="addbot.php" class="text-gray-600">Add a new bot</a>.</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow">
                        <div class="border-b p-4">
                            <h2 class="font-semibold">Quick Actions</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <a href="addbot.php" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                    <i class="fas fa-plus-circle text-gray-500 text-xl mb-2"></i>
                                    <span>Add New Bot</span>
                                </a>
                                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                    <i class="fas fa-cog text-gray-500 text-xl mb-2"></i>
                                    <span>Bot Settings</span>
                                </a>
                                <a href="#" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                    <i class="fas fa-palette text-gray-500 text-xl mb-2"></i>
                                    <span>Theme Editor</span>
                                </a>
                                <a href="widget_code.php" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                    <i class="fas fa-code text-gray-500 text-xl mb-2"></i>
                                    <span>Get Widget Code</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow">
                        <div class="border-b p-4">
                            <h2 class="font-semibold">System Status</h2>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <div class="flex justify-between mb-1">
                                    <span>API Health</span>
                                    <span>95%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 95%"></div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="flex justify-between mb-1">
                                    <span>Server Load</span>
                                    <span>45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span>Database</span>
                                    <span>78%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

?>