<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223181833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_animal_active');
        $this->addSql('CREATE INDEX idx_animal_active ON animal (id) WHERE ((deleted_at IS NULL))');
        $this->addSql('ALTER TABLE document ADD adoption_request_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76ECFD9D75 FOREIGN KEY (adoption_request_id) REFERENCES "adoption_request" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D8698A76ECFD9D75 ON document (adoption_request_id)');
        $this->addSql('DROP INDEX idx_shelter_active');
        $this->addSql('CREATE INDEX idx_shelter_active ON shelter (id) WHERE ((deleted_at IS NULL))');
        $this->addSql('DROP INDEX idx_user_active');
        $this->addSql('CREATE INDEX idx_user_active ON "user" (id) WHERE ((deleted_at IS NULL))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX idx_user_active');
        $this->addSql('CREATE INDEX idx_user_active ON "user" (id) WHERE (deleted_at IS NULL)');
        $this->addSql('ALTER TABLE "document" DROP CONSTRAINT FK_D8698A76ECFD9D75');
        $this->addSql('DROP INDEX IDX_D8698A76ECFD9D75');
        $this->addSql('ALTER TABLE "document" DROP adoption_request_id');
        $this->addSql('DROP INDEX idx_animal_active');
        $this->addSql('CREATE INDEX idx_animal_active ON "animal" (id) WHERE (deleted_at IS NULL)');
        $this->addSql('DROP INDEX idx_shelter_active');
        $this->addSql('CREATE INDEX idx_shelter_active ON "shelter" (id) WHERE (deleted_at IS NULL)');
    }
}
