<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250327101001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_breed DROP CONSTRAINT fk_d95c51bb8eb23357');
        $this->addSql('DROP INDEX idx_d95c51bb8eb23357');
        $this->addSql('ALTER TABLE animal_breed RENAME COLUMN types_id TO type_id');
        $this->addSql('ALTER TABLE animal_breed ADD CONSTRAINT FK_D95C51BBC54C8C93 FOREIGN KEY (type_id) REFERENCES "animal_type" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D95C51BBC54C8C93 ON animal_breed (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "animal_breed" DROP CONSTRAINT FK_D95C51BBC54C8C93');
        $this->addSql('DROP INDEX IDX_D95C51BBC54C8C93');
        $this->addSql('ALTER TABLE "animal_breed" RENAME COLUMN type_id TO types_id');
        $this->addSql('ALTER TABLE "animal_breed" ADD CONSTRAINT fk_d95c51bb8eb23357 FOREIGN KEY (types_id) REFERENCES animal_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d95c51bb8eb23357 ON "animal_breed" (types_id)');
    }
}
