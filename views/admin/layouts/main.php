<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrintaPrank Admin Panel</title>
    
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body class="bg-gray-50 flex h-screen">

    <div class="w-64 bg-gray-800 text-white flex flex-col border-r border-gray-700 pr-6">
        <div class="p-6 text-xl font-bold border-b border-gray-700">
            PrintaPrank Admin
        </div>
        <nav class="flex-grow pl-4 py-4 space-y-2">
            <a href="/admin/dashboard" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                🏠 Dashboard
            </a>
            <a href="/admin/users" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                👥 Users
            </a>
            <a href="/admin/products" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                📜 Products/Certs
            </a>
            <a href="/admin/memberships" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                💎 Memberships
            </a>
            <a href="/admin/orders" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                📦 Orders
            </a>
            <a href="/admin/logout" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-red-700 text-red-300 pt-4">
                ➡️ Logout
            </a>
        </nav>
    </div>

    <main class="flex-1 overflow-y-auto p-8">