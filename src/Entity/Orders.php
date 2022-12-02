<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private array $adress = [];

    #[ORM\Column(length: 255)]
    private ?string $order_status = null;

    #[ORM\Column(type: Types::TEXT)]
    private  $shoppingcart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAdress(): array
    {
        return $this->adress;
    }

    public function setAdress(array $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getOrderStatus(): ?string
    {
        return $this->order_status;
    }

    public function setOrderStatus(string $order_status): self
    {
        $this->order_status = $order_status;

        return $this;
    }

    public function getShoppingcart()
    {
        return $this->shoppingcart;
    }

    public function setShoppingcart($shoppingcart): self
    {
        $this->shoppingcart = $shoppingcart;

        return $this;
    }
}
