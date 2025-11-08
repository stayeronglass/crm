<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251108174155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA76B715464');
        $this->addSql('DROP INDEX IDX_3BAE0AA76B715464 ON event');
        $this->addSql('ALTER TABLE event ADD place_id INT DEFAULT NULL, CHANGE filters_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7ED5CA9E6 FOREIGN KEY (service_id) REFERENCES filter (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DA6A219 FOREIGN KEY (place_id) REFERENCES filter (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7ED5CA9E6 ON event (service_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7DA6A219 ON event (place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7ED5CA9E6');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7DA6A219');
        $this->addSql('DROP INDEX IDX_3BAE0AA7ED5CA9E6 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7DA6A219 ON event');
        $this->addSql('ALTER TABLE event ADD filters_id INT DEFAULT NULL, DROP service_id, DROP place_id');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76B715464 FOREIGN KEY (filters_id) REFERENCES filter (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA76B715464 ON event (filters_id)');
    }
}
