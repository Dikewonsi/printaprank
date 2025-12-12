
<?php 
// views/admin/memberships.php
require __DIR__ . '/../layouts/main.php'; 
?>

  <div class="max-w-7xl mx-auto py-12 px-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-12 text-center">
      Choose Your Membership Plan
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php foreach ($memberships as $plan): ?>
        <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col 
                    <?= $plan->highlight ? 'border-2 border-indigo-600' : '' ?>">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            <?= htmlspecialchars($plan->name) ?>
          </h2>
          <p class="text-gray-600 mb-6">
            <?= htmlspecialchars($plan->description) ?>
          </p>
          <p class="text-3xl font-bold text-indigo-600 mb-6">
            $<?= number_format($plan->price, 2) ?> / month
          </p>
          <ul class="text-gray-700 mb-6 space-y-2">
            <li>✔ Download limit: <?= htmlspecialchars($plan->download_limit) ?></li>
            <li>✔ Access to templates</li>
            <li><?= $plan->priority_support ? '✔ Priority support' : '✘ No priority support' ?></li>
          </ul>
         <!-- Add to Cart Form --> <form method="post" action="/cart/add" class="mt-auto"> <input type="hidden" name="membership_id" value="<?= $plan->id ?>"> <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700 transition"> Add <?= htmlspecialchars($plan->name) ?> to Cart </button> </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</body>
</html>


