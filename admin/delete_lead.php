<?php
session_start();
include('../database.php');

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
    // Check if lead ID is provided in the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $lead_id = $_GET['id'];

        // Delete lead from the database
        $delete_sql = "DELETE FROM leads WHERE id = $lead_id";

        if (mysqli_query($conn, $delete_sql)) {
            header('location:admin_dashboard.php');
            exit();
        } else {
            echo "Error deleting lead: " . mysqli_error($conn);
        }
    } else {
        echo "Lead ID not provided";
    }
    mysqli_close($conn);
} else {
    header("Location: ../index.php");
}
