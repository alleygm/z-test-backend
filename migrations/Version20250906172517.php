<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250906172517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD class_id INT NOT NULL');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EEA000B10 FOREIGN KEY (class_id) REFERENCES character_class (id)');
        $this->addSql('CREATE INDEX IDX_3A29410EEA000B10 ON characters (class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `characters` DROP FOREIGN KEY FK_3A29410EEA000B10');
        $this->addSql('DROP INDEX IDX_3A29410EEA000B10 ON `characters`');
        $this->addSql('ALTER TABLE `characters` DROP class_id');
    }
}
