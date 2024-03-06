<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306114204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, start DATE NOT NULL, end DATE NOT NULL, description VARCHAR(255) NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(255) NOT NULL, border_color VARCHAR(255) NOT NULL, text_color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_achat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, achat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_demande DATE NOT NULL, num_tel VARCHAR(255) NOT NULL, type_paiement VARCHAR(255) NOT NULL, cin INT NOT NULL, adresse VARCHAR(255) NOT NULL, etatdemande VARCHAR(255) NOT NULL, INDEX IDX_D077077FA76ED395 (user_id), INDEX IDX_D077077FFE95D117 (achat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_achat ADD CONSTRAINT FK_D077077FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande_achat ADD CONSTRAINT FK_D077077FFE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte_client ADD service_id INT DEFAULT NULL, DROP type, CHANGE rib rib BIGINT NOT NULL, CHANGE created_at created_at DATE NOT NULL');
        $this->addSql('ALTER TABLE compte_client ADD CONSTRAINT FK_1DDD5D62ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DDD5D62BFB7B5B6 ON compte_client (rib)');
        $this->addSql('CREATE INDEX IDX_1DDD5D62ED5CA9E6 ON compte_client (service_id)');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2DA655713');
        $this->addSql('DROP INDEX IDX_E19D9AD2DA655713 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD2A76ED395 ON service');
        $this->addSql('ALTER TABLE service DROP compte_client_id, DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_achat DROP FOREIGN KEY FK_D077077FA76ED395');
        $this->addSql('ALTER TABLE demande_achat DROP FOREIGN KEY FK_D077077FFE95D117');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE demande_achat');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE compte_client DROP FOREIGN KEY FK_1DDD5D62ED5CA9E6');
        $this->addSql('DROP INDEX UNIQ_1DDD5D62BFB7B5B6 ON compte_client');
        $this->addSql('DROP INDEX IDX_1DDD5D62ED5CA9E6 ON compte_client');
        $this->addSql('ALTER TABLE compte_client ADD type VARCHAR(255) NOT NULL, DROP service_id, CHANGE rib rib INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE service ADD compte_client_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2DA655713 FOREIGN KEY (compte_client_id) REFERENCES compte_client (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2DA655713 ON service (compte_client_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2A76ED395 ON service (user_id)');
    }
}
