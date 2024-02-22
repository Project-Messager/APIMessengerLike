<?php
namespace App\Models;
use App\Models\BDD;
class Message
{
    private int $Id;
    private string $Body;
    private int $UserSender;
    private int $UserReceiver;
    private string $SendAt;

    public function getId(): int
    {
        return $this->Id;
    }
    public function setId(int $Id): Message
    {
        $this->Id = $Id;
        return $this;
    }

    public function getBody(): string
    {
        return $this->Body;
    }
    public function setBody(string $Body): Message
    {
        $this->Body = $Body;
        return $this;
    }


    public function getUserSender(): int
    {
        return $this->UserSender;
    }
    public function setUserSender(int $UserSender): Message
    {
        $this->UserSender = $UserSender;
        return $this;
    }

    public function getUserReceiver(): int
    {
        return $this->UserReceiver;
    }
    public function setUserReceiver(int $UserReceiver): Message
    {
        $this->UserReceiver = $UserReceiver;
        return $this;
    }
    
    public function getSendAt(): string
    {
        return $this->SendAt;
    }
    public function setSendAt(string $SendAt): Message
    {
        $this->SendAt = $SendAt;
        return $this;
    }

    public function SqlAddMessage(int $UserSender, int $UserReceiver, string $Body)
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('INSERT INTO message (UserSender, UserReceiver, Body, SendAt) VALUES (:UserSender, :UserReceiver, :Body, :SendAt)');
            $req->execute([
                'UserSender' => $UserSender,
                'UserReceiver' => $UserReceiver,
                'Body' => $Body,
                'SendAt' => date('Y-m-d H:i:s')
            ]);
            return [0, "Message envoyé"];
        } catch (\Exception $e) {
            return [1, "Erreur lors de l'envoi du message", $e->getMessage()];
        }
    }

    public static function SqlGetAllMessageById()
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('SELECT * FROM message WHERE UserSender = :UserSender AND UserReceiver = :UserReceiver ORDER BY Id DESC');
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            $messages = [];
            foreach ($data as $d) {
                $message = new message();
                $message->setId($d['Id']);
                $message->setBody($d['Body']);
                $message->setUserSender($d['UserSender']);
                $message->setUserReceiver($d['UserReceiver']);
                $message->setSendAt($d['SendAt']);
                $messages[] = $message;
            }
            return [0, "Utilisateurs trouvés", $messages];
        } catch (\Exception $e) {
            return [1, "Erreur lors de la recherche", $e->getMessage()];
        }
    }


}
