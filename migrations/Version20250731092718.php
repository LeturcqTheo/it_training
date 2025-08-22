<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250731092718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_sous_theme (formation_id INT NOT NULL, sous_theme_id INT NOT NULL, INDEX IDX_103934D45200282E (formation_id), INDEX IDX_103934D4514C40D2 (sous_theme_id), PRIMARY KEY(formation_id, sous_theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_sous_theme ADD CONSTRAINT FK_103934D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_sous_theme ADD CONSTRAINT FK_103934D4514C40D2 FOREIGN KEY (sous_theme_id) REFERENCES sous_theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_soustheme DROP FOREIGN KEY FK_8E2099825200282E');
        $this->addSql('ALTER TABLE formation_soustheme DROP FOREIGN KEY FK_8E209982E43EDB7');
        $this->addSql('DROP TABLE formation_soustheme');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_soustheme (formation_id INT NOT NULL, soustheme_id INT NOT NULL, INDEX IDX_8E2099825200282E (formation_id), INDEX IDX_8E209982E43EDB7 (soustheme_id), PRIMARY KEY(formation_id, soustheme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE formation_soustheme ADD CONSTRAINT FK_8E2099825200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_soustheme ADD CONSTRAINT FK_8E209982E43EDB7 FOREIGN KEY (soustheme_id) REFERENCES sous_theme (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_sous_theme DROP FOREIGN KEY FK_103934D45200282E');
        $this->addSql('ALTER TABLE formation_sous_theme DROP FOREIGN KEY FK_103934D4514C40D2');
        $this->addSql('DROP TABLE formation_sous_theme');
    }
}
