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
        $hashpass = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost"=>12]);
        $user->setName($_POST['name']);
        $user->setPassword($hashpass);
        $user->setMail($_POST['mail']);
        $user->setFirstName($_POST['firstName']);
        $user->setLastName($_POST['lastName']);
        $user->setProfilPicture("default.jpg");
        $result = $user->SqlAdd();
        return json_encode($result);
    }

    public function getAll(){
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return json_encode("Erreur de méthode (GET attendu)");
        }
        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        $users = User::SqlGetAll();
        return json_encode($users);
    }

    public function getById(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return json_encode("Erreur de méthode (GET attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        $user = User::SqlGetById($id);
        return json_encode($user);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_encode("Erreur de méthode (POST attendu)");
        }

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            return json_encode("Erreur, il manque des données");
        }

        $user = User::SqlGetByEmail($_POST['email']);

        if ($user) {
            if (password_verify($_POST['password'], $user->getPassword())) {
                $jwt = JwtService::createToken([
                    "mail" => $user->getMail(),
                    "name" => $user->getName(),
                ]);

                $result = array(
                    "id" => $user->getId(),
                    "token" => $jwt
                );
                return json_encode($result);
            }
        }
        return json_encode("Erreur, nom d'utilisateur ou mot de passe incorrect");
    }
}

