<?php 
// views/admin/products.php
require __DIR__ . '/layouts/main.php'; 
?>

<div class="space-y-6">
    
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-3xl font-extrabold text-gray-900">
            📜 Certificate Product Management
        </h2>
        
        <a href="#" 
           class="px-4 py-2 bg-indigo-600 text-white font-medium text-sm rounded-md shadow-md hover:bg-indigo-700 transition duration-150 ease-in-out flex items-center space-x-1"
        >
            <span>+</span>
            <span>Create New Certificate</span>
        </a>
    </div>

    <?php if (!empty($products)): ?>
        
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description (Excerpt)
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($products as $certificate): // PHP logic is unchanged ?>
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($certificate->id ?? 'N/A') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                            <?= htmlspecialchars($certificate->title ?? 'Untitled') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            $<?= htmlspecialchars($certificate->price ?? '0.00') ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-sm">
                            <?php
                                // PHP excerpt logic remains the same
                                $desc = $certificate->description ?? '';
                                $excerpt = htmlspecialchars(substr($desc, 0, 50));
                            ?>
                            <p class="truncate max-w-sm"><?= $excerpt ? $excerpt . '...' : 'No description' ?></p>
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
        <div class="p-6 bg-blue-50 border-l-4 border-blue-400 text-blue-700 rounded-lg">
            <p class="font-medium">No certificate products found in the database.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
// CRITICAL: Close the HTML tags opened by layouts/main.php
?>
</main>
</body>
</html>