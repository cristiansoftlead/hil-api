<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116160457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE halls (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AD736D9E64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, name VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C61EED3052AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, chair_number INT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_54469DF48F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE halls ADD CONSTRAINT FK_AD736D9E64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED3052AFCFD6 FOREIGN KEY (hall_id) REFERENCES halls (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF48F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE halls DROP FOREIGN KEY FK_AD736D9E64D218E');
        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED3052AFCFD6');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF48F93B6FC');
        $this->addSql('DROP TABLE halls');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE tickets');
    }
}
