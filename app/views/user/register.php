<form method="POST" class="max-w-md mx-auto p-6 my-20 bg-white rounded shadow-md">
    <h2 class="text-3xl font-semibold mb-4">Register</h2>

    <!-- Always include the CSRF token in a hidden input field for POST method only -->
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES); ?>" />

    <!-- Username Field -->
    <div class="mb-4">
        <label for="username" class="block text-sm font-medium">Username</label>
        <input type="text" name="username" id="username" required
            class="w-full mt-1 p-2 border <?php echo isset($errors['username']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md"
            value="<?php echo htmlspecialchars($model->username ?? '', ENT_QUOTES); ?>" />
        <?php if (isset($errors['username'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['username']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Email Field -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium">Email</label>
        <input type="email" name="email" id="email" required
            class="w-full mt-1 p-2 border <?php echo isset($errors['email']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md"
            value="<?php echo htmlspecialchars($model->email ?? '', ENT_QUOTES); ?>" />
        <?php if (isset($errors['email'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['email']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Password Field -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Password</label>
        <input type="password" name="password" id="password" required
            class="w-full mt-1 p-2 border <?php echo isset($errors['password']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md" />
        <?php if (isset($errors['password'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['password']; ?></p>
        <?php endif; ?>
    </div>

    <!-- Confirm Password Field -->
    <div class="mb-4">
        <label for="repassword" class="block text-sm font-medium">Confirm Password</label>
        <input type="password" name="repassword" id="repassword" required
            class="w-full mt-1 p-2 border <?php echo isset($errors['repassword']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md" />
        <?php if (isset($errors['repassword'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['repassword']; ?></p>
        <?php endif; ?>
    </div>

    <button type="submit" name="register" class="w-full py-2 mt-4 bg-blue-600 text-white rounded-md">Register</button>

    <div class="pt-2 text-sm">
        <p class="text-gray-600">
            Already have an account? <a href="<?= BASE_URL . "/login" ?>" class="text-blue-500 hover:text-blue-700">Login here</a>.
        </p>
    </div>
</form>
