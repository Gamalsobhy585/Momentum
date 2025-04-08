<?php

return [
    "login" => [
        "success" => "Login successful",
        "failed" => "Login failed",
        "invalid_credentials" => "Invalid credentials",
    ],
    "logout" => [
        "success" => "Logout successful",
        "failed" => "Logout failed",
    ],
    "renew" => [
        "success" => "Password updated successfully",
        "failed" => "Password update failed",
        "user_not_found" => "User not found",
    ],
    "user" => [
        "success" => "User information retrieved successfully",
        "not_found" => "User not found",
    ],
    "register" => [
        "success" => "User registered successfully",
        "failed" => "User registration failed",
        "email_exists" => "Email already exists",
    ],
    "validation" => [
        "name_required" => "The name field is required.",
        "email_required" => "The email field is required.",
        "email_email" => "The email must be a valid email address.",
        "email_unique" => "The email has already been taken.",
        "password_required" => "The password field is required.",
        "password_confirmed" => "The password confirmation does not match.",
        'title_required' => 'The title field is required.',
        'title_string' => 'The title must be a string.',
        'title_max' => 'The title may not be greater than 255 characters.',
        'content_required' => 'The content field is required.',
        'content_string' => 'The content must be a string.',
        'user_id_required' => 'The user ID is required.',
        'user_id_exists' => 'The selected user ID is invalid.',
    ],
    "post" => [
        "get_all" => "Posts retrieved successfully",
        "get" => "Post retrieved successfully",
        "get_failed" => "Failed to retrieve posts",
        "not_found" => "Post not found",
        "created" => "Post created successfully",
        "create_failed" => "Failed to create post",
        "updated" => "Post updated successfully",
        "update_failed" => "Failed to update post",
        "deleted" => "Post deleted successfully",
        "delete_failed" => "Failed to delete post",
        "restored" => "Post restored successfully",
        "restore_failed" => "Failed to restore post",
        "get_all_deleted"=> "Deleted posts retrieved successfully",
    ]
    
];