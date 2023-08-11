<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810112535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, idrole INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, cin VARCHAR(50) NOT NULL, date_naiss DATETIME NOT NULL, age VARCHAR(50) NOT NULL, num_permis VARCHAR(50) NOT NULL, ville VARCHAR(50) NOT NULL, num_tel VARCHAR(50) NOT NULL, login VARCHAR(255) NOT NULL, mdp VARCHAR(50) NOT NULL, photo_personel VARCHAR(50) NOT NULL, carte_etudiant VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_880E0D7684A67BCA (idrole), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D7684A67BCA FOREIGN KEY (idrole) REFERENCES role (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE role CHANGE type type VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP INDEX fk, ADD UNIQUE INDEX UNIQ_1D1C63B384A67BCA (idrole)');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL, CHANGE cin cin VARCHAR(50) NOT NULL, CHANGE date_naiss date_naiss DATETIME NOT NULL, CHANGE age age VARCHAR(50) NOT NULL, CHANGE identifiant identifiant VARCHAR(50) NOT NULL, CHANGE ville ville VARCHAR(50) NOT NULL, CHANGE num_tel num_tel VARCHAR(50) NOT NULL, CHANGE mdp mdp VARCHAR(50) NOT NULL, CHANGE photo_personel photo_personel VARCHAR(50) NOT NULL, CHANGE carte_etudiant carte_etudiant VARCHAR(50) NOT NULL, CHANGE idrole idrole INT DEFAULT NULL, CHANGE etat etat VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B384A67BCA FOREIGN KEY (idrole) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D7684A67BCA');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE role CHANGE type type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP INDEX UNIQ_1D1C63B384A67BCA, ADD INDEX fk (idrole)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B384A67BCA');
        $this->addSql('ALTER TABLE utilisateur CHANGE idrole idrole INT NOT NULL, CHANGE nom nom VARCHAR(35) NOT NULL, CHANGE prenom prenom VARCHAR(35) NOT NULL, CHANGE cin cin VARCHAR(12) NOT NULL, CHANGE date_naiss date_naiss VARCHAR(255) NOT NULL, CHANGE age age VARCHAR(255) NOT NULL, CHANGE identifiant identifiant VARCHAR(12) NOT NULL, CHANGE ville ville VARCHAR(40) NOT NULL, CHANGE num_tel num_tel VARCHAR(12) NOT NULL, CHANGE mdp mdp VARCHAR(255) NOT NULL, CHANGE photo_personel photo_personel VARCHAR(255) NOT NULL, CHANGE carte_etudiant carte_etudiant VARCHAR(255) NOT NULL, CHANGE etat etat VARCHAR(155) DEFAULT NULL');
    }
}
