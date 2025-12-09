<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Templates</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

  <!-- Header / Navbar -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <a href="/" class="text-2xl font-bold text-indigo-600">PrintaPrank</a>

      <!-- Navigation -->
      <nav class="space-x-6">
        <a href="/products" class="text-gray-700 hover:text-indigo-600">Store</a>
        <a href="/cart" class="text-gray-700 hover:text-indigo-600">Cart</a>
        <?php if (!isset($_SESSION['user'])): ?>
          <!-- Guest links -->
          <a href="/login" class="text-gray-700 hover:text-indigo-600">Login</a>
          <a href="/register" class="text-gray-700 hover:text-indigo-600">Register</a>
        <?php else: ?>
          <!-- Logged-in user -->
          <a href="/dashboard" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
          <span class="text-gray-500">Hello, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-indigo-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h1 class="text-5xl font-bold mb-4">Discover Fun Certificate Templates</h1>
      <p class="text-lg mb-6">Customize, prank, and celebrate with unique certificates.</p>
      <a href="/products" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">
        Browse Templates
      </a>
    </div>
  </section>

  <!-- Product Grid -->
  <main class="max-w-7xl mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center">
      Certificate Templates
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($templates as $t): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition flex flex-col">
          <img src="<?= htmlspecialchars($t['image'] ?? '') ?>" 
                alt="<?= htmlspecialchars($t['title'] ?? '') ?>" 
                class="w-full h-48 object-cover">

          <div class="p-6 flex-1 flex flex-col">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">
              <?= htmlspecialchars($t['title']) ?>
            </h3>
            <p class="text-gray-600 mb-4">
              <?= htmlspecialchars($t['description']) ?>
            </p>
            <p class="text-lg font-bold text-indigo-600 mb-6">
              $<?= number_format($t['price'], 2) ?>
            </p>

            <!-- Button -->
            <a href="/editor/<?= $t['id'] ?>"
               class="mt-auto block text-center bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 transition">
              View / Customize
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-gray-300 py-6 mt-12">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
      <p>&copy; <?= date('Y') ?> PrintaPrank. All rights reserved.</p>
      <nav class="space-x-4">
        <a href="/about" class="hover:text-white">About</a>
        <a href="/contact" class="hover:text-white">Contact</a>
        <a href="/privacy" class="hover:text-white">Privacy Policy</a>
      </nav>
    </div>
  </footer>

</body>
</html>
