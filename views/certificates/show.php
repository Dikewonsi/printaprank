<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($template['title']) ?></title>
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

  <div class="max-w-6xl mx-auto py-12 px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white shadow-lg rounded-lg p-8">

      <!-- Certificate Image -->
      <div class="flex flex-col items-center">
        <img src="<?= htmlspecialchars($template['image']) ?>" 
             alt="<?= htmlspecialchars($template['title']) ?>" 
             class="rounded-lg shadow-md max-w-full h-auto">
      </div>

      <!-- Product Details + Form -->
      <div class="flex flex-col justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-4">
            <?= htmlspecialchars($template['title']) ?>
          </h1>
          <p class="text-gray-600 mb-6">
            <?= nl2br(htmlspecialchars($template['description'])) ?>
          </p>
          <p class="text-2xl font-semibold text-indigo-600 mb-6">
            $<?= number_format($template['price'], 2) ?>
          </p>
        </div>

        <!-- Awardee Name Form -->
        <form method="post" action="/cart/add" class="space-y-6">
          <input type="hidden" name="product_id" value="<?= $template['id'] ?>">

          <div>
            <label for="awardee_name" class="block text-sm font-medium text-gray-700 mb-2">
              Awardee Name
            </label>
            <input type="text" id="awardee_name" name="awardee_name" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
          </div>

          <button type="submit"
                  class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700 transition">
            Save & Add to Cart
          </button>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
