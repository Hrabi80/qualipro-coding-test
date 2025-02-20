<?php

namespace App\DTO;

class ConcertResponseDto
{
    public int $id;
    public string $date;
    public ?int $party_hall_id;
    public ?string $party_hall_name;
    public array $bands;

    public function __construct(
        int $id,
        string $date,
        ?int $party_hall_id,
        ?string $party_hall_name,
        array $bands
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->party_hall_id = $party_hall_id;
        $this->party_hall_name = $party_hall_name;
        $this->bands = $bands;
    }
}
