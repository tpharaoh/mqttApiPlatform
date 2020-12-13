<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213171631 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trigger ADD device_id UUID NOT NULL');
        $this->addSql('ALTER TABLE trigger DROP device');
        $this->addSql('COMMENT ON COLUMN trigger.device_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE trigger ADD CONSTRAINT FK_1A6B0F5D94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1A6B0F5D94A4C7D4 ON trigger (device_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trigger DROP CONSTRAINT FK_1A6B0F5D94A4C7D4');
        $this->addSql('DROP INDEX IDX_1A6B0F5D94A4C7D4');
        $this->addSql('ALTER TABLE trigger ADD device VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE trigger DROP device_id');
    }
}
