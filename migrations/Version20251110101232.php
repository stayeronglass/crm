<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251110101232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resource_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filter ADD resource_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE filter ADD CONSTRAINT FK_7FC45F1D98EC6B7B FOREIGN KEY (resource_type_id) REFERENCES resource_type (id)');
        $this->addSql('CREATE INDEX IDX_7FC45F1D98EC6B7B ON filter (resource_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filter DROP FOREIGN KEY FK_7FC45F1D98EC6B7B');
        $this->addSql('DROP TABLE resource_type');
        $this->addSql('DROP INDEX IDX_7FC45F1D98EC6B7B ON filter');
        $this->addSql('ALTER TABLE filter DROP resource_type_id');
    }
}
