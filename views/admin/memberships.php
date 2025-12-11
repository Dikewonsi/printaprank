<?php 
// views/admin/memberships.php
require __DIR__ . '/layouts/main.php'; 
?>

<div class="space-y-6">
    
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-3xl font-extrabold text-gray-900">
            💎 Membership Plan Overview
        </h2>
        
        <a href="#" 
           class="px-4 py-2 bg-indigo-600 text-white font-medium text-sm rounded-md shadow-md hover:bg-indigo-700 transition duration-150 ease-in-out flex items-center space-x-1"
        >
            <span>+</span>
            <span>Create New Plan</span>
        </a>
    </div>

    <?php if (!empty($memberships)): ?>
        
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Features
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($memberships as $membership): ?>
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($membership->id ?? 'N/A') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($membership->name ?? 'Untitled') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            $<?= htmlspecialchars($membership->price ?? '0.00') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($membership->features ?? 'None listed') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <span class="text-gray-300 mx-2">|</span>
                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    <?php else: ?>
        <div class="p-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 rounded-lg">
            <p class="font-medium">No membership plans found in the database.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
// CRITICAL: Close the HTML tags opened by layouts/main.php
?>
</main>
</body>
</html>