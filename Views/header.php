<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Palmora - E-Commerce Kelapa Sawit</title>
  <script src="https://cdn.tailwindcss.com "></script>
</head>
<body class="bg-gray-50 text-gray-900">
  <header class="bg-white shadow-md p-4 sticky top-0 z-10">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold text-green-700">Palmora</h1>
      <?php if (isset($_SESSION['user'])): ?>
        <span>Halo, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
      <?php endif; ?>
    </div>
  </header>