<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214215211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, user_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_26A9845682EA2E54 (commande_id), INDEX IDX_26A98456A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, object VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_client (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, rib INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', solde DOUBLE PRECISION NOT NULL, INDEX IDX_1DDD5D62A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conge (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, justification VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2ED89348A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, solde_demande DOUBLE PRECISION NOT NULL, date_debut_paiement DATE NOT NULL, nbr_mois_paiement INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_1CC16EFEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, object VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_conge (id INT AUTO_INCREMENT NOT NULL, conge_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_C131E82BCAAC9A59 (conge_id), INDEX IDX_C131E82BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_credit (id INT AUTO_INCREMENT NOT NULL, credit_id INT DEFAULT NULL, user_id INT DEFAULT NULL, solde_a_payer DOUBLE PRECISION NOT NULL, date_debut_paiement DATE NOT NULL, nbr_mois_paiement INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C895B767CE062FF9 (credit_id), INDEX IDX_C895B767A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_reclamation (id INT AUTO_INCREMENT NOT NULL, reclamation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C7CB51012D6BA2D9 (reclamation_id), INDEX IDX_C7CB5101A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, compte_client_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD2DA655713 (compte_client_id), INDEX IDX_E19D9AD2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(15) NOT NULL, last_name VARCHAR(20) NOT NULL, gender VARCHAR(1) NOT NULL, address VARCHAR(50) DEFAULT NULL, phone_number INT DEFAULT NULL, cin INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', role VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A9845682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE compte_client ADD CONSTRAINT FK_1DDD5D62A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE conge ADD CONSTRAINT FK_2ED89348A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reponse_conge ADD CONSTRAINT FK_C131E82BCAAC9A59 FOREIGN KEY (conge_id) REFERENCES conge (id)');
        $this->addSql('ALTER TABLE reponse_conge ADD CONSTRAINT FK_C131E82BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reponse_credit ADD CONSTRAINT FK_C895B767CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id)');
        $this->addSql('ALTER TABLE reponse_credit ADD CONSTRAINT FK_C895B767A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reponse_reclamation ADD CONSTRAINT FK_C7CB51012D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE reponse_reclamation ADD CONSTRAINT FK_C7CB5101A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2DA655713 FOREIGN KEY (compte_client_id) REFERENCES compte_client (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A9845682EA2E54');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456A76ED395');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE compte_client DROP FOREIGN KEY FK_1DDD5D62A76ED395');
        $this->addSql('ALTER TABLE conge DROP FOREIGN KEY FK_2ED89348A76ED395');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFEA76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reponse_conge DROP FOREIGN KEY FK_C131E82BCAAC9A59');
        $this->addSql('ALTER TABLE reponse_conge DROP FOREIGN KEY FK_C131E82BA76ED395');
        $this->addSql('ALTER TABLE reponse_credit DROP FOREIGN KEY FK_C895B767CE062FF9');
        $this->addSql('ALTER TABLE reponse_credit DROP FOREIGN KEY FK_C895B767A76ED395');
        $this->addSql('ALTER TABLE reponse_reclamation DROP FOREIGN KEY FK_C7CB51012D6BA2D9');
        $this->addSql('ALTER TABLE reponse_reclamation DROP FOREIGN KEY FK_C7CB5101A76ED395');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2DA655713');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE compte_client');
        $this->addSql('DROP TABLE conge');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse_conge');
        $this->addSql('DROP TABLE reponse_credit');
        $this->addSql('DROP TABLE reponse_reclamation');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
