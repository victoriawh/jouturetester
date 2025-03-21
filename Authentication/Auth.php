<?php
namespace App\Authentication;
use App\Authentication\User;

class Auth{

    public function login(string $email, string $password): bool{
        session_start();
        $_SESSION['user'] = $email;
        return true;
    }

    public function isLoggedIn(): bool{
        return isset($_SESSION['user']);
    }

    public function logout(): void{
        session_start();
        session_destroy();
        header("Location: login.php"):
        exit();
    }
}
?>
