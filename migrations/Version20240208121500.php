<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208121500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conge (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, justification VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit (id INT AUTO_INCREMENT NOT NULL, solde_demande DOUBLE PRECISION NOT NULL, date_debut_paiement DATE NOT NULL, nbr_mois_paiement INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_conge (id INT AUTO_INCREMENT NOT NULL, conge_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_C131E82BCAAC9A59 (conge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_credit (id INT AUTO_INCREMENT NOT NULL, credit_id INT DEFAULT NULL, solde_a_payer DOUBLE PRECISION NOT NULL, date_debut_paiement DATE NOT NULL, nbr_mois_paiement INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C895B767CE062FF9 (credit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponse_conge ADD CONSTRAINT FK_C131E82BCAAC9A59 FOREIGN KEY (conge_id) REFERENCES conge (id)');
        $this->addSql('ALTER TABLE reponse_credit ADD CONSTRAINT FK_C895B767CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_conge DROP FOREIGN KEY FK_C131E82BCAAC9A59');
        $this->addSql('ALTER TABLE reponse_credit DROP FOREIGN KEY FK_C895B767CE062FF9');
        $this->addSql('DROP TABLE conge');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE reponse_conge');
        $this->addSql('DROP TABLE reponse_credit');
    }
}
