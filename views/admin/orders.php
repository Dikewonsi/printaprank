<?php 
// views/admin/orders.php
require __DIR__ . '/layouts/main.php'; 
?>

<div class="space-y-6">
    
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-3xl font-extrabold text-gray-900">
            📦 Order & Download Status Overview
        </h2>
        <a href="#" 
           class="px-4 py-2 bg-gray-500 text-white font-medium text-sm rounded-md shadow-md hover:bg-gray-600 transition duration-150 ease-in-out flex items-center space-x-1"
        >
            <span>🔍</span>
            <span>Filter Orders</span>
        </a>
    </div>

    <?php if (!empty($orders)): ?>
        
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Txn ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Awardee Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Downloaded?
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($orders as $order): ?>
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($order['transaction_id'] ?? 'N/A') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?= htmlspecialchars($order['user_name'] ?? 'Guest') ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                            <?= htmlspecialchars($order['certificate_title'] ?? 'N/A') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($order['awardee_name'] ?? 'N/A') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            $<?= htmlspecialchars($order['amount'] ?? '0.00') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <?= htmlspecialchars($order['transaction_status'] ?? 'N/A') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php 
                                $isDownloaded = $order['is_downloaded'];
                                if ($isDownloaded):
                            ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Yes
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    <?= htmlspecialchars($order['last_downloaded_at'] ? date('Y-m-d', strtotime($order['last_downloaded_at'])) : '') ?>
                                </div>
                            <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Details</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    <?php else: ?>
        <div class="p-6 bg-blue-50 border-l-4 border-blue-400 text-blue-700 rounded-lg">
            <p class="font-medium">No transactions or orders found in the database.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
// CRITICAL: Close the HTML tags opened by layouts/main.php
?>
</main>
</body>
</html>