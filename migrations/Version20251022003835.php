<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251022003835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slot_filter DROP FOREIGN KEY FK_77C7D71FD395B25E');
        $this->addSql('ALTER TABLE slot_filter DROP FOREIGN KEY FK_77C7D71F59E5119C');
        $this->addSql('DROP TABLE slot_filter');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slot_filter (slot_id INT NOT NULL, filter_id INT NOT NULL, INDEX IDX_77C7D71FD395B25E (filter_id), INDEX IDX_77C7D71F59E5119C (slot_id), PRIMARY KEY(slot_id, filter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE slot_filter ADD CONSTRAINT FK_77C7D71FD395B25E FOREIGN KEY (filter_id) REFERENCES filter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_filter ADD CONSTRAINT FK_77C7D71F59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
    }
}
