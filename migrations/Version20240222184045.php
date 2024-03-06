<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222184045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_achat ADD achat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_achat ADD CONSTRAINT FK_D077077FFE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id)');
        $this->addSql('CREATE INDEX IDX_D077077FFE95D117 ON demande_achat (achat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_achat DROP FOREIGN KEY FK_D077077FFE95D117');
        $this->addSql('DROP INDEX IDX_D077077FFE95D117 ON demande_achat');
        $this->addSql('ALTER TABLE demande_achat DROP achat_id');
    }
}
