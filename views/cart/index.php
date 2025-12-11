<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
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
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Your Cart</h1>

    <?php if (empty($cartWithDetails)): ?>
      <p class="text-gray-600">Your cart is empty.</p>
    <?php else: ?>
      <div class="space-y-6">
        <?php foreach ($cartWithDetails as $item): ?>
          <div class="bg-white shadow rounded-lg p-6 flex items-center justify-between">
            <!-- Product Info -->
            <div class="flex items-center space-x-6">
              <img src="<?= htmlspecialchars($item['image']) ?>" 
                   alt="<?= htmlspecialchars($item['title']) ?>" 
                   class="w-24 h-24 object-cover rounded-lg shadow">

              <div>
                <h2 class="text-xl font-semibold text-gray-800">
                  <?= htmlspecialchars($item['title']) ?>
                </h2>
                <p class="text-gray-600 text-sm mb-2">
                  <?= htmlspecialchars($item['description']) ?>
                </p>
                <p class="text-gray-700">
                  <span class="font-medium">Awardee:</span> <?= htmlspecialchars($item['awardee_name']) ?>
                </p>
              </div>
            </div>

            <!-- Price -->
            <div class="text-right">
              <p class="text-lg font-bold text-indigo-600">
                $<?= number_format($item['price'], 2) ?>
              </p>
                <form method="post" action="/checkout">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Checkout
                    </button>
                </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>
