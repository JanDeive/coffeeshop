<?php
// Set menu items
$menuItems = [
    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => route('/'), 'active' => false],
    ['label' => 'Users', 'icon' => 'group', 'route' => route('/users'), 'active' => false],
    ['label' => 'Sample API Request', 'icon' => 'api', 'route' => route('/sample-api-request'), 'active' => false],
];
?>

<div class="py-6">
    <h1 class="text-3xl font-bold mb-6"><?= $title ?></h1>
    <!-- Form Container -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl">

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data">

            <!-- Profile Picture Display -->
            <div class="mb-6 text-center">
                <?php $profile = user()->image_url ? BASE_URL . "/storage/images/" . user()->image_url : BASE_URL . "/public/images/profile.png" ?>
                <img src="<?= $profile ?>" alt="Current Profile Picture" class="w-full h-72 object-cover mx-auto mb-4">
            </div>

            <!-- File Input -->
            <div class="mb-4">
                <label for="picture" class="block text-gray-700 font-medium">Select a New Profile Picture</label>
                <input type="file" name="picture" id="picture"
                    class="mt-2 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                    accept="image/*" required>
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    Update Picture
                </button>
            </div>

        </form>
    </div>
</div>
