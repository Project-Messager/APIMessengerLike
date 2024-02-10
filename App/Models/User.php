<?php

Namespace App\Models;
use MongoDB\Driver\Exception\Exception;
use src\Models\BDD;

class User //implements \JsonSerializable
{
    private int $Id;
    private string $Name;
    private string $Password;
    private string $Mail;
    private string $FirstName;
    private string $LastName;
    private string $ProfilPicture;


    public function getId(): int
    {
        return $this->Id;
    }
    public function setId(int $id): User
    {
        $this->Id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->Name;
    }
    public function setName(string $Name): User
    {
        $this->Name = $Name;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->Password;
    }
    public function setPassword(string $Password): User
    {
        $this->Password = $Password;
        return $this;
    }

    public function getMail(): string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): User
    {
        $this->Mail = $Mail;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): User
    {
        $this->FirstName = $FirstName;
        return $this;
    }


    public function getLastName(): string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): User
    {
        $this->LastName = $LastName;
        return $this;
    }


    public function getProfilPicture(): string
    {
        return $this->ProfilPicture;
    }

    public function setProfilPicture(string $ProfilPicture): User
    {
        $this->ProfilPicture = $ProfilPicture;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'Password' => $this->Password,
            'Mail' => $this->Mail,
            'FirstName' => $this->FirstName,
            'LastName' => $this->LastName,
            'ProfilPicture' => $this->ProfilPicture
        ];
    }

    public function SqlAdd(): array
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('INSERT INTO user (Name, Password, Mail, FirstName, LastName, ProfilPicture) VALUES (:Name, :Password, :Mail, :FirstName, :LastName, :ProfilPicture)');
            $req->execute([
                'Name' => $this->Name,
                'Password' => $this->Password,
                'Mail' => $this->Mail,
                'FirstName' => $this->FirstName,
                'LastName' => $this->LastName,
                'ProfilPicture' => $this->ProfilPicture
            ]);
            return [0, "Insertion réussie", $bdd->lastInsertId()];
        } catch (\Exception $e) {
            return [1, "Erreur lors de l'insertion", $e->getMessage()];
        }
    }

    public function SqlUpdate()
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('UPDATE user SET Name = :Name, Password = :Password, Mail = :Mail, FirstName = :FirstName, LastName = :LastName, ProfilPicture = :ProfilPicture WHERE Id = :Id');
            $req->execute([
                'Id' => $this->Id,
                'Name' => $this->Name,
                'Password' => $this->Password,
                'Mail' => $this->Mail,
                'FirstName' => $this->FirstName,
                'LastName' => $this->LastName,
                'ProfilPicture' => $this->ProfilPicture
            ]);
            return [0, "Modification réussie"];
        } catch (\Exception $e) {
            return [1, "Erreur lors de la modification", $e->getMessage()];
        }
    }

    public static function SqlDelete(int $id)
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('DELETE FROM user WHERE Id = :Id');
            $req->execute([
                'Id' => $id
            ]);
            return [0, "Suppression réussie"];
        } catch (\Exception $e) {
            return [1, "Erreur lors de la suppression", $e->getMessage()];
        }
    }

    public static function SqlGetById(int $id): ?User
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('SELECT * FROM user WHERE Id = :Id');
            $req->execute([
                'Id' => $id
            ]);
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            if ($data) {
                $user = new User();
                $user->setId($data['Id']);
                $user->setName($data['Name']);
                $user->setPassword($data['Password']);
                $user->setMail($data['Mail']);
                $user->setFirstName($data['FirstName']);
                $user->setLastName($data['LastName']);
                $user->setProfilPicture($data['ProfilPicture']);
                return [0, "Utilisateur trouvé", $user];
            } else {
                return [1, "Utilisateur non trouvé"];
            }
        } catch (\Exception $e) {
            return [1, "Erreur lors de la recherche", $e->getMessage()];
        }
    }

    public static function SqlGetAll()
    {
        try {
            $bdd = BDD::getInstance();
            $req = $bdd->prepare('SELECT * FROM user ORDER BY Id');
            $req->execute();
            $data = $req->fetchAll(\PDO::FETCH_ASSOC);
            $users = [];
            foreach ($data as $d) {
                $user = new User();
                $user->setId($d['Id']);
                $user->setName($d['Name']);
                $user->setPassword($d['Password']);
                $user->setMail($d['Mail']);
                $user->setFirstName($d['FirstName']);
                $user->setLastName($d['LastName']);
                $user->setProfilPicture($d['ProfilPicture']);
                $users[] = $user;
            }
            return [0, "Utilisateurs trouvés", $users];
        } catch (\Exception $e) {
            return [1, "Erreur lors de la recherche", $e->getMessage()];
        }
    }

}
