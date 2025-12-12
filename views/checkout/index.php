<?php 
// views/checkout/index.php
require __DIR__ . '/../layouts/main.php'; 
?>

<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-8 mt-10">
  <h1 class="text-2xl font-bold mb-6 text-gray-800">Checkout</h1>

  <?php if (isset($plan)): ?>
    <!-- Membership checkout -->
    <div class="bg-gray-50 rounded-lg p-6 shadow mb-6">
      <h2 class="text-xl font-semibold mb-4"><?= htmlspecialchars($plan->name) ?> Membership</h2>
      <p class="text-gray-600 mb-4"><?= htmlspecialchars($plan->description ?? '') ?></p>
      <p class="text-lg font-bold text-indigo-600 mb-6">
        $<?= number_format($plan->price, 2) ?> / month
      </p>
      <input type="hidden" name="plan_id" value="<?= $plan->id ?>">
    </div>
  <?php else: ?>
    <!-- Cart checkout -->
    <?php if (!empty($cartWithDetails)): ?>
      <h2 class="text-xl font-semibold mb-6">Your Cart</h2>
      <div class="space-y-6">
        <?php 
          $total = 0;
          foreach ($cartWithDetails as $item): 
            $total += $item['price'] ?? 0;
        ?>
          <div class="bg-gray-50 rounded-lg p-6 shadow flex items-center justify-between">
            <div class="flex items-center space-x-6">
              <?php if ($item['type'] === 'certificate'): ?>
                <img src="<?= htmlspecialchars($item['image'] ?? '') ?>" 
                     alt="<?= htmlspecialchars($item['title']) ?>" 
                     class="w-24 h-24 object-cover rounded-lg shadow">
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">
                    <?= htmlspecialchars($item['title']) ?>
                  </h3>
                  <p class="text-gray-600 text-sm mb-2">
                    Awardee: <?= htmlspecialchars($item['awardee_name'] ?? '') ?>
                  </p>
                </div>
              <?php elseif ($item['type'] === 'membership'): ?>
                <div>
                  <h3 class="text-lg font-semibold text-gray-800">
                    <?= htmlspecialchars($item['title']) ?> Membership
                  </h3>
                  <p class="text-gray-600 text-sm mb-2">
                    <?= htmlspecialchars($item['description'] ?? '') ?>
                  </p>
                  <p class="text-gray-600 text-sm">
                    Download limit: <?= htmlspecialchars($item['download_limit'] ?? '') ?>
                  </p>
                  <p class="text-gray-600 text-sm">
                    <?= !empty($item['priority_support']) ? 'Priority support included' : 'No priority support' ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-indigo-600">
                $<?= number_format($item['price'] ?? 0, 2) ?>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Grand Total -->
      <div class="mt-6 text-right">
        <p class="text-xl font-bold text-gray-800">
          Total: $<?= number_format($total, 2) ?>
        </p>
      </div>
    <?php else: ?>
      <p class="text-gray-600">Cart is empty.</p>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Payment form -->
  <form method="POST" action="/checkout/process" class="space-y-4 mt-10">
    <div>
      <label class="block text-sm font-medium text-gray-700">Card Number</label>
      <input type="text" value="4242 4242 4242 4242"
             class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="flex space-x-4">
      <div class="flex-1">
        <label class="block text-sm font-medium text-gray-700">Expiry</label>
        <input type="text" value="12/30"
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
      </div>
      <div class="flex-1">
        <label class="block text-sm font-medium text-gray-700">CVC</label>
        <input type="text" value="123"
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
      </div>
    </div>
    <button type="submit"
            class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700 transition">
      Pay Now
    </button>
  </form>
</div>

</body>
</html>
