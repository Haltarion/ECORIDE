<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251116173628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, note INT NOT NULL, commentaire VARCHAR(255) NOT NULL, statut VARCHAR(50) NOT NULL, date_avis DATE NOT NULL, auteur_id INT NOT NULL, conducteur_id INT NOT NULL, INDEX IDX_8F91ABF060BB6FE6 (auteur_id), INDEX IDX_8F91ABF0F16F4AC6 (conducteur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE covoiturage (id INT AUTO_INCREMENT NOT NULL, date_depart DATE NOT NULL, heure_depart TIME NOT NULL, adresse_depart VARCHAR(50) NOT NULL, date_arrivee DATE NOT NULL, adresse_arrivee VARCHAR(50) NOT NULL, heure_arrivee TIME NOT NULL, statut VARCHAR(50) NOT NULL, nb_places INT NOT NULL, prix_par_personne NUMERIC(5, 2) NOT NULL, voiture_id INT NOT NULL, conducteur_id INT NOT NULL, INDEX IDX_28C79E89181A8BA (voiture_id), INDEX IDX_28C79E89F16F4AC6 (conducteur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE covoiturage_passagers (covoiturage_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_1B8D425662671590 (covoiturage_id), INDEX IDX_1B8D4256FB88E14F (utilisateur_id), PRIMARY KEY (covoiturage_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE preferences (id INT AUTO_INCREMENT NOT NULL, fumeur TINYINT(1) NOT NULL, animal TINYINT(1) NOT NULL, perso VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_E6D6B297A4D60759 (libelle), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(60) NOT NULL, roles JSON NOT NULL, preferences_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B386CC499D (pseudo), UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), UNIQUE INDEX UNIQ_1D1C63B37CCD6FB7 (preferences_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur_profils (utilisateur_id INT NOT NULL, profil_id INT NOT NULL, INDEX IDX_F88E8CCFB88E14F (utilisateur_id), INDEX IDX_F88E8CC275ED078 (profil_id), PRIMARY KEY (utilisateur_id, profil_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, date_premiere_immatriculation DATE NOT NULL, marque VARCHAR(50) NOT NULL, modele VARCHAR(50) NOT NULL, energie VARCHAR(50) NOT NULL, couleur VARCHAR(50) NOT NULL, nb_place_dispo INT NOT NULL, immatriculation VARCHAR(20) NOT NULL, utilisateur_id INT NOT NULL, UNIQUE INDEX UNIQ_E9E2810FBE73422E (immatriculation), INDEX IDX_E9E2810FFB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF060BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0F16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89F16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE covoiturage_passagers ADD CONSTRAINT FK_1B8D425662671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE covoiturage_passagers ADD CONSTRAINT FK_1B8D4256FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B37CCD6FB7 FOREIGN KEY (preferences_id) REFERENCES preferences (id)');
        $this->addSql('ALTER TABLE utilisateur_profils ADD CONSTRAINT FK_F88E8CCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_profils ADD CONSTRAINT FK_F88E8CC275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF060BB6FE6');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0F16F4AC6');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89181A8BA');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89F16F4AC6');
        $this->addSql('ALTER TABLE covoiturage_passagers DROP FOREIGN KEY FK_1B8D425662671590');
        $this->addSql('ALTER TABLE covoiturage_passagers DROP FOREIGN KEY FK_1B8D4256FB88E14F');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B37CCD6FB7');
        $this->addSql('ALTER TABLE utilisateur_profils DROP FOREIGN KEY FK_F88E8CCFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_profils DROP FOREIGN KEY FK_F88E8CC275ED078');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FFB88E14F');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE covoiturage');
        $this->addSql('DROP TABLE covoiturage_passagers');
        $this->addSql('DROP TABLE preferences');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_profils');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
