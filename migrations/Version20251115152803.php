<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251115152803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, resource_id INT DEFAULT NULL, service_id INT DEFAULT NULL, slot_id INT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, date_begin DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', date_end DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_3BAE0AA789329D25 (resource_id), INDEX IDX_3BAE0AA7ED5CA9E6 (service_id), INDEX IDX_3BAE0AA759E5119C (slot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_begin DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', date_end DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_BC91F416A977936C (tree_root), INDEX IDX_BC91F416727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_slot (resource_id INT NOT NULL, slot_id INT NOT NULL, INDEX IDX_A32E80DD89329D25 (resource_id), INDEX IDX_A32E80DD59E5119C (slot_id), PRIMARY KEY(resource_id, slot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA789329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA759E5119C FOREIGN KEY (slot_id) REFERENCES slot (id)');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416A977936C FOREIGN KEY (tree_root) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416727ACA70 FOREIGN KEY (parent_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_slot ADD CONSTRAINT FK_A32E80DD89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_slot ADD CONSTRAINT FK_A32E80DD59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE resource_type');
        $this->addSql('ALTER TABLE slot ADD resource_id INT DEFAULT NULL, ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206789329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E2067ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_AC0E206789329D25 ON slot (resource_id)');
        $this->addSql('CREATE INDEX IDX_AC0E2067ED5CA9E6 ON slot (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slot DROP FOREIGN KEY FK_AC0E206789329D25');
        $this->addSql('ALTER TABLE slot DROP FOREIGN KEY FK_AC0E2067ED5CA9E6');
        $this->addSql('CREATE TABLE resource_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA789329D25');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7ED5CA9E6');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA759E5119C');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416A977936C');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416727ACA70');
        $this->addSql('ALTER TABLE resource_slot DROP FOREIGN KEY FK_A32E80DD89329D25');
        $this->addSql('ALTER TABLE resource_slot DROP FOREIGN KEY FK_A32E80DD59E5119C');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE resource_slot');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX IDX_AC0E206789329D25 ON slot');
        $this->addSql('DROP INDEX IDX_AC0E2067ED5CA9E6 ON slot');
        $this->addSql('ALTER TABLE slot DROP resource_id, DROP service_id');
    }
}
