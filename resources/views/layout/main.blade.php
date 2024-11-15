<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@0.7.4/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.15/lib/index.min.js"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Optionally, you can include your custom styles here -->
    @stack('styles') <!-- For additional styles injected by child views -->
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Main Content Wrapper -->
<div class="container mx-auto py-8">
    @yield('content')  <!-- Main content of the page -->
</div>

<!-- Optionally, you can include your custom scripts here -->
@stack('scripts') <!-- For additional scripts injected by child views -->

</body>
</html>
