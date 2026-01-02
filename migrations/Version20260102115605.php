<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260102115605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C7440455E7220B6A ON client');
        $this->addSql('ALTER TABLE client ADD name VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD telegram VARCHAR(255) DEFAULT NULL, DROP client_name, DROP client_email, CHANGE client_phone phone VARCHAR(11) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_C7440455444F97DD ON client (phone)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C7440455444F97DD ON client');
        $this->addSql('ALTER TABLE client ADD client_name VARCHAR(255) DEFAULT NULL, ADD client_email VARCHAR(255) DEFAULT NULL, DROP name, DROP email, DROP telegram, CHANGE phone client_phone VARCHAR(11) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_C7440455E7220B6A ON client (client_phone)');
    }
}
