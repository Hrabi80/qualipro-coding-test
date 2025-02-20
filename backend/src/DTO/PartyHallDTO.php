<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PartyHallDTO
{
    public ?int $id = null;

    /**
     * Name of the party hall.
     *
     * @Assert\NotBlank(message="Name is required.")
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     *
     * @Assert\NotBlank(message="Address is required.")
     *
     * @var string|null
     */
    public ?string $address = null;

    /**
     *
     * @Assert\NotBlank(message="City is required.")
     *
     * @var string|null
     */
    public ?string $city = null;
}
