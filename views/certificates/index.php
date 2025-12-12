<?php 
// views/admin/memberships.php
require __DIR__ . '/../layouts/main.php'; 
?>

 <!-- Hero Section -->
<section class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white py-20">
  <div class="absolute inset-0 bg-black/20"></div>
  <div class="relative max-w-7xl mx-auto px-6 text-center">
    <h1 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg">
      Discover Fun Certificate Templates
    </h1>
    <p class="text-lg md:text-xl mb-8 opacity-90">
      Customize, prank, and celebrate with unique certificates.
    </p>
    <a href="/certificates" 
       class="inline-block bg-white text-indigo-700 font-semibold px-8 py-3 rounded-full shadow-lg hover:scale-105 hover:bg-gray-100 transition transform duration-300">
      Browse Templates
    </a>
  </div>
</section>

<!-- Product Grid -->
<main class="max-w-7xl mx-auto py-16 px-6">
  <h2 class="text-4xl font-bold text-gray-800 mb-12 text-center tracking-tight">
    Certificate Templates
  </h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
    <?php foreach ($templates as $t): ?>
      <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2 flex flex-col">
        <div class="relative">
          <img src="<?= htmlspecialchars($t->image ?? '') ?>" 
               alt="<?= htmlspecialchars($t->title ?? '') ?>" 
               class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
        </div>

        <div class="p-6 flex-1 flex flex-col">
          <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition">
            <?= htmlspecialchars($t->title ?? '') ?>
          </h3>
          <p class="text-gray-600 mb-4 line-clamp-3">
            <?= htmlspecialchars($t->description ?? '') ?>
          </p>
          <p class="text-2xl font-bold text-indigo-600 mb-6">
            $<?= number_format($t->price ?? 0, 2) ?>
          </p>

          <!-- Button -->
          <a href="/editor/<?= $t->id ?>"
             class="mt-auto block text-center bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700 hover:scale-105 transition transform duration-300">
            View / Customize
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-8 mt-16">
  <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
    <p class="text-sm">&copy; <?= date('Y') ?> <span class="font-semibold text-white">PrintaPrank</span>. All rights reserved.</p>
    <nav class="space-x-6 text-sm">
      <a href="/about" class="hover:text-white transition">About</a>
      <a href="/contact" class="hover:text-white transition">Contact</a>
      <a href="/privacy" class="hover:text-white transition">Privacy Policy</a>
    </nav>
  </div>
</footer>


</body>
</html>
