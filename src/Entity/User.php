<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
#[UniqueEntity(fields:"email", message:"Email already taken")]
#[UniqueEntity(fields:"username", message:"Username already taken")]
#[ORM\Entity(repositoryClass:"App\Repository\UserRepository")]
class User implements UserInterface
{
 
 #[ORM\Id]
 #[ORM\Column(type:"integer")]
 #[ORM\GeneratedValue(strategy:"AUTO")]
 
 private $id;
 
 #[ORM\Column(type:"string", length:255)]
 #[Assert\NotBlank()]
 #[Assert\Email()]
 
 private $email;
 #[ORM\Column(type:"string", length:255)]
 #[Assert\NotBlank()]
 
 private $username;
 
 #[Assert\NotBlank()]
 #[Assert\Length(max:4096)]
 
 private $plainPassword;
 /**
 * The below length depends on the "algorithm" you use for encoding
 * the password, but this works well with bcrypt.
 */
 #[ORM\Column(type:"string", length:64)]
 private $password;
 
 #[ORM\Column(type:"array")]
 
 private $roles;
 public function __construct()
 {
 $this->roles = ['ROLE_ADMIN'];
 }
 // other properties and methods
 public function getEmail()
 {
 return $this->email;
 }
 public function getId()
 {
 return $this->id;
 }
 public function setEmail($email)
 {
 $this->email = $email;
 }
 public function getUsername()
 {
 return $this->username;
 }
 public function setUsername($username)
 {
 $this->username = $username;
 }
 public function getPlainPassword()
 {
 return $this->plainPassword;
 }
 public function setPlainPassword($password)
 {
 $this->plainPassword = $password;
 }
 public function getPassword()
    {
        return $this->password;
        }
        public function setPassword($password)
        {
        $this->password = $password;
        }
        public function getSalt()
        {
        return null;
        }
        public function getRoles()
        {
        return $this->roles;
        }
        public function eraseCredentials()
        {
        }
        public function setRoles(array $roles): self
        {
        $this->roles = $roles;
        return $this;
        }
       }
       ?>