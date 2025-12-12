<?php 
// views/checkout/success.php
require __DIR__ . '/../layouts/main.php'; 

$orderId = $_SESSION['last_order']['order_id'] ?? ($_GET['order_id'] ?? '');
$items   = $_SESSION['last_order']['items'] ?? [];

// Separate certificates and memberships
$certificates = array_filter($items, fn($i) => $i['type'] === 'certificate');
$memberships  = array_filter($items, fn($i) => $i['type'] === 'membership');

// Calculate grand total
$total = array_sum(array_column($items, 'price'));
?>

<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-8 mt-10">
  <h1 class="text-3xl font-bold text-green-600 mb-6 text-center">Payment Successful 🎉</h1>

  <p class="text-gray-700 mb-4 text-center">
    Thank you for your order! Your order ID is 
    <span class="font-semibold text-indigo-600">
      <?= htmlspecialchars($orderId) ?>
    </span>.
  </p>

  <?php if (!empty($certificates)): ?>
    <h2 class="text-xl font-semibold mb-4">Certificates</h2>
    <div class="space-y-4 mb-6">
      <?php foreach ($certificates as $item): ?>
        <div class="bg-gray-50 rounded-lg p-4 shadow flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800">
              🎓 <?= htmlspecialchars($item['title']) ?>
            </h3>
            <p class="text-gray-600 text-sm">
              Awardee: <?= htmlspecialchars($item['awardee_name'] ?? '') ?>
            </p>
          </div>
          <div class="text-right">
            <p class="text-indigo-600 font-bold mb-2">
              $<?= number_format($item['price'] ?? 0, 2) ?>
            </p>
            <!-- Download button -->
            <a href="/certificates/download?id=<?= urlencode($item['id'] ?? '') ?>"
               class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
              Download Certificate
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($memberships)): ?>
    <h2 class="text-xl font-semibold mb-4">Memberships</h2>
    <div class="space-y-4 mb-6">
      <?php foreach ($memberships as $item): ?>
        <div class="bg-gray-50 rounded-lg p-4 shadow flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800">
              ⭐ <?= htmlspecialchars($item['title']) ?> Membership
            </h3>
            <p class="text-gray-600 text-sm">
              <?= htmlspecialchars($item['description'] ?? '') ?>
            </p>
          </div>
          <div class="text-right">
            <p class="text-indigo-600 font-bold">
              $<?= number_format($item['price'] ?? 0, 2) ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Grand Total -->
  <div class="mt-6 text-right">
    <p class="text-xl font-bold text-gray-800">
      Total: $<?= number_format($total, 2) ?>
    </p>
  </div>

  <p class="text-gray-600 mt-6 text-center">
    You’ll receive your certificates or membership details shortly.
  </p>

  <div class="text-center mt-8">
    <a href="/dashboard" 
       class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
      Go to Dashboard
    </a>
  </div>
</div>

</body>
</html>
