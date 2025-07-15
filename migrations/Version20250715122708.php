<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250715122708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affecte (id INT AUTO_INCREMENT NOT NULL, formateur_id INT DEFAULT NULL, session_id INT DEFAULT NULL, confirme_presence TINYINT(1) NOT NULL, INDEX IDX_4890ADE8155D8F51 (formateur_id), INDEX IDX_4890ADE8613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checklist (id INT AUTO_INCREMENT NOT NULL, salle TINYINT(1) NOT NULL, machines TINYINT(1) NOT NULL, supports TINYINT(1) NOT NULL, formulaire TINYINT(1) NOT NULL, fiche_presence TINYINT(1) NOT NULL, tickets_repas TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, salle_id INT NOT NULL, nom VARCHAR(255) NOT NULL, responsable VARCHAR(255) NOT NULL, nbr_participant INT NOT NULL, date_debut DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_fin DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B26681EDC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_presence (id INT AUTO_INCREMENT NOT NULL, stagiaire_id INT NOT NULL, jour DATE NOT NULL, est_present TINYINT(1) NOT NULL, retard INT DEFAULT NULL, INDEX IDX_F69FD34BBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_satisfaction (id INT AUTO_INCREMENT NOT NULL, stagiaire_id INT NOT NULL, note_satisfaction INT NOT NULL, note_clarete INT NOT NULL, problemes LONGTEXT DEFAULT NULL, suggestions LONGTEXT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_E0C94771BBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, cv VARCHAR(255) NOT NULL, est_valide TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, fiche_formation LONGTEXT NOT NULL, INDEX IDX_404021BF59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom_prenom VARCHAR(255) NOT NULL, expediteur VARCHAR(255) NOT NULL, destinataire VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_5126AC48A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, stagiaire_id INT NOT NULL, evaluation_id INT NOT NULL, valeur INT NOT NULL, date DATE NOT NULL, INDEX IDX_CFBDFA14BBA93DD6 (stagiaire_id), INDEX IDX_CFBDFA14456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, est_choix_multiple TINYINT(1) NOT NULL, INDEX IDX_B6F7494E456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, est_correct TINYINT(1) NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, centreformation_id INT NOT NULL, nom VARCHAR(255) NOT NULL, nbr_places INT NOT NULL, INDEX IDX_4E977E5C49F655FA (centreformation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, checklist_id INT NOT NULL, salle_id INT NOT NULL, min_participant INT NOT NULL, prix DOUBLE PRECISION NOT NULL, date_debut DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_fin DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D044D5D45200282E (formation_id), UNIQUE INDEX UNIQ_D044D5D4B16D08A7 (checklist_id), INDEX IDX_D044D5D4DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_stagiaire (session_id INT NOT NULL, stagiaire_id INT NOT NULL, INDEX IDX_C80B23B613FECDF (session_id), INDEX IDX_C80B23BBBA93DD6 (stagiaire_id), PRIMARY KEY(session_id, stagiaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_theme (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_E891E7ED59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, prerequis_valide TINYINT(1) NOT NULL, INDEX IDX_4F62F7315200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affecte ADD CONSTRAINT FK_4890ADE8155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE affecte ADD CONSTRAINT FK_4890ADE8613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE fiche_presence ADD CONSTRAINT FK_F69FD34BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE form_satisfaction ADD CONSTRAINT FK_E0C94771BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE mail ADD CONSTRAINT FK_5126AC48A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5C49F655FA FOREIGN KEY (centreformation_id) REFERENCES centre_formation (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4B16D08A7 FOREIGN KEY (checklist_id) REFERENCES checklist (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE session_stagiaire ADD CONSTRAINT FK_C80B23B613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_stagiaire ADD CONSTRAINT FK_C80B23BBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sous_theme ADD CONSTRAINT FK_E891E7ED59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F7315200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affecte DROP FOREIGN KEY FK_4890ADE8155D8F51');
        $this->addSql('ALTER TABLE affecte DROP FOREIGN KEY FK_4890ADE8613FECDF');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EDC304035');
        $this->addSql('ALTER TABLE fiche_presence DROP FOREIGN KEY FK_F69FD34BBA93DD6');
        $this->addSql('ALTER TABLE form_satisfaction DROP FOREIGN KEY FK_E0C94771BBA93DD6');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4FBF396750');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF59027487');
        $this->addSql('ALTER TABLE mail DROP FOREIGN KEY FK_5126AC48A76ED395');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14BBA93DD6');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14456C5646');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E456C5646');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5C49F655FA');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45200282E');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4B16D08A7');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4DC304035');
        $this->addSql('ALTER TABLE session_stagiaire DROP FOREIGN KEY FK_C80B23B613FECDF');
        $this->addSql('ALTER TABLE session_stagiaire DROP FOREIGN KEY FK_C80B23BBBA93DD6');
        $this->addSql('ALTER TABLE sous_theme DROP FOREIGN KEY FK_E891E7ED59027487');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F7315200282E');
        $this->addSql('DROP TABLE affecte');
        $this->addSql('DROP TABLE centre_formation');
        $this->addSql('DROP TABLE checklist');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE fiche_presence');
        $this->addSql('DROP TABLE form_satisfaction');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE mail');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_stagiaire');
        $this->addSql('DROP TABLE sous_theme');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
