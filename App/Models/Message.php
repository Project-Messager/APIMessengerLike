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

    public function SqlAddMessage(): array
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('INSERT INTO message (user_sender, user_receiver, body, Send_at) VALUES (:UserSender, :UserReceiver, :Body, :SendAt)');
            $req->execute([
                'UserSender' => $this->UserSender,
                'UserReceiver' => $this->UserReceiver,
                'Body' => $this->Body,
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
            $req = $bdd->prepare('SELECT * FROM message WHERE user_sender = :UserSender AND user_receiver = :UserReceiver ORDER BY Id DESC');
            $req->bindParam(':UserSender', $_POST['idUserSender']);
            $req->bindParam(':UserReceiver', $_POST['idUserReceiver']);
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            $messages = $data;
            return [0, "Messages trouvés", $messages];
        } catch (\Exception $e) {
            return [1, "Erreur lors de la recherche", $e->getMessage()];
        }
    }

    public static function SqlGetLastMessageById(int $idUserSender, int $idUserReceiver)
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('SELECT * FROM message WHERE user_sender = :UserSender AND user_receiver = :UserReceiver ORDER BY Id DESC LIMIT 1');
            $req->bindParam(':UserSender', $idUserSender);
            $req->bindParam(':UserReceiver', $idUserReceiver);
            $req->execute();
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            $message = $data;
            return $message;
        } catch (\Exception $e) {
            return [1, "Erreur lors de la recherche", $e->getMessage()];
        }
    }

    public static function SqlGetAllMessage()
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('SELECT * FROM message ORDER BY Id DESC');
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            $messages = $data;
            return [0, "Messages trouvés", $messages];
        } catch (\Exception $e) {
            return [1, "Erreur lors de la recherche", $e->getMessage()];
        }
    }

    public static function SqlGetAllConversation(int $idUserSender) {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('SELECT DISTINCT user_sender, user_receiver FROM message WHERE user_sender = :UserSender');
            $req->bindParam(':UserSender', $idUserSender);
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            $conversations = $data;
            return $conversations;
        }
        catch (\Exception $e) {
            return [1, "Erreur lors de la recherche", $e->getMessage()];
        }
    }
}
