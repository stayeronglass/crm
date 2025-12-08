<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251206164404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slot_resource (slot_id INT NOT NULL, resource_id INT NOT NULL, INDEX IDX_6DC4958559E5119C (slot_id), INDEX IDX_6DC4958589329D25 (resource_id), PRIMARY KEY(slot_id, resource_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot_service (slot_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_F9BF87659E5119C (slot_id), INDEX IDX_F9BF876ED5CA9E6 (service_id), PRIMARY KEY(slot_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slot_resource ADD CONSTRAINT FK_6DC4958559E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_resource ADD CONSTRAINT FK_6DC4958589329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_service ADD CONSTRAINT FK_F9BF87659E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_service ADD CONSTRAINT FK_F9BF876ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot DROP FOREIGN KEY FK_AC0E206789329D25');
        $this->addSql('ALTER TABLE slot DROP FOREIGN KEY FK_AC0E2067ED5CA9E6');
        $this->addSql('DROP INDEX IDX_AC0E2067ED5CA9E6 ON slot');
        $this->addSql('DROP INDEX IDX_AC0E206789329D25 ON slot');
        $this->addSql('ALTER TABLE slot DROP resource_id, DROP service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slot_resource DROP FOREIGN KEY FK_6DC4958559E5119C');
        $this->addSql('ALTER TABLE slot_resource DROP FOREIGN KEY FK_6DC4958589329D25');
        $this->addSql('ALTER TABLE slot_service DROP FOREIGN KEY FK_F9BF87659E5119C');
        $this->addSql('ALTER TABLE slot_service DROP FOREIGN KEY FK_F9BF876ED5CA9E6');
        $this->addSql('DROP TABLE slot_resource');
        $this->addSql('DROP TABLE slot_service');
        $this->addSql('ALTER TABLE slot ADD resource_id INT DEFAULT NULL, ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206789329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E2067ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_AC0E2067ED5CA9E6 ON slot (service_id)');
        $this->addSql('CREATE INDEX IDX_AC0E206789329D25 ON slot (resource_id)');
    }
}
