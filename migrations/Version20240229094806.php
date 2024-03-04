<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229094806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation ADD date_creation DATE NOT NULL, ADD auteur VARCHAR(255) NOT NULL, ADD status VARCHAR(15) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponse_reclamation ADD date_creation DATE NOT NULL, ADD auteur VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP date_creation, DROP auteur, DROP status, DROP email');
        $this->addSql('ALTER TABLE reponse_reclamation DROP date_creation, DROP auteur');
    }
}