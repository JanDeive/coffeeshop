<?php
// Set menu items
$menuItems = [
    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => route('/'), 'active' => true],
    ['label' => 'Users', 'icon' => 'group', 'route' => route('/users'), 'active' => false],
    ['label' => 'Sample API Request', 'icon' => 'api', 'route' => route('/sample-api-request'), 'active' => false],
];
?>

<!-- This will go to the content area -->

<div class="py-6">
    <h1 class="text-3xl font-bold mb-6">Welcome to the Dashboard</h1>
    
    <!-- Overview Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <span class="material-icons text-blue-500 text-4xl mr-4">group</span>
                <div>
                    <h2 class="text-xl font-semibold">Users</h2>
                    <p class="text-gray-600 text-sm">Manage all users</p>
                </div>
            </div>
            <p class="mt-4 text-2xl font-bold">1,245</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <span class="material-icons text-green-500 text-4xl mr-4">shopping_cart</span>
                <div>
                    <h2 class="text-xl font-semibold">Orders</h2>
                    <p class="text-gray-600 text-sm">Recent orders</p>
                </div>
            </div>
            <p class="mt-4 text-2xl font-bold">320</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <span class="material-icons text-red-500 text-4xl mr-4">report_problem</span>
                <div>
                    <h2 class="text-xl font-semibold">Issues</h2>
                    <p class="text-gray-600 text-sm">Pending issues</p>
                </div>
            </div>
            <p class="mt-4 text-2xl font-bold">12</p>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="mt-10 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Recent Activities</h2>
        <ul class="divide-y divide-gray-200">
            <li class="py-4 flex items-center">
                <span class="material-icons text-blue-500 mr-4">person_add</span>
                <p class="flex-1">New user <strong>Jane Doe</strong> registered</p>
                <span class="text-gray-500 text-sm">2 hours ago</span>
            </li>
            <li class="py-4 flex items-center">
                <span class="material-icons text-green-500 mr-4">check_circle</span>
                <p class="flex-1">Order <strong>#1023</strong> completed</p>
                <span class="text-gray-500 text-sm">5 hours ago</span>
            </li>
            <li class="py-4 flex items-center">
                <span class="material-icons text-red-500 mr-4">error</span>
                <p class="flex-1">Issue reported by <strong>John Smith</strong></p>
                <span class="text-gray-500 text-sm">1 day ago</span>
            </li>
        </ul>
    </div>
</div>
