<?php
namespace App\Controller;


use App\Models\User;
use App\Service\JwtService;

class ApiUserController
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');
    }

    public function AddUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_encode("Erreur de méthode (POST attendu)");
        }

        if (!isset($_POST['name']) || !isset($_POST['password']) || !isset($_POST['mail']) || !isset($_POST['firstName']) || !isset($_POST['lastName'])) {
            return json_encode("Erreur, il manque des données");
        }

        $user = new User();
        $user->setName($_POST['name']);
        $user->setPassword($_POST['password']);
        $user->setMail($_POST['mail']);
        $user->setFirstName($_POST['firstName']);
        $user->setLastName($_POST['lastName']);
        $user->setProfilPicture("default.jpg");
        $result = $user->SqlAdd();
        return json_encode($result);
    }

    public function getAllById(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return json_encode("Erreur de méthode (GET attendu)");
        }

//        $result = JwtService::checkToken();
//        if ($result['code'] == 1) {
//            return json_encode($result);
//        }

        $user = User::SqlGetById($id);
        return json_encode($user);
    }

    public function UpdateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            return json_encode("Erreur de méthode (PUT attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        if (!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['password']) || !isset($_POST['mail']) || !isset($_POST['firstName']) || !isset($_POST['lastName'])) {
            return json_encode("Erreur, il manque des données");
        }

        $user = new User();
        $user->setId($_POST['id']);
        $user->setName($_POST['name']);
        $user->setPassword($_POST['password']);
        $result = $user->SqlUpdateUser();
        return json_encode($result);
    }

    public function DeleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            return json_encode("Erreur de méthode (DELETE attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        if (!isset($_POST['id'])) {
            return json_encode("Erreur, il manque des données");
        }

        $user = new User();
        $user->setId($_POST['id']);
        $result = $user->SqlDeleteUser();
        return json_encode($result);
    }
}

