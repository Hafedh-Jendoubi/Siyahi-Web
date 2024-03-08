<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306164723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
