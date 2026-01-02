<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260102113052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, client_name VARCHAR(255) DEFAULT NULL, client_email VARCHAR(255) DEFAULT NULL, client_phone VARCHAR(11) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD client_id INT DEFAULT NULL, DROP client_phone, DROP client_name, DROP client_email');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA719EB6921 ON event (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA719EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP INDEX IDX_3BAE0AA719EB6921 ON event');
        $this->addSql('ALTER TABLE event ADD client_phone VARCHAR(11) DEFAULT NULL, ADD client_name VARCHAR(255) DEFAULT NULL, ADD client_email VARCHAR(255) DEFAULT NULL, DROP client_id');
    }
}
