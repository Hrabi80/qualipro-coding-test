<?php
namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class MusicalBandDTO
{
    public ?int $id = null;
    /**
     *
     * @Assert\NotBlank(message="Name is required.")
     *
     * @var string|null
     */
    public ?string $name = null;
    /**
     *
     * @Assert\NotBlank(message="Origin is required.")
     *
     * @var string|null
     */
    public ?string $origin = null;
    /**
     *
     * @Assert\NotBlank(message="City is required.")
     *
     * @var string|null
     */
    public ?string $city = null;
    /**
     *
     * @Assert\NotBlank(message="Founded date is required.")
     * @Assert\Date(message="Founded date must be a valid date.")
     *
     * @var string|null
     */
    public ?string $founded_at = null;
    /**
     * Separation date in Y-m-d format.
     *
     * @Assert\Date(message="Separation date must be a valid date.")
     *
     * @var string|null
     */
    public ?string $separation_date = null;
    /**
     *
     * @Assert\NotBlank(message="Founders information is required.")
     *
     * @var string|null
     */
    public ?string $founders = null;
    /**
     * Number of members.
     *
     * @Assert\NotBlank(message="Number of members is required.")
     * @Assert\Type(type="integer", message="Members must be an integer.")
     *
     * @var int|null
     */
    public ?int $members = null;
    public ?string $music_style = null;
    /**
     * About the band.
     *
     * @Assert\NotBlank(message="About field is required.")
     *
     * @var string|null
     */
    public ?string $about = null;
}
