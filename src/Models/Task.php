<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected string $userName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected string $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected string $text;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected bool $done = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": false})
     */
    protected bool $modified = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function setDone()
    {
        $this->done = true;
    }
    public function setModified()
    {
        $this->modified = true;
    }

    public function isModified()
    {
        return $this->modified;
    }
}