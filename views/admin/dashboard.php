<?php 
// views/admin/dashboard.php

// Use the main layout (which includes the header, Tailwind link, and sidebar)
require __DIR__ . '/layouts/main.php'; 
?>

<div class="space-y-8">
    
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-3xl font-extrabold text-gray-900">
            Welcome, Administrator!
        </h2>
        
        <a href="/admin/logout" 
           class="px-4 py-2 bg-red-600 text-white font-medium text-sm rounded-md shadow-sm hover:bg-red-700 transition duration-150 ease-in-out"
        >
           ➡️ Logout
        </a>
    </div>

    <p class="text-gray-600">This is your central control panel for PrintaPrank. Use the links below to manage the platform's core data.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-indigo-500">
            <p class="text-sm font-medium text-gray-500">Total Users</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">105</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
            <p class="text-sm font-medium text-gray-500">Total Orders</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">42</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
            <p class="text-sm font-medium text-gray-500">Active Products</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">15</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-pink-500">
            <p class="text-sm font-medium text-gray-500">Downloads Today</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">18</p>
        </div>
    </div>

    <div class="space-y-4 pt-4">
        <h3 class="text-2xl font-semibold text-gray-800">🚀 Quick Access</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <a href="/admin/users" class="flex items-center justify-center p-6 bg-indigo-50 border border-indigo-200 rounded-lg text-lg font-medium text-indigo-700 hover:bg-indigo-100 transition duration-150 ease-in-out">
                👥 View and Manage Users
            </a>
            
            <a href="/admin/memberships" class="flex items-center justify-center p-6 bg-purple-50 border border-purple-200 rounded-lg text-lg font-medium text-purple-700 hover:bg-purple-100 transition duration-150 ease-in-out">
                💎 Manage Membership Plans
            </a>
            
            <a href="/admin/products" class="flex items-center justify-center p-6 bg-teal-50 border border-teal-200 rounded-lg text-lg font-medium text-teal-700 hover:bg-teal-100 transition duration-150 ease-in-out">
                📜 Manage Products
            </a>
            
            <a href="/admin/orders" class="flex items-center justify-center p-6 bg-blue-50 border border-blue-200 rounded-lg text-lg font-medium text-blue-700 hover:bg-blue-100 transition duration-150 ease-in-out">
                📦 View All Orders
            </a>
            
        </div>
    </div>
</div>

<?php 
// CRITICAL: Close the HTML tags opened by layouts/main.php
?>
</main>
</body>
</html>