<?php
// Set menu items
$menuItems = [
    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => route('/'), 'active' => false],
    ['label' => 'Users', 'icon' => 'group', 'route' => route('/users'), 'active' => true],
    ['label' => 'Sample API Request', 'icon' => 'api', 'route' => route('/sample-api-request'), 'active' => false],
];

// $users, list of users, comes from controller
?>

<!-- Search input and table container -->
<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold mb-6">User Management</h1>
    <!-- Search field aligned to the right -->
    <form>
        <div class="flex justify-end items-center mb-4 space-x-2">
            <div class="relative w-64">
                <!-- Search input field -->
                <input type="text" id="searchInput" name="q" value="<?= $_GET['q'] ?? "" ?>" class="border border-gray-300 p-2 pl-2 pr-12 rounded-md w-full"
                    placeholder="Search...">
            </div>
            <!-- Submit button next to search field -->
            <button type="submit" class="flex items-center text-white bg-blue-500 border border-blue-500 py-2 px-4 rounded-md hover:bg-blue-600 hover:border-blue-600">
                <span class="material-icons mr-2">search</span>
                <span>Search</span>
            </button>
        </div>
    </form>

    <!-- Table -->
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="py-3 px-4 text-sm font-medium text-gray-700">No.</th>
                <th class="py-3 px-4 text-sm font-medium text-gray-700">Username</th>
                <th class="py-3 px-4 text-sm font-medium text-gray-700">Email</th>
                <th class="py-3 px-4 text-sm font-medium text-gray-700">Profile Picture</th>
                <th class="py-3 px-4 text-sm font-medium text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Table rows go here -->
            <?php foreach ($users as $key => $user): ?>
                <tr>
                    <td class="py-3 px-4 text-sm text-gray-700"><?= ++$key ?></td>
                    <td class="py-3 px-4 text-sm text-gray-700"><?= $user->username ?></td>
                    <td class="py-3 px-4 text-sm text-gray-700"><?= $user->email ?></td>
                    <td class="px-4 py-2">
                        <img src="<?= BASE_URL . "/storage/images/" . $user->image_url ?>" alt="User Image" class="w-12 h-12 rounded-full">
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-700">
                        <form method="POST">
                            <!-- Always include the CSRF token in a hidden input field for POST method only -->
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES); ?>" />
                            <input type="hidden" name="delete_user_id" value="<?= $user->user_id ?>" />
                            <button type="submit" onclick="return confirm('Are you sure you want to delete the user?');"
                                class="flex items-center text-white bg-red-500 border border-red-500 py-2 px-4 rounded-md hover:bg-red-600 hover:border-red-600">
                                <span class="material-icons mr-2">delete</span>
                                <span>Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
