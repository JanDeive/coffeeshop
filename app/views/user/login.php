<form method="POST" class="max-w-md mt-20 mx-auto p-6 bg-white rounded shadow-md">
    <h2 class="text-3xl font-semibold mb-4">Login</h2>

    <!-- Display error messages if necessary -->
    <?php if (!empty($errors)) { ?>
        <div role="alert">
            <div class="border-l-4 border-red-400 rounded bg-red-100 px-4 py-3 text-red-700 mb-4">
                <?php foreach ($errors as $error) { ?>
                    <span class="inline-block"><?php echo $error; ?></span>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <!-- Always include the CSRF token in a hidden input field for POST method only -->
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES); ?>" />

    <!-- Email input, model-bound -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium">Email</label>
        <input type="email" name="email" id="email" required class="w-full mt-1 p-2 border border-gray-300 rounded-md"
            value="<?php echo htmlspecialchars($model->email ?? '', ENT_QUOTES); ?>" />
    </div>

    <!-- Password input, model-bound -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Password</label>
        <input type="password" name="password" id="password" required
            class="w-full mt-1 p-2 border border-gray-300 rounded-md" />
    </div>

    <button type="submit" name="login" class="w-full py-2 mt-4 bg-blue-600 text-white rounded-md">Login</button>
    <div class="pt-2 text-sm">
        <p class="text-gray-600">
            No account yet? <a href="<?= BASE_URL."/register" ?>" class="text-blue-500 hover:text-blue-700">Sign up here</a>.
        </p>
    </div>
</form>
