<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208123549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_26A98456A76ED395 ON achat (user_id)');
        $this->addSql('ALTER TABLE commande ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA76ED395 ON commande (user_id)');
        $this->addSql('ALTER TABLE compte_client ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte_client ADD CONSTRAINT FK_1DDD5D62A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_1DDD5D62A76ED395 ON compte_client (user_id)');
        $this->addSql('ALTER TABLE conge ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conge ADD CONSTRAINT FK_2ED89348A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2ED89348A76ED395 ON conge (user_id)');
        $this->addSql('ALTER TABLE credit ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_1CC16EFEA76ED395 ON credit (user_id)');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE reponse_conge ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse_conge ADD CONSTRAINT FK_C131E82BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_C131E82BA76ED395 ON reponse_conge (user_id)');
        $this->addSql('ALTER TABLE reponse_credit ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse_credit ADD CONSTRAINT FK_C895B767A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_C895B767A76ED395 ON reponse_credit (user_id)');
        $this->addSql('ALTER TABLE reponse_reclamation ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse_reclamation ADD CONSTRAINT FK_C7CB5101A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_C7CB5101A76ED395 ON reponse_reclamation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456A76ED395');
        $this->addSql('DROP INDEX IDX_26A98456A76ED395 ON achat');
        $this->addSql('ALTER TABLE achat DROP user_id');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('DROP INDEX IDX_6EEAA67DA76ED395 ON commande');
        $this->addSql('ALTER TABLE commande DROP user_id');
        $this->addSql('ALTER TABLE compte_client DROP FOREIGN KEY FK_1DDD5D62A76ED395');
        $this->addSql('DROP INDEX IDX_1DDD5D62A76ED395 ON compte_client');
        $this->addSql('ALTER TABLE compte_client DROP user_id');
        $this->addSql('ALTER TABLE conge DROP FOREIGN KEY FK_2ED89348A76ED395');
        $this->addSql('DROP INDEX UNIQ_2ED89348A76ED395 ON conge');
        $this->addSql('ALTER TABLE conge DROP user_id');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFEA76ED395');
        $this->addSql('DROP INDEX IDX_1CC16EFEA76ED395 ON credit');
        $this->addSql('ALTER TABLE credit DROP user_id');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id');
        $this->addSql('ALTER TABLE reponse_conge DROP FOREIGN KEY FK_C131E82BA76ED395');
        $this->addSql('DROP INDEX IDX_C131E82BA76ED395 ON reponse_conge');
        $this->addSql('ALTER TABLE reponse_conge DROP user_id');
        $this->addSql('ALTER TABLE reponse_credit DROP FOREIGN KEY FK_C895B767A76ED395');
        $this->addSql('DROP INDEX IDX_C895B767A76ED395 ON reponse_credit');
        $this->addSql('ALTER TABLE reponse_credit DROP user_id');
        $this->addSql('ALTER TABLE reponse_reclamation DROP FOREIGN KEY FK_C7CB5101A76ED395');
        $this->addSql('DROP INDEX IDX_C7CB5101A76ED395 ON reponse_reclamation');
        $this->addSql('ALTER TABLE reponse_reclamation DROP user_id');
    }
}
