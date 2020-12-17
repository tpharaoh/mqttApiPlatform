<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217211452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trigger ADD notification_method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trigger ADD CONSTRAINT FK_1A6B0F5DBF617E38 FOREIGN KEY (notification_method_id) REFERENCES notification_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1A6B0F5DBF617E38 ON trigger (notification_method_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trigger DROP CONSTRAINT FK_1A6B0F5DBF617E38');
        $this->addSql('DROP INDEX UNIQ_1A6B0F5DBF617E38');
        $this->addSql('ALTER TABLE trigger DROP notification_method_id');
    }
}
