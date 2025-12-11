<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - PrintaPrank</title>
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body class="bg-gray-100">

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body class="bg-gray-50 flex h-screen">

    <main class="flex-1 overflow-y-auto p-8">

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-xl">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">
            🔒 Admin Login
        </h2>
        
        <form method="POST" action="/admin/login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address:
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required 
                    class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter admin email"
                >
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password:
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter password"
                >
            </div>
            
            <div>
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                >
                    Log In as Admin
                </button>
            </div>
        </form>
    </div>
</div>
<?php 
// 🔑 CRITICAL: Close the tags opened by auth.php 
?>
</body>
</html>