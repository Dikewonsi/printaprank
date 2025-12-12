
<?php 
// views/admin/memberships.php
require __DIR__ . '/../layouts/main.php'; 
?>

 <div class="max-w-6xl mx-auto py-16 px-6">
  <h1 class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight text-center">
    Your Cart
  </h1>

  <?php if (empty($cartWithDetails)): ?>
    <div class="bg-white shadow-lg rounded-xl p-10 text-center">
      <p class="text-gray-500 text-lg">🛒 Your cart is empty.</p>
      <a href="/certificates" 
         class="mt-6 inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-indigo-700 transition transform hover:scale-105">
        Browse Certificates
      </a>
    </div>
  <?php else: ?>
    <div class="space-y-6">
      <?php foreach ($cartWithDetails as $index => $item): ?>
        <div class="bg-white shadow-md rounded-xl p-6 flex items-center justify-between hover:shadow-xl transition transform hover:-translate-y-1">
          <div>
            <?php if ($item['type'] === 'certificate'): ?>
              <h2 class="text-xl font-semibold text-gray-900 mb-1"><?= htmlspecialchars($item['title']) ?></h2>
              <p class="text-gray-600">Awardee: <?= htmlspecialchars($item['awardee_name'] ?? '') ?></p>
            <?php elseif ($item['type'] === 'membership'): ?>
              <h2 class="text-xl font-semibold text-gray-900 mb-2"><?= htmlspecialchars($item['title']) ?> Membership</h2>
              <p class="text-gray-600 mb-1"><?= htmlspecialchars($item['description'] ?? '') ?></p>
              <p class="text-gray-700">Download limit: <?= htmlspecialchars($item['download_limit'] ?? '') ?></p>
              <p class="text-gray-700">
                <?= !empty($item['priority_support']) ? '✔ Priority support included' : '✘ No priority support' ?>
              </p>
            <?php endif; ?>
          </div>
          <div class="text-right">
            <p class="text-xl font-bold text-indigo-600">
              $<?= number_format($item['price'] ?? 0, 2) ?>
            </p>
            <!-- Delete button -->
            <form method="post" action="/cart/remove" class="mt-3">
              <input type="hidden" name="index" value="<?= $index ?>">
              <button type="submit"
                      class="text-red-600 hover:text-red-800 text-sm font-semibold transition">
                Remove
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (!empty($cartWithDetails)): ?>
        <div class="mt-10 text-center">
          <form method="get" action="/checkout">
            <button type="submit"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105">
              Proceed to Checkout
            </button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>


</body>
</html>
