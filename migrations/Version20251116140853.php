<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251116140853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY `fk_user_assign_to`');
        $this->addSql('ALTER TABLE covoiturages DROP FOREIGN KEY `fk_car`');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY `fk_covoiturage`');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY `fk_utilisateur`');
        $this->addSql('ALTER TABLE voitures DROP FOREIGN KEY `fk_driver`');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE covoiturages');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE preferences');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE voitures');
        $this->addSql('ALTER TABLE utilisateurs DROP FOREIGN KEY `fk_preference_of_user`');
        $this->addSql('ALTER TABLE utilisateurs DROP FOREIGN KEY `fk_role_of_user`');
        $this->addSql('DROP INDEX fk_preference_of_user ON utilisateurs');
        $this->addSql('DROP INDEX pseudo_UNIQUE ON utilisateurs');
        $this->addSql('DROP INDEX utilisateur_id_UNIQUE ON utilisateurs');
        $this->addSql('DROP INDEX fk_role_of_user ON utilisateurs');
        $this->addSql('ALTER TABLE utilisateurs MODIFY utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE photo photo LONGBLOB DEFAULT NULL, CHANGE role_of role_of INT NOT NULL, CHANGE utilisateur_id id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315EE7927C74 ON utilisateurs (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (avis_id INT AUTO_INCREMENT NOT NULL, note INT DEFAULT 5 NOT NULL, commentaire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, statut VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, assign_to INT NOT NULL, INDEX fk_user_assign_to (assign_to), PRIMARY KEY (avis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE covoiturages (covoiturage_id INT AUTO_INCREMENT NOT NULL, date_depart DATE NOT NULL, heure_depart TIME NOT NULL, adresse_depart VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_arrivee DATE NOT NULL, heure_arrivee TIME NOT NULL, adresse_arrivee VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, statut VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nb_paces INT NOT NULL, prix_personne NUMERIC(2, 2) NOT NULL, car VARCHAR(9) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, driver_of INT NOT NULL, INDEX fk_car (car), PRIMARY KEY (covoiturage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participants (covoiturage_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX fk_utilisateur (utilisateur_id), INDEX IDX_7169709262671590 (covoiturage_id), PRIMARY KEY (covoiturage_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE preferences (preference_id INT AUTO_INCREMENT NOT NULL, fumeur TINYINT(1) DEFAULT 0 NOT NULL, animal TINYINT(1) DEFAULT 0 NOT NULL, perso VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY (preference_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE roles (role_id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY (role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voitures (immatriculation_id VARCHAR(9) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_premiere_immatriculation DATE NOT NULL, marque VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, modele VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, electrique TINYINT(1) NOT NULL, couleur VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nb_places_dispos INT NOT NULL, driver INT NOT NULL, INDEX fk_driver (driver), PRIMARY KEY (immatriculation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT `fk_user_assign_to` FOREIGN KEY (assign_to) REFERENCES utilisateurs (utilisateur_id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE covoiturages ADD CONSTRAINT `fk_car` FOREIGN KEY (car) REFERENCES voitures (immatriculation_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT `fk_covoiturage` FOREIGN KEY (covoiturage_id) REFERENCES covoiturages (covoiturage_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT `fk_utilisateur` FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (utilisateur_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voitures ADD CONSTRAINT `fk_driver` FOREIGN KEY (driver) REFERENCES utilisateurs (utilisateur_id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX UNIQ_497B315EE7927C74 ON utilisateurs');
        $this->addSql('ALTER TABLE utilisateurs MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE photo photo BLOB DEFAULT NULL, CHANGE role_of role_of INT DEFAULT 1 NOT NULL, CHANGE id utilisateur_id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT `fk_preference_of_user` FOREIGN KEY (user_preferences) REFERENCES preferences (preference_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT `fk_role_of_user` FOREIGN KEY (role_of) REFERENCES roles (role_id) ON UPDATE CASCADE ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX fk_preference_of_user ON utilisateurs (user_preferences)');
        $this->addSql('CREATE UNIQUE INDEX pseudo_UNIQUE ON utilisateurs (pseudo)');
        $this->addSql('CREATE UNIQUE INDEX utilisateur_id_UNIQUE ON utilisateurs (utilisateur_id)');
        $this->addSql('CREATE INDEX fk_role_of_user ON utilisateurs (role_of)');
    }
}
