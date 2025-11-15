<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251115153553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resource_slot DROP FOREIGN KEY FK_A32E80DD59E5119C');
        $this->addSql('ALTER TABLE resource_slot DROP FOREIGN KEY FK_A32E80DD89329D25');
        $this->addSql('DROP TABLE resource_slot');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resource_slot (resource_id INT NOT NULL, slot_id INT NOT NULL, INDEX IDX_A32E80DD59E5119C (slot_id), INDEX IDX_A32E80DD89329D25 (resource_id), PRIMARY KEY(resource_id, slot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE resource_slot ADD CONSTRAINT FK_A32E80DD59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_slot ADD CONSTRAINT FK_A32E80DD89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
    }
}
