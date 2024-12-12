<?php
namespace App\Controllers;

use App\Helpers\JWTHandler;
use App\Models\User;

class ApiController
{
    private $jwtHandler;

    /**
     * Constructor to initialize JWTHandler
     */
    public function __construct()
    {
        $this->jwtHandler = new JWTHandler();
    }

    /**
     * Authenticate the request using JWT token
     * 
     * @return array Decoded payload
     */
    public function authenticateRequest()
    {
        // Get Authorization header
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            $this->sendResponse(401, ['message' => 'Authorization header missing']);
            exit;
        }

        // Extract token
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Validate token
        $payload = $this->jwtHandler->validateToken($token);
        if (!$payload) {
            $this->sendResponse(401, ['message' => 'Invalid or expired token']);
            exit;
        }

        return $payload; // Return decoded payload for further use
    }

    /**
     * Send JSON response
     * 
     * @param int $statusCode HTTP status code
     * @param array $data Response data
     */
    public function sendResponse($statusCode, $data)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Return list of users in JSON format
     */
    public function users()
    {
        // Make sure user is authenticated. Add this line to protected API routes or when user should be authenticated
        $this->authenticateRequest();

        // Fetch all users using the User model
        $users = User::findAll();

        $userData = array_map(function($user) {
            return [
                'user_id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
                'image_url' => $user->image_url, // Assuming the user has a picture attribute
            ];
        }, $users);

        // Set the content type to JSON and return the response
        $this->sendResponse(200, $userData);
    }

    /**
     * Handle user login and return JWT token
     * 
     * @param array $params Login parameters
     */
    public function login($params)
    {
        $user = new User();
        $user->email = $params['email'] ?? null;
        $user->password = $params['password'] ?? null;
        $authenticatedUser = $user->login();
        if ($authenticatedUser) {
            $token = $this->jwtHandler->generateToken(['user_id' => $authenticatedUser->user_id, 'email' => $authenticatedUser->email]);
            $this->sendResponse(200, [
                'message' => 'Login successful',
                'token' => $token,
                'user' => ['user_id' => $authenticatedUser->user_id, 'email' => $authenticatedUser->email]
            ]);
        } else {
            $this->sendResponse(401, ['message' => 'Invalid email or password']);
        }
        exit;
    }
}
