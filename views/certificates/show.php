<?php 
// views/admin/memberships.php
require __DIR__ . '/../layouts/main.php'; 
?>

  <div class="max-w-6xl mx-auto py-16 px-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white shadow-2xl rounded-2xl p-10 transform transition hover:scale-[1.01]">

    <!-- Certificate Image -->
    <div class="flex flex-col items-center">
      <img src="<?= htmlspecialchars($certificate->image) ?>" 
           alt="<?= htmlspecialchars($certificate->title) ?>" 
           class="rounded-xl shadow-lg max-w-full h-auto hover:scale-105 transition-transform duration-300">
    </div>

    <!-- Product Details + Form -->
    <div class="flex flex-col justify-between">
      <div>
        <h1 class="text-4xl font-extrabold text-gray-900 mb-6 tracking-tight">
          <?= htmlspecialchars($certificate->title) ?>
        </h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
          <?= nl2br(htmlspecialchars($certificate->description)) ?>
        </p>
        <p class="text-3xl font-bold text-indigo-600 mb-8">
          $<?= number_format($certificate->price, 2) ?>
        </p>
      </div>

      <!-- Awardee Name Form -->
      <form method="post" action="/cart/add" class="space-y-6">
        <input type="hidden" name="product_id" value="<?= $certificate->id ?>">

        <?php if ($certificate->title === '10 Square foot of Texas Creek Land (50% OFF)'): ?>
          <!-- Hardcoded external link for this certificate -->
          <a href="https://texasranchtitle.com/products/10-square-foot-of-texas-creek-land"
             target="_blank"
             class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-lg shadow-lg hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105">
            Purchase on Official Site
          </a>
        <?php else: ?>
          <div>
            <label for="awardee_name" class="block text-sm font-medium text-gray-700 mb-2">
              Awardee Name
            </label>
            <input type="text" id="awardee_name" name="awardee_name" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm">
          </div>

          <button type="submit"
                  class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-lg shadow-lg hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105">
            Save & Add to Cart
          </button>
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>


</body>
</html>
