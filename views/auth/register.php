<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Create Account</h1>

    <form method="POST" action="/register" class="space-y-6">
      <!-- Name -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
        <input type="text" id="name" name="name" placeholder="Your Name" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
      </div>

      <!-- Submit Button -->
      <button type="submit"
              class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700 transition">
        Register
      </button>
    </form>

    <!-- Extra Links -->
    <p class="mt-6 text-center text-sm text-gray-600">
      Already have an account?
      <a href="/login" class="text-indigo-600 hover:underline">Login</a>
    </p>
  </div>

</body>
</html>
