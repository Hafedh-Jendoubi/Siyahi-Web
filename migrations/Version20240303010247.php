<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303010247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande_achat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, achat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_demande DATE NOT NULL, num_tel VARCHAR(255) NOT NULL, type_paiement VARCHAR(255) NOT NULL, cin INT NOT NULL, adresse VARCHAR(255) NOT NULL, etatdemande VARCHAR(255) NOT NULL, INDEX IDX_D077077FA76ED395 (user_id), INDEX IDX_D077077FFE95D117 (achat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_achat ADD CONSTRAINT FK_D077077FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande_achat ADD CONSTRAINT FK_D077077FFE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id)');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A9845682EA2E54');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456A76ED395');
        $this->addSql('DROP INDEX UNIQ_26A9845682EA2E54 ON achat');
        $this->addSql('DROP INDEX IDX_26A98456A76ED395 ON achat');
        $this->addSql('ALTER TABLE achat ADD image VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, DROP commande_id, DROP user_id, DROP montant, DROP date');
        $this->addSql('ALTER TABLE reclamation ADD date_creation DATE NOT NULL, ADD auteur VARCHAR(255) NOT NULL, ADD status VARCHAR(15) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponse_conge ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponse_reclamation ADD date_creation DATE NOT NULL, ADD auteur VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE old_email old_email VARCHAR(255) NOT NULL, CHANGE activity activity VARCHAR(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_achat DROP FOREIGN KEY FK_D077077FA76ED395');
        $this->addSql('ALTER TABLE demande_achat DROP FOREIGN KEY FK_D077077FFE95D117');
        $this->addSql('DROP TABLE demande_achat');
        $this->addSql('ALTER TABLE achat ADD commande_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD montant DOUBLE PRECISION NOT NULL, ADD date DATE NOT NULL, DROP image, DROP type, DROP description');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A9845682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26A9845682EA2E54 ON achat (commande_id)');
        $this->addSql('CREATE INDEX IDX_26A98456A76ED395 ON achat (user_id)');
        $this->addSql('ALTER TABLE reclamation DROP date_creation, DROP auteur, DROP status, DROP email');
        $this->addSql('ALTER TABLE reponse_conge DROP description');
        $this->addSql('ALTER TABLE reponse_reclamation DROP date_creation, DROP auteur');
        $this->addSql('ALTER TABLE user CHANGE old_email old_email VARCHAR(255) DEFAULT NULL, CHANGE activity activity VARCHAR(1) DEFAULT NULL');
    }
}
