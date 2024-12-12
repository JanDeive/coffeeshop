<?php
namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->layout = "main"; // Set default layout for all actions
        $this->generateCsrfToken();
    }

    /**
     * Handle user login
     *
     * @param array $params
     */
    public function login($params)
    {
        // Redirect to home if already logged in
        if (User::isLoggedIn()) {
            self::redirect("/");
        }

        $this->layout = 'simple';
        $this->pageTitle = 'Login';

        $model = new User();

        // If login form is submitted
        if (!empty($params)) {
            $this->validateCsrfToken($params);
            $model->email = $params['email'];
            $model->password = $params['password'];

            if ($model->validate()) {
                $authenticatedUser = $model->login();
                if ($authenticatedUser) {
                    $authenticatedUser->setSession();
                    self::redirect('/');
                } else {
                    $this->errors[] = "Invalid credentials";
                }
            } else {
                // Display validation errors
                foreach ($model->getErrors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $this->errors[] = $error;
                    }
                }
            }
        }

        $this->view('user/login', [
            'model' => $model,
        ]);
    }

    /**
     * Handle user registration
     *
     * @param array $params
     */
    public function register($params)
    {
        // Redirect to home if already logged in
        if (User::isLoggedIn()) {
            self::redirect("/");
        }

        $this->layout = 'simple';
        $this->pageTitle = 'Register';

        $model = new User();

        // If the form is submitted
        if (!empty($params)) {
            $this->validateCsrfToken($params);

            // Assign the form data to the model
            $model->username = $params['username'];
            $model->email = $params['email'];
            $model->password = $params['password'];
            $model->repassword = $params['repassword']; // Confirm password

            // Set validation rules
            $model->setRules([
                'username' => ['required' => true, 'minLength' => 6, 'unique' => true],
                'email' => ['required' => true, 'email' => true, 'unique' => true],
                'password' => ['required' => true, 'minLength' => 6],
                'repassword' => ['required' => true, 'confirmPassword' => true]
            ]);

            // Validate the model data
            if ($model->validate()) {
                // Proceed with registration (e.g., save the user to the database)
                if ($model->register()) {
                    self::redirect('/login'); // Redirect to login after successful registration
                } else {
                    $this->errors[] = "An error occurred while registering. Please try again.";
                }
            } else {
                // If validation fails, collect validation errors
                foreach ($model->getErrors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $this->errors[$field] = $error;
                    }
                }
            }
        }

        $this->view('user/register', [
            'model' => $model
        ]);
    }

    /**
     * Display users table
     *
     * @param array $params
     */
    public function users($params)
    {
        $this->pageTitle = 'Users';
        $users = [];

        // Handle delete
        if (isset($params['delete_user_id'])) {
            $this->validateCsrfToken($params);
            $user = User::find($params['delete_user_id']);
            $user->delete();
            self::redirect('/users');
        }

        // Handle search
        if (isset($params['q'])) {
            $q = "%" . $params['q'] . "%";
            $users = User::filter([
                "username LIKE" => $q,
                "OR email LIKE" => $q,
            ]);
        }

        // If no search request
        if (!isset($params['q'])) {
            $users = User::findAll();
        }

        $this->view('user/table', [
            'users' => $users,
        ]);
    }

    /**
     * Change user profile picture
     *
     * @param array $params
     */
    public function changePicture($params)
    {
        $this->pageTitle = "Change Profile Picture";
        $model = user(); // Get current logged user

        if (isset($params['picture']) && str_starts_with($params['picture']['type'], "image/")) {
            // Define the target directory where you want to save the image
            $uploadDir = __DIR__ . '/../../storage/images/';

            // Generate a unique name for the file to avoid conflicts
            $uniqueFileName = uniqid('profile_') . '.' . pathinfo($params['picture']['name'], PATHINFO_EXTENSION);

            // Define the target file path
            $targetFilePath = $uploadDir . $uniqueFileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($params['picture']['tmp_name'], $targetFilePath)) {
                // File uploaded successfully, assign the filename to the model
                $oldImage = $model->image_url;
                $model->image_url = $uniqueFileName;

                // Save the model to the database (assuming the `save` method exists in the model)
                if ($model->save()) {
                    // Delete old picture
                    if (!empty($oldImage) && file_exists($uploadDir . $oldImage)) {
                        unlink($uploadDir . $oldImage);
                    }
                    // Refresh session to update profile picture
                    $_SESSION['user']['image_url'] = $model->image_url;
                    self::redirect("/");
                    exit;
                } else {
                    $this->errors[] = "Failed to save the profile picture to the database.";
                }
            } else {
                $this->errors[] = "Failed to upload the picture.";
            }
        }

        $this->view('/user/changeProfile', [
            'model' => $model
        ]);
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        User::logout();
        self::redirect('/login');
    }
}
