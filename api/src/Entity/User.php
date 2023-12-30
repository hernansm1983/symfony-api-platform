<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class User implements UserInterface
{
    private string $id;
    private string $name;
    private string $email;
    private ?string $password; //el ? significa opcional, ya que mas adelante usaremos el auth de facebook    
    private ?string $avatar;
    private ?string $token;
    private ?string $resetPasswordToken; // para cuando el usuario quiera resetear la contraseña
    private bool $active;
    private \Datetime $createdAt;
    private \Datetime $updatedAt;

    public function __construct(string $name, string $email)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->setEmail($email);
        $this->password = null;
        $this->avatar = null;
        $this->token = \sha1(\uniqid());
        $this->resetPasswordToken = null;
        $this->active = false;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
    }
    

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * Get the value of email
     *
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self {
        if (!\filter_var($email, filter:\FILTER_VALIDATE_EMAIL)) {
            throw new \LogicException(message: 'Invalid Email');
        }
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of avatar
     *
     * @return ?string
     */
    public function getAvatar(): ?string {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @param ?string $avatar
     *
     * @return self
     */
    public function setAvatar(?string $avatar): self {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * Get the value of token
     *
     * @return ?string
     */
    public function getToken(): ?string {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @param ?string $token
     *
     * @return self
     */
    public function setToken(?string $token): self {
        $this->token = $token;
        return $this;
    }

    /**
     * Get the value of active
     *
     * @return bool
     */
    public function getActive(): bool {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @param bool $active
     *
     * @return self
     */
    public function setActive(bool $active): self {
        $this->active = $active;
        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return \Datetime
     */
    public function getCreatedAt(): \Datetime {
        return $this->createdAt;
    }

    /**
     * Get the value of updatedAt
     *
     * @return \Datetime
     */
    public function getUpdatedAt(): \Datetime {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param \Datetime $updatedAt
     *
     * @return self
     */
    public function markAsUpdated(): self {
        $this->updatedAt = new \DateTime();
        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of resetPasswordToken
     */ 
    public function getResetPasswordToken()
    {
        return $this->resetPasswordToken;
    }

    /**
     * Set the value of resetPasswordToken
     *
     * @return  self
     */ 
    public function setResetPasswordToken($resetPasswordToken)
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getSalt(): void
    {

    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {

    }
}