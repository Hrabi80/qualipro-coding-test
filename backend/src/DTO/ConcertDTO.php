<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class ConcertDTO
{
    public ?int $id = null;
    /**
     * Concert date in Y-m-d format.
     *
     * @Assert\NotBlank(message="Date is required.")
     * @Assert\Date(message="The date must be a valid date.")
     *
     * @var string|null
     */
    public ?string $date = null;
    /**
     * Associated PartyHall ID.
     *
     * @Assert\Type(type="integer", message="Party hall ID must be an integer.")
     *
     * @var int|null
     */
    public ?int $party_hall_id = null;
    /**
     * List of MusicalBand IDs.
     *
     * @Assert\All({
     *     @Assert\Type(type="integer", message="Each band ID must be an integer.")
     * })
     *
     * @var int[]
     */
    public array $band_ids = [];
}




