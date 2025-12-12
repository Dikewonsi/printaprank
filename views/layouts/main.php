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
    <nav class="space-x-6 flex items-center">
      <a href="/certificates" class="text-gray-700 hover:text-indigo-600">Store</a>
      <a href="/cart" class="text-gray-700 hover:text-indigo-600">Cart</a>

      <?php if (!isset($_SESSION['user'])): ?>
        <!-- Guest links -->
        <a href="/login" class="text-gray-700 hover:text-indigo-600">Login</a>
        <a href="/register" class="text-gray-700 hover:text-indigo-600">Register</a>
      <?php else: ?>
        <!-- Logged-in user -->
        <a href="/dashboard" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
        <span class="text-gray-500">
          Hello, <?= htmlspecialchars($_SESSION['user']['name']) ?>
        </span>

        <?php
          // Show membership badge if user has a plan
          if (!empty($_SESSION['user']['membership_id'])) {
              $membershipRepo = new \App\repositories\MembershipRepository();
              $membership = $membershipRepo->find($_SESSION['user']['membership_id']);
              if ($membership) {
                  echo '<span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full ';
                  switch (strtolower($membership->name)) {
                      case 'basic':
                          echo 'bg-gray-200 text-gray-800';
                          break;
                      case 'pro':
                          echo 'bg-indigo-100 text-indigo-700';
                          break;
                      case 'ultimate':
                          echo 'bg-yellow-100 text-yellow-700';
                          break;
                      default:
                          echo 'bg-gray-100 text-gray-600';
                  }
                  echo '">' . htmlspecialchars($membership->name) . '</span>';
              }
          }
        ?>
        <!-- Logout button -->
        <a href="/logout" 
           class="ml-4 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
          Logout
        </a>
      <?php endif; ?>
    </nav>
  </div>
</header>