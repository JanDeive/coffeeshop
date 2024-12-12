<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= BASE_URL.'/public/css/tailwind.css' ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php
        // Import CSS files here
        foreach ($assetList as $asset) {
            if ($asset['type'] === 'css') {
                echo " <link rel=\"stylesheet\" href=\"".$asset['path']."\">";
            }
        }
    ?>
</head>

<body class="bg-gray-100">
    <!-- Wrapper for the entire layout -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-blue-800 text-white w-64 fixed md:relative md:flex md:flex-col h-screen transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
            <!-- Close Button for Mobile View -->
            <div class="flex justify-end md:hidden p-4">
                <button id="close-sidebar-button" class="text-white text-2xl focus:outline-none">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <!-- Profile Section -->
            <div class="p-6 flex items-center space-x-4 relative">
                <!-- Profile Picture with Hover Edit Overlay -->
                <div class="relative group">
                    <?php $profile = user()->image_url ? BASE_URL."/storage/images/".user()->image_url : BASE_URL."/public/images/profile.png" ?>
                    <img src="<?= $profile ?>" alt="Profile" class="w-12 h-12 rounded-full">
                    <!-- Edit Picture Overlay with Pencil Icon -->
                    <a href="<?= route('/changePicture') ?>"
                        class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white font-semibold text-sm rounded-full transition-opacity">
                        <span class="material-icons">edit</span> <!-- Pencil icon -->
                    </a>
                </div>
                <div>
                    <!-- Get current user username using the global function -->
                    <h2 class="text-lg font-semibold"><?= strtoupper(user()->username) ?></h2>
                    <p class="text-sm text-gray-300">Admin</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-6 flex-1">
                <ul>
                    <?php
                    $menuItems = $menuItems ?? [];
                    foreach ($menuItems as $item):
                        // Check if the current menu item is active
                        $isActive = $item['active'] ? 'bg-blue-700' : '';
                        ?>
                        <li>
                            <a href="<?= $item['route']; ?>"
                                class="flex items-center p-4 hover:bg-blue-700 <?= $isActive; ?>">
                                <span class="material-icons mr-3"><?= $item['icon']; ?></span>
                                <span><?= $item['label']; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Logout Section -->
            <div class="py-4">
                <a href="<?= route("/logout") ?>" class="flex items-center p-4 hover:bg-blue-700">
                    <span class="material-icons mr-3">logout</span>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Mobile Menu Button -->
        <div class="md:hidden fixed top-4 left-4 z-50">
            <button id="mobile-menu-button" class="text-blue-800 text-2xl focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>

        <!-- Content Area -->
        <main class="flex-1 ml-0 p-4 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
                <!-- Inject dynamic content here -->
                <?= $content; ?>
            </div>
        </main>
    </div>

    <script>
        // Mobile menu toggle logic
        const sidebar = document.getElementById('sidebar');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const closeSidebarButton = document.getElementById('close-sidebar-button');

        // Open sidebar on menu button click
        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        // Close sidebar on close button click
        closeSidebarButton.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });
    </script>
    <?php
        // Import JS files here
        foreach ($assetList as $asset) {
            if ($asset['type'] === 'js') {
                echo "<script src=\"". $asset['path']."\"></script>";
            }
        }
    ?>
</body>
</html>
