<?php 
// views/admin/users.php
require __DIR__ . '/layouts/main.php'; 
?>

<div class="space-y-6">
    
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-3xl font-extrabold text-gray-900">
            👥 User Management
        </h2>
        
        <a href="#" 
           class="px-4 py-2 bg-indigo-600 text-white font-medium text-sm rounded-md shadow-md hover:bg-indigo-700 transition duration-150 ease-in-out flex items-center space-x-1"
        >
            <span>+</span>
            <span>Create New User</span>
        </a>
    </div>

    <?php if (!empty($users)): ?>
        
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
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($user->id) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            <?= htmlspecialchars($user->name) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($user->email) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php 
                                $is_admin = ($user->role === 'admin');
                                $role_class = $is_admin ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $role_class ?>">
                                <?= htmlspecialchars($user->role) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="/admin/users/edit/<?= $user->id ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <span class="text-gray-300 mx-2">|</span>
                            <a href="/admin/users/delete/<?= $user->id ?>" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    <?php else: ?>
        <div class="p-6 bg-blue-50 border-l-4 border-blue-400 text-blue-700 rounded-lg">
            <p class="font-medium">No users found in the database.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
// CRITICAL: Close the HTML tags opened by layouts/main.php
?>
</main>
</body>
</html>