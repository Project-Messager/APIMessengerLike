<?php
namespace App\Controller;

use App\Models\Message;
use App\Service\JwtService;
use function Sodium\add;

class ApiMessageController
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');
    }

    public function AddMessage(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_encode("Erreur de méthode (POST attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        if(!isset($_POST['body']) || !isset($_POST['userSender']) || !isset($_POST['userReceiver'])){
            return json_encode("Erreur, il manque des données");
        }

        $message = new Message();
        $message->setBody($_POST['body']);
        $message->setUserSender($_POST['userSender']);
        $message->setUserReceiver($_POST['userReceiver']);
        $message->setSendAt(date("Y-m-d H:i:s"));
        $result = $message->SqlAddMessage();
        return json_encode($result);
    }

    public function getAllById()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return json_encode("Erreur de méthode (GET attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        if (!isset($_GET['idUserSender']) || !isset($_GET['idUserReceiver'])) {
            return json_encode("Erreur, il manque des données");
        }

        $messages = Message::SqlGetAllMessageById();
        return json_encode($messages);
    }

    public function getLastMessageById()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return json_encode("Erreur de méthode (GET attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        if (!isset($_GET['idUserSender']) || !isset($_GET['idUserReceiver'])) {
            return json_encode("Erreur, il manque des données");
        }

        $message = Message::SqlGetLastMessageById($_GET['idUserSender'], $_GET['idUserReceiver']);
        return json_encode($message);
    }

    public function getAllConversation(int $idUserSender){
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return json_encode("Erreur de méthode (GET attendu)");
        }

//        $result = JwtService::checkToken();
//        if ($result['code'] == 1) {
//            return json_encode($result);
//        }

        $messages = Message::SqlGetAllConversation($idUserSender);
        $datas = [];
        foreach ($messages as $message){
           $bodyMessage = Message::SqlGetLastMessageById($message['user_sender'], $message['user_receiver']);

            $message["body"] = $bodyMessage['body'];
            $message["send_at"] = $bodyMessage['Send_at'];
            $datas[] = $message;
        }

        return json_encode($datas);
    }

    public function UpdateMessage(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_encode("Erreur de méthode (POST attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        if(!isset($_POST['id']) || !isset($_POST['body'])){
            return json_encode("Erreur, il manque des données");
        }

        $message = new Message();
        $message->setId($_POST['id']);
        $message->setBody($_POST['body']);
        $result = $message->SqlUpdateMessage();
        return json_encode($result);
    }

    public function DeleteMessage(){
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            return json_encode("Erreur de méthode (DELETE attendu)");
        }

        $result = JwtService::checkToken();
        if ($result['code'] == 1) {
            return json_encode($result);
        }

        if(!isset($_POST['id'])){
            return json_encode("Erreur, il manque des données");
        }

        $message = new Message();
        $message->setId($_POST['id']);
        $result = $message->SqlDeleteMessage();
        return json_encode($result);
    }
}