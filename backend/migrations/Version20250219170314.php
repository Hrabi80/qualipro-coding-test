<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250219170314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, party_hall_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_D57C02D2405E50FD (party_hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_musical_band (concert_id INT NOT NULL, musical_band_id INT NOT NULL, INDEX IDX_427489BB83C97B2E (concert_id), INDEX IDX_427489BBA06F9737 (musical_band_id), PRIMARY KEY(concert_id, musical_band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musical_band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, origin VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, founded_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', separation_date DATE DEFAULT NULL, founders VARCHAR(255) NOT NULL, members INT NOT NULL, music_style VARCHAR(255) DEFAULT NULL, about LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party_hall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D2405E50FD FOREIGN KEY (party_hall_id) REFERENCES party_hall (id)');
        $this->addSql('ALTER TABLE concert_musical_band ADD CONSTRAINT FK_427489BB83C97B2E FOREIGN KEY (concert_id) REFERENCES concert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert_musical_band ADD CONSTRAINT FK_427489BBA06F9737 FOREIGN KEY (musical_band_id) REFERENCES musical_band (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D2405E50FD');
        $this->addSql('ALTER TABLE concert_musical_band DROP FOREIGN KEY FK_427489BB83C97B2E');
        $this->addSql('ALTER TABLE concert_musical_band DROP FOREIGN KEY FK_427489BBA06F9737');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE concert_musical_band');
        $this->addSql('DROP TABLE musical_band');
        $this->addSql('DROP TABLE party_hall');
    }
}
