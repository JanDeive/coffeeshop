<?php
// Import js or css files
$assetList[] = asset("js/sample-api-request.js");

// Set menu items
$menuItems = [
    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => route('/'), 'active' => false],
    ['label' => 'Users', 'icon' => 'group', 'route' => route('/users'), 'active' => false],
    ['label' => 'Sample API Request', 'icon' => 'api', 'route' => route('/sample-api-request'), 'active' => true],
];
?>

<!-- Flex container for layout -->
<div class="flex flex-col md:flex-row gap-8 justify-center">

    <!-- Login Form -->
    <div class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">API Login | Generate JWT token</h2>
        <form id="login-form" onsubmit="event.preventDefault(); login();">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" class="w-full px-4 py-2 border rounded-md" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" class="w-full px-4 py-2 border rounded-md" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-md">Login</button>
        </form>
    </div>

    <!-- User Table -->
    <div class="w-full md:w-2/3 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">Users</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">No.</th>
                    <th class="px-4 py-2 text-left">Username</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Image</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                <!-- Users will be populated here after login -->
            </tbody>
        </table>
    </div>

</div>
