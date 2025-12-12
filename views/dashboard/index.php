<?php 
// views/admin/memberships.php
require __DIR__ . '/../layouts/main.php'; 
?>

<div class="max-w-4xl mx-auto py-12 px-6">
  <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h1>

  <?php if ($membership): ?>
    <div class="bg-white shadow rounded-lg p-6 mb-8">
      <p class="text-lg text-gray-700 mb-4">
        Your current plan: 
        <span class="font-semibold text-indigo-600"><?= htmlspecialchars($membership->name) ?></span>
      </p>
      <p class="text-gray-600">
        Download limit: 
        <span class="font-medium"><?= htmlspecialchars($membership->download_limit) ?></span>
      </p>
    </div>
  <?php else: ?>
    <div class="bg-white shadow rounded-lg p-6 mb-8">
      <p class="text-lg text-gray-700 mb-4">
        You don’t have a membership yet. You can buy products individually.
      </p>
      <div class="flex space-x-4">
        <a href="/memberships" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
          View Membership Plans
        </a>
        <a href="/certificates" 
           class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
          Browse Certificates
        </a>
      </div>
    </div>
  <?php endif; ?>

  <!-- Certificates section -->
  <div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Certificates</h2>

    <?php if (!empty($certificates)): ?>
      <p class="text-gray-700 mb-4">
        You have purchased <span class="font-bold"><?= count($certificates) ?></span> certificates.
      </p>

      <ul class="space-y-3">
        <?php foreach (array_slice($certificates, 0, 3) as $cert): ?>
          <li class="flex items-center justify-between border-b pb-2">
            <div>
              <p class="text-gray-800 font-medium"><?= htmlspecialchars($cert['title']) ?></p>
              <p class="text-sm text-gray-500">Awardee: <?= htmlspecialchars($cert['awardee_name']) ?></p>
            </div>
            <a href="/storage/certificates/<?= htmlspecialchars($cert['file_name']) ?>" 
               class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition"
               download>
              Download
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-gray-600">You haven’t purchased any certificates yet.</p>
    <?php endif; ?>
  </div>

  <!-- Membership Purchase Button -->
  <div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Membership</h2>
    <p class="text-gray-600 mb-4">
      Upgrade or change your plan anytime.
    </p>
    <a href="/memberships" 
       class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
      Purchase Membership
    </a>
  </div>
</div>

</body>
</html>
