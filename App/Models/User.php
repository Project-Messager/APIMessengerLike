<?php

namespace App\Models;
class User //implements \JsonSerializable
{
    private int $Id;
    private string $name;
    private string $password;
    private string $mail;
    private string $firstName;
    private string $lastName;
    private string $profilPicture;


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
        return $this->name;
    }
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): User
    {
        $this->mail = $mail;
        return $this;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }


    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }


    public function getProfilPicture(): string
    {
        return $this->profilPicture;
    }

    public function setProfilPicture(string $profilPicture): User
    {
        $this->profilPicture = $profilPicture;
        return $this;
    }

}
