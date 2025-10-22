<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251022003638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filter (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, date_begin DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', date_end DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_7FC45F1DA977936C (tree_root), INDEX IDX_7FC45F1D727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filter_slot (filter_id INT NOT NULL, slot_id INT NOT NULL, INDEX IDX_C434471ED395B25E (filter_id), INDEX IDX_C434471E59E5119C (slot_id), PRIMARY KEY(filter_id, slot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_begin DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', date_end DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot_filter (slot_id INT NOT NULL, filter_id INT NOT NULL, INDEX IDX_77C7D71F59E5119C (slot_id), INDEX IDX_77C7D71FD395B25E (filter_id), PRIMARY KEY(slot_id, filter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filter ADD CONSTRAINT FK_7FC45F1DA977936C FOREIGN KEY (tree_root) REFERENCES filter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE filter ADD CONSTRAINT FK_7FC45F1D727ACA70 FOREIGN KEY (parent_id) REFERENCES filter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE filter_slot ADD CONSTRAINT FK_C434471ED395B25E FOREIGN KEY (filter_id) REFERENCES filter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE filter_slot ADD CONSTRAINT FK_C434471E59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_filter ADD CONSTRAINT FK_77C7D71F59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_filter ADD CONSTRAINT FK_77C7D71FD395B25E FOREIGN KEY (filter_id) REFERENCES filter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filter DROP FOREIGN KEY FK_7FC45F1DA977936C');
        $this->addSql('ALTER TABLE filter DROP FOREIGN KEY FK_7FC45F1D727ACA70');
        $this->addSql('ALTER TABLE filter_slot DROP FOREIGN KEY FK_C434471ED395B25E');
        $this->addSql('ALTER TABLE filter_slot DROP FOREIGN KEY FK_C434471E59E5119C');
        $this->addSql('ALTER TABLE slot_filter DROP FOREIGN KEY FK_77C7D71F59E5119C');
        $this->addSql('ALTER TABLE slot_filter DROP FOREIGN KEY FK_77C7D71FD395B25E');
        $this->addSql('DROP TABLE filter');
        $this->addSql('DROP TABLE filter_slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE slot_filter');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
