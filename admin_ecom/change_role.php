<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the logged-in user is a superadmin
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
        // Superadmin can change user role
        $user_id = $_POST['user_id'];
        $new_role = $_POST['new_role'] ?? null;

        if ($new_role == 3) {
            // Update the user role in the database to Admin
            updateUserRole($user_id, 2);
            $_SESSION['success_message'] = 'Role changed to Admin.';
        } elseif ($new_role == 2) {
            // Update the user role in the database to User
            updateUserRole($user_id, 3);
            $_SESSION['success_message'] = 'Role changed to User.';
        }
    }

    // Redirect back to the superadmin page
    header("Location: superadmin.php");
    exit();
} else {
    // Redirect if accessed directly without POST data
    header("Location: superadmin.php");
    exit();
}

function updateUserRole($user_id, $new_role_id) {
    global $con;
    $updateRoleQuery = "UPDATE `user` SET `role_id` = ? WHERE `id` = ?";
    
    $stmt = $con->prepare($updateRoleQuery);
    $stmt->bind_param("ii", $new_role_id, $user_id);
    
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}
?>
