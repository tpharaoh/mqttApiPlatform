<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215215850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trigger ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trigger ADD CONSTRAINT FK_1A6B0F5D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1A6B0F5D7E3C61F9 ON trigger (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trigger DROP CONSTRAINT FK_1A6B0F5D7E3C61F9');
        $this->addSql('DROP INDEX IDX_1A6B0F5D7E3C61F9');
        $this->addSql('ALTER TABLE trigger DROP owner_id');
    }
}
