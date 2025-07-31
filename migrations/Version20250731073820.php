<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250731073820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_soustheme (formation_id INT NOT NULL, soustheme_id INT NOT NULL, INDEX IDX_8E2099825200282E (formation_id), INDEX IDX_8E209982E43EDB7 (soustheme_id), PRIMARY KEY(formation_id, soustheme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_soustheme ADD CONSTRAINT FK_8E2099825200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_soustheme ADD CONSTRAINT FK_8E209982E43EDB7 FOREIGN KEY (soustheme_id) REFERENCES sous_theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF59027487');
        $this->addSql('DROP INDEX IDX_404021BF59027487 ON formation');
        $this->addSql('ALTER TABLE formation DROP theme_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_soustheme DROP FOREIGN KEY FK_8E2099825200282E');
        $this->addSql('ALTER TABLE formation_soustheme DROP FOREIGN KEY FK_8E209982E43EDB7');
        $this->addSql('DROP TABLE formation_soustheme');
        $this->addSql('ALTER TABLE formation ADD theme_id INT NOT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_404021BF59027487 ON formation (theme_id)');
    }
}
