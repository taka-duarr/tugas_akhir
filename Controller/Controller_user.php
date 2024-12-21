<?php
require_once 'Model/Model_user.php';
require_once 'Model/Model_role.php';


class UserController {
    private $model_user;
    private $nama_role;

    public function __construct() {
        $this->model_user = new ModelUser();
        $this->nama_role = new ModelRole();
    }
    

    public function listUser() {
        $users = $this->model_user->getAllUser();
        include 'Views/admin/user_list.php';
    }

    public function addUser() {
        // Ambil data role dari model
        $roles = $this->nama_role->getAllRole();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_user = $_POST['nama_user'] ?? null;
            $password_user = $_POST['password_user'] ?? null;
            $nama_role = $_POST['nama_role'] ?? null;
    
            if ($nama_user && $password_user && $nama_role) {
                $this->model_user->createUser($nama_user, $password_user, $nama_role);
                header("Location: index.php?modul=user&fitur=list");
                exit;
            } else {
                echo "Semua input harus diisi.";
            }
        } else {
            include 'Views/admin/user_input.php';
        }
    }
    
}

?>