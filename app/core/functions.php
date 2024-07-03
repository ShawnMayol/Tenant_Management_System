<?

function redirectToDashboard($role) {
    switch ($role) {
        case 'admin':
            header("Location: ../../index.php?page=admin.dashboard");
            break;
        case 'manager':
            header("Location: ../../index.php?page=manager.dashboard");
            break;
        case 'tenant':
            header("Location: ../../index.php?page=tenant.dashboard");
            break;
        default:
            echo "Unknown user role.";
            exit();
    }
    exit();
}