<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213163401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE owner_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trigger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE device (id UUID NOT NULL, owner_id INT NOT NULL, name VARCHAR(50) NOT NULL, device_type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92FB68E7E3C61F9 ON device (owner_id)');
        $this->addSql('COMMENT ON COLUMN device.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE owner (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CE7927C74 ON owner (email)');
        $this->addSql('CREATE TABLE telemetry (id UUID NOT NULL, owner_id INT DEFAULT NULL, device_id UUID NOT NULL, received_data JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CD10367D7E3C61F9 ON telemetry (owner_id)');
        $this->addSql('CREATE INDEX IDX_CD10367D94A4C7D4 ON telemetry (device_id)');
        $this->addSql('COMMENT ON COLUMN telemetry.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN telemetry.device_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE trigger (id INT NOT NULL, device VARCHAR(20) NOT NULL, telemetry_key VARCHAR(20) NOT NULL, high_value INT NOT NULL, low_value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('BEGIN;');
        $this->addSql('LOCK TABLE messenger_messages;');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('COMMIT;');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE telemetry ADD CONSTRAINT FK_CD10367D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE telemetry ADD CONSTRAINT FK_CD10367D94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE telemetry DROP CONSTRAINT FK_CD10367D94A4C7D4');
        $this->addSql('ALTER TABLE device DROP CONSTRAINT FK_92FB68E7E3C61F9');
        $this->addSql('ALTER TABLE telemetry DROP CONSTRAINT FK_CD10367D7E3C61F9');
        $this->addSql('DROP SEQUENCE owner_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE trigger_id_seq CASCADE');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE telemetry');
        $this->addSql('DROP TABLE trigger');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
