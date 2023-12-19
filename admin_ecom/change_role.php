<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the logged-in user is a superadmin
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
        $user_id = $_POST['user_id'];
        $action = $_POST['action'] ?? null;

        if ($action == 'change_role') {
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
        } elseif ($action == 'delete_user') {
            // Delete the user from the database
            deleteUser($user_id);
            $_SESSION['success_message'] = 'User deleted successfully.';
        }
    }
}

function updateUserRole($user_id, $new_role_id) {
    global $con;
    $updateRoleQuery = "UPDATE `user` SET `role_id` = ? WHERE `id` = ?";
    
    $stmt = mysqli_prepare($con, $updateRoleQuery);
    mysqli_stmt_bind_param($stmt, "ii", $new_role_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

function deleteUser($user_id) {
    global $con;
    $deleteUserQuery = "DELETE FROM `user` WHERE `id` = ?";
    
    $stmt = mysqli_prepare($con, $deleteUserQuery);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>
