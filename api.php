<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include "db_config.php";

// Initialize response array
$response = array();

// Check if action parameter is provided and not empty
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];

    // Check request method
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Get all blog posts
        if ($action === 'get_posts') {
            $posts = array();
            $query = "SELECT * FROM `userposts`";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $posts[] = array(
                        'id' => $row['id'],
                        'user_posts' => $row['user_posts'],
                        'mail' => $row['mail']
                    );
                }
                $response['success'] = true;
                $response['posts'] = $posts;
            } else {
                $response['success'] = false;
                $response['message'] = "No posts found.";
            }
            mysqli_close($conn);
        }

        // Get all users
        elseif ($action === 'get_users') {
            $users = array();
            $query = "SELECT user_name, user_mail FROM `blog_user_data`";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $users[] = array(
                        'user_name' => $row['user_name'],
                        'user_mail' => $row['user_mail']
                    );
                }
                $response['success'] = true;
                $response['users'] = $users;
            } else {
                $response['success'] = false;
                $response['message'] = "No users found.";
            }
            mysqli_close($conn);
        } else {
            $response['success'] = false;
            $response['message'] = "Invalid action.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Invalid request method.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Action parameter not provided or empty.";
}

// Output JSON response
echo json_encode($response);
?>
