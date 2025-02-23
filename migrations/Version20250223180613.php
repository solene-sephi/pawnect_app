<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223180613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "address" (id SERIAL NOT NULL, street TEXT NOT NULL, city VARCHAR(100) NOT NULL, state VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, zip_code VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_address_zip_code ON "address" (zip_code)');
        $this->addSql('CREATE INDEX idx_address_city ON "address" (city)');
        $this->addSql('COMMENT ON COLUMN "address".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "address".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "adoption_request" (id SERIAL NOT NULL, requester_id INT NOT NULL, animal_id INT NOT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, details TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_410896EEB03A8386 ON "adoption_request" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_410896EE896DBBDE ON "adoption_request" (updated_by_id)');
        $this->addSql('CREATE INDEX idx_animal_arrival_user ON "adoption_request" (requester_id)');
        $this->addSql('CREATE INDEX idx_animal_arrival_animal ON "adoption_request" (animal_id)');
        $this->addSql('COMMENT ON COLUMN "adoption_request".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "adoption_request".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "animal" (id SERIAL NOT NULL, breed_id INT NOT NULL, shelter_id INT NOT NULL, name VARCHAR(100) NOT NULL, date_of_birth DATE NOT NULL, identification_number VARCHAR(255) DEFAULT NULL, identification_type VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6AAB231FA8B4A30F ON "animal" (breed_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F54053EC0 ON "animal" (shelter_id)');
        $this->addSql('CREATE INDEX idx_animal_active ON "animal" (id) WHERE ((deleted_at IS NULL))');
        $this->addSql('CREATE INDEX idx_animal_identification_number ON "animal" (identification_number)');
        $this->addSql('COMMENT ON COLUMN "animal".date_of_birth IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "animal".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "animal".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "animal".deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "animal_adoption" (id SERIAL NOT NULL, animal_id INT NOT NULL, adoption_request_id INT DEFAULT NULL, created_by_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2B5DB0748E962C16 ON "animal_adoption" (animal_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2B5DB074ECFD9D75 ON "animal_adoption" (adoption_request_id)');
        $this->addSql('CREATE INDEX IDX_2B5DB074B03A8386 ON "animal_adoption" (created_by_id)');
        $this->addSql('CREATE INDEX idx_animal_adoption_created_at ON "animal_adoption" (created_at)');
        $this->addSql('COMMENT ON COLUMN "animal_adoption".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "animal_arrival" (id SERIAL NOT NULL, animal_id INT NOT NULL, shelter_id INT NOT NULL, created_by_id INT NOT NULL, reason TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D43A338E8E962C16 ON "animal_arrival" (animal_id)');
        $this->addSql('CREATE INDEX IDX_D43A338E54053EC0 ON "animal_arrival" (shelter_id)');
        $this->addSql('CREATE INDEX IDX_D43A338EB03A8386 ON "animal_arrival" (created_by_id)');
        $this->addSql('CREATE INDEX idx_animal_arrival_created_at ON "animal_arrival" (created_at)');
        $this->addSql('COMMENT ON COLUMN "animal_arrival".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "animal_breed" (id SERIAL NOT NULL, types_id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D95C51BB8EB23357 ON "animal_breed" (types_id)');
        $this->addSql('CREATE TABLE animal_detail (id SERIAL NOT NULL, animal_id INT NOT NULL, needs_visit_before_adoption BOOLEAN DEFAULT NULL, can_live_with_dogs BOOLEAN DEFAULT NULL, can_live_with_cats BOOLEAN DEFAULT NULL, compatibility_notes TEXT DEFAULT NULL, behavior_notes TEXT DEFAULT NULL, is_sterilized BOOLEAN DEFAULT NULL, weight NUMERIC(8, 3) DEFAULT NULL, height NUMERIC(8, 3) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_94F7BA4F8E962C16 ON animal_detail (animal_id)');
        $this->addSql('CREATE INDEX idx_animal_detail_animal ON animal_detail (animal_id)');
        $this->addSql('CREATE TABLE "animal_event_history" (id SERIAL NOT NULL, animal_id INT NOT NULL, event_type VARCHAR(255) NOT NULL, event_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8830E8C18E962C16 ON "animal_event_history" (animal_id)');
        $this->addSql('CREATE INDEX idx_animal_event_history_created_at ON "animal_event_history" (created_at)');
        $this->addSql('COMMENT ON COLUMN "animal_event_history".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "animal_foster_placement" (id SERIAL NOT NULL, animal_id INT NOT NULL, foster_family_id INT NOT NULL, foster_offer_id INT NOT NULL, created_by_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, comment TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C55C8718E962C16 ON "animal_foster_placement" (animal_id)');
        $this->addSql('CREATE INDEX IDX_8C55C871769C6EF ON "animal_foster_placement" (foster_family_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C55C87151C4917 ON "animal_foster_placement" (foster_offer_id)');
        $this->addSql('CREATE INDEX IDX_8C55C871B03A8386 ON "animal_foster_placement" (created_by_id)');
        $this->addSql('CREATE INDEX idx_animal_foster_placement_created_at ON "animal_foster_placement" (created_at)');
        $this->addSql('COMMENT ON COLUMN "animal_foster_placement".start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "animal_foster_placement".end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "animal_foster_placement".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "animal_image" (id SERIAL NOT NULL, animal_id INT NOT NULL, filepath TEXT NOT NULL, filename VARCHAR(255) NOT NULL, image_order INT NOT NULL, is_main_picture BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_animal_image_animal ON "animal_image" (animal_id)');
        $this->addSql('CREATE TABLE "animal_return" (id SERIAL NOT NULL, animal_id INT NOT NULL, related_event_id INT NOT NULL, created_by_id INT NOT NULL, return_date DATE NOT NULL, details TEXT NOT NULL, returned_from VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1D6FFAD38E962C16 ON "animal_return" (animal_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D6FFAD3D774A626 ON "animal_return" (related_event_id)');
        $this->addSql('CREATE INDEX IDX_1D6FFAD3B03A8386 ON "animal_return" (created_by_id)');
        $this->addSql('CREATE INDEX idx_animal_return_created_at ON "animal_return" (created_at)');
        $this->addSql('COMMENT ON COLUMN "animal_return".return_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "animal_return".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "animal_type" (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "document" (id SERIAL NOT NULL, shelter_approval_id INT DEFAULT NULL, created_by_id INT NOT NULL, filename VARCHAR(255) NOT NULL, filepath TEXT NOT NULL, document_type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8698A766DD97EB4 ON "document" (shelter_approval_id)');
        $this->addSql('CREATE INDEX idx_document_created_by ON "document" (created_by_id)');
        $this->addSql('CREATE INDEX idx_document_document_type ON "document" (document_type)');
        $this->addSql('CREATE INDEX idx_document__created_at ON "document" (created_at)');
        $this->addSql('COMMENT ON COLUMN "document".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "foster_animal_offer" (id SERIAL NOT NULL, shelter_id INT NOT NULL, foster_family_id INT NOT NULL, animal_id INT NOT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, responded_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, comment TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2627A870B03A8386 ON "foster_animal_offer" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_2627A870896DBBDE ON "foster_animal_offer" (updated_by_id)');
        $this->addSql('CREATE INDEX idx_foster_animal_offer_shelter ON "foster_animal_offer" (shelter_id)');
        $this->addSql('CREATE INDEX idx_foster_animal_offer_foster_family ON "foster_animal_offer" (foster_family_id)');
        $this->addSql('CREATE INDEX idx_foster_animal_offer_animal ON "foster_animal_offer" (animal_id)');
        $this->addSql('CREATE INDEX idx_foster_animal_offer_created_at ON "foster_animal_offer" (created_at)');
        $this->addSql('COMMENT ON COLUMN "foster_animal_offer".responded_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "foster_animal_offer".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "foster_animal_offer".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "foster_animal_offer".deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "foster_family" (id SERIAL NOT NULL, foster_user_id INT NOT NULL, has_children BOOLEAN NOT NULL, has_other_pets BOOLEAN NOT NULL, details TEXT NOT NULL, capacity INT NOT NULL, is_available BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5AFEEAC8CE9709A0 ON "foster_family" (foster_user_id)');
        $this->addSql('CREATE INDEX idx_foster_families_user_id ON "foster_family" (foster_user_id)');
        $this->addSql('CREATE TABLE foster_registry (id SERIAL NOT NULL, comment TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE foster_registry_shelter (foster_registry_id INT NOT NULL, shelter_id INT NOT NULL, PRIMARY KEY(foster_registry_id, shelter_id))');
        $this->addSql('CREATE INDEX IDX_5B3D1684FA4C3C90 ON foster_registry_shelter (foster_registry_id)');
        $this->addSql('CREATE INDEX IDX_5B3D168454053EC0 ON foster_registry_shelter (shelter_id)');
        $this->addSql('CREATE TABLE foster_registry_foster_family (foster_registry_id INT NOT NULL, foster_family_id INT NOT NULL, PRIMARY KEY(foster_registry_id, foster_family_id))');
        $this->addSql('CREATE INDEX IDX_61EAF114FA4C3C90 ON foster_registry_foster_family (foster_registry_id)');
        $this->addSql('CREATE INDEX IDX_61EAF114769C6EF ON foster_registry_foster_family (foster_family_id)');
        $this->addSql('CREATE TABLE "shelter" (id SERIAL NOT NULL, address_id INT NOT NULL, name VARCHAR(100) NOT NULL, phone_number1 VARCHAR(20) NOT NULL, phone_number2 VARCHAR(20) DEFAULT NULL, email VARCHAR(180) NOT NULL, opening_hours VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_71106707F5B7AF75 ON "shelter" (address_id)');
        $this->addSql('CREATE INDEX idx_shelter_active ON "shelter" (id) WHERE ((deleted_at IS NULL))');
        $this->addSql('COMMENT ON COLUMN "shelter".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "shelter".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "shelter".deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "shelter_approval" (id SERIAL NOT NULL, shelter_id INT NOT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, comment TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_21CF568A54053EC0 ON "shelter_approval" (shelter_id)');
        $this->addSql('CREATE INDEX IDX_21CF568AB03A8386 ON "shelter_approval" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_21CF568A896DBBDE ON "shelter_approval" (updated_by_id)');
        $this->addSql('CREATE INDEX idx_shelter_approvals_shelter_id ON "shelter_approval" (id)');
        $this->addSql('COMMENT ON COLUMN "shelter_approval".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "shelter_approval".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "shelter_employee" (id SERIAL NOT NULL, shelter_id INT NOT NULL, employee_user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6AB0B60054053EC0 ON "shelter_employee" (shelter_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AB0B6002722859A ON "shelter_employee" (employee_user_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F5B7AF75 ON "user" (address_id)');
        $this->addSql('CREATE INDEX idx_user_active ON "user" (id) WHERE ((deleted_at IS NULL))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".last_login IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "adoption_request" ADD CONSTRAINT FK_410896EEED442CF4 FOREIGN KEY (requester_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "adoption_request" ADD CONSTRAINT FK_410896EE8E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "adoption_request" ADD CONSTRAINT FK_410896EEB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "adoption_request" ADD CONSTRAINT FK_410896EE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal" ADD CONSTRAINT FK_6AAB231FA8B4A30F FOREIGN KEY (breed_id) REFERENCES "animal_breed" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal" ADD CONSTRAINT FK_6AAB231F54053EC0 FOREIGN KEY (shelter_id) REFERENCES "shelter" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_adoption" ADD CONSTRAINT FK_2B5DB0748E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_adoption" ADD CONSTRAINT FK_2B5DB074ECFD9D75 FOREIGN KEY (adoption_request_id) REFERENCES "adoption_request" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_adoption" ADD CONSTRAINT FK_2B5DB074B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_arrival" ADD CONSTRAINT FK_D43A338E8E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_arrival" ADD CONSTRAINT FK_D43A338E54053EC0 FOREIGN KEY (shelter_id) REFERENCES "shelter" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_arrival" ADD CONSTRAINT FK_D43A338EB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_breed" ADD CONSTRAINT FK_D95C51BB8EB23357 FOREIGN KEY (types_id) REFERENCES "animal_type" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE animal_detail ADD CONSTRAINT FK_94F7BA4F8E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_event_history" ADD CONSTRAINT FK_8830E8C18E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_foster_placement" ADD CONSTRAINT FK_8C55C8718E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_foster_placement" ADD CONSTRAINT FK_8C55C871769C6EF FOREIGN KEY (foster_family_id) REFERENCES "foster_family" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_foster_placement" ADD CONSTRAINT FK_8C55C87151C4917 FOREIGN KEY (foster_offer_id) REFERENCES "foster_animal_offer" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_foster_placement" ADD CONSTRAINT FK_8C55C871B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_image" ADD CONSTRAINT FK_E4CEDDAB8E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_return" ADD CONSTRAINT FK_1D6FFAD38E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_return" ADD CONSTRAINT FK_1D6FFAD3D774A626 FOREIGN KEY (related_event_id) REFERENCES "animal_event_history" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "animal_return" ADD CONSTRAINT FK_1D6FFAD3B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "document" ADD CONSTRAINT FK_D8698A766DD97EB4 FOREIGN KEY (shelter_approval_id) REFERENCES "shelter_approval" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "document" ADD CONSTRAINT FK_D8698A76B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "foster_animal_offer" ADD CONSTRAINT FK_2627A87054053EC0 FOREIGN KEY (shelter_id) REFERENCES "shelter" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "foster_animal_offer" ADD CONSTRAINT FK_2627A870769C6EF FOREIGN KEY (foster_family_id) REFERENCES "foster_family" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "foster_animal_offer" ADD CONSTRAINT FK_2627A8708E962C16 FOREIGN KEY (animal_id) REFERENCES "animal" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "foster_animal_offer" ADD CONSTRAINT FK_2627A870B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "foster_animal_offer" ADD CONSTRAINT FK_2627A870896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "foster_family" ADD CONSTRAINT FK_5AFEEAC8CE9709A0 FOREIGN KEY (foster_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE foster_registry_shelter ADD CONSTRAINT FK_5B3D1684FA4C3C90 FOREIGN KEY (foster_registry_id) REFERENCES foster_registry (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE foster_registry_shelter ADD CONSTRAINT FK_5B3D168454053EC0 FOREIGN KEY (shelter_id) REFERENCES "shelter" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE foster_registry_foster_family ADD CONSTRAINT FK_61EAF114FA4C3C90 FOREIGN KEY (foster_registry_id) REFERENCES foster_registry (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE foster_registry_foster_family ADD CONSTRAINT FK_61EAF114769C6EF FOREIGN KEY (foster_family_id) REFERENCES "foster_family" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "shelter" ADD CONSTRAINT FK_71106707F5B7AF75 FOREIGN KEY (address_id) REFERENCES "address" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "shelter_approval" ADD CONSTRAINT FK_21CF568A54053EC0 FOREIGN KEY (shelter_id) REFERENCES "shelter" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "shelter_approval" ADD CONSTRAINT FK_21CF568AB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "shelter_approval" ADD CONSTRAINT FK_21CF568A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "shelter_employee" ADD CONSTRAINT FK_6AB0B60054053EC0 FOREIGN KEY (shelter_id) REFERENCES "shelter" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "shelter_employee" ADD CONSTRAINT FK_6AB0B6002722859A FOREIGN KEY (employee_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES "address" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "adoption_request" DROP CONSTRAINT FK_410896EEED442CF4');
        $this->addSql('ALTER TABLE "adoption_request" DROP CONSTRAINT FK_410896EE8E962C16');
        $this->addSql('ALTER TABLE "adoption_request" DROP CONSTRAINT FK_410896EEB03A8386');
        $this->addSql('ALTER TABLE "adoption_request" DROP CONSTRAINT FK_410896EE896DBBDE');
        $this->addSql('ALTER TABLE "animal" DROP CONSTRAINT FK_6AAB231FA8B4A30F');
        $this->addSql('ALTER TABLE "animal" DROP CONSTRAINT FK_6AAB231F54053EC0');
        $this->addSql('ALTER TABLE "animal_adoption" DROP CONSTRAINT FK_2B5DB0748E962C16');
        $this->addSql('ALTER TABLE "animal_adoption" DROP CONSTRAINT FK_2B5DB074ECFD9D75');
        $this->addSql('ALTER TABLE "animal_adoption" DROP CONSTRAINT FK_2B5DB074B03A8386');
        $this->addSql('ALTER TABLE "animal_arrival" DROP CONSTRAINT FK_D43A338E8E962C16');
        $this->addSql('ALTER TABLE "animal_arrival" DROP CONSTRAINT FK_D43A338E54053EC0');
        $this->addSql('ALTER TABLE "animal_arrival" DROP CONSTRAINT FK_D43A338EB03A8386');
        $this->addSql('ALTER TABLE "animal_breed" DROP CONSTRAINT FK_D95C51BB8EB23357');
        $this->addSql('ALTER TABLE animal_detail DROP CONSTRAINT FK_94F7BA4F8E962C16');
        $this->addSql('ALTER TABLE "animal_event_history" DROP CONSTRAINT FK_8830E8C18E962C16');
        $this->addSql('ALTER TABLE "animal_foster_placement" DROP CONSTRAINT FK_8C55C8718E962C16');
        $this->addSql('ALTER TABLE "animal_foster_placement" DROP CONSTRAINT FK_8C55C871769C6EF');
        $this->addSql('ALTER TABLE "animal_foster_placement" DROP CONSTRAINT FK_8C55C87151C4917');
        $this->addSql('ALTER TABLE "animal_foster_placement" DROP CONSTRAINT FK_8C55C871B03A8386');
        $this->addSql('ALTER TABLE "animal_image" DROP CONSTRAINT FK_E4CEDDAB8E962C16');
        $this->addSql('ALTER TABLE "animal_return" DROP CONSTRAINT FK_1D6FFAD38E962C16');
        $this->addSql('ALTER TABLE "animal_return" DROP CONSTRAINT FK_1D6FFAD3D774A626');
        $this->addSql('ALTER TABLE "animal_return" DROP CONSTRAINT FK_1D6FFAD3B03A8386');
        $this->addSql('ALTER TABLE "document" DROP CONSTRAINT FK_D8698A766DD97EB4');
        $this->addSql('ALTER TABLE "document" DROP CONSTRAINT FK_D8698A76B03A8386');
        $this->addSql('ALTER TABLE "foster_animal_offer" DROP CONSTRAINT FK_2627A87054053EC0');
        $this->addSql('ALTER TABLE "foster_animal_offer" DROP CONSTRAINT FK_2627A870769C6EF');
        $this->addSql('ALTER TABLE "foster_animal_offer" DROP CONSTRAINT FK_2627A8708E962C16');
        $this->addSql('ALTER TABLE "foster_animal_offer" DROP CONSTRAINT FK_2627A870B03A8386');
        $this->addSql('ALTER TABLE "foster_animal_offer" DROP CONSTRAINT FK_2627A870896DBBDE');
        $this->addSql('ALTER TABLE "foster_family" DROP CONSTRAINT FK_5AFEEAC8CE9709A0');
        $this->addSql('ALTER TABLE foster_registry_shelter DROP CONSTRAINT FK_5B3D1684FA4C3C90');
        $this->addSql('ALTER TABLE foster_registry_shelter DROP CONSTRAINT FK_5B3D168454053EC0');
        $this->addSql('ALTER TABLE foster_registry_foster_family DROP CONSTRAINT FK_61EAF114FA4C3C90');
        $this->addSql('ALTER TABLE foster_registry_foster_family DROP CONSTRAINT FK_61EAF114769C6EF');
        $this->addSql('ALTER TABLE "shelter" DROP CONSTRAINT FK_71106707F5B7AF75');
        $this->addSql('ALTER TABLE "shelter_approval" DROP CONSTRAINT FK_21CF568A54053EC0');
        $this->addSql('ALTER TABLE "shelter_approval" DROP CONSTRAINT FK_21CF568AB03A8386');
        $this->addSql('ALTER TABLE "shelter_approval" DROP CONSTRAINT FK_21CF568A896DBBDE');
        $this->addSql('ALTER TABLE "shelter_employee" DROP CONSTRAINT FK_6AB0B60054053EC0');
        $this->addSql('ALTER TABLE "shelter_employee" DROP CONSTRAINT FK_6AB0B6002722859A');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F5B7AF75');
        $this->addSql('DROP TABLE "address"');
        $this->addSql('DROP TABLE "adoption_request"');
        $this->addSql('DROP TABLE "animal"');
        $this->addSql('DROP TABLE "animal_adoption"');
        $this->addSql('DROP TABLE "animal_arrival"');
        $this->addSql('DROP TABLE "animal_breed"');
        $this->addSql('DROP TABLE animal_detail');
        $this->addSql('DROP TABLE "animal_event_history"');
        $this->addSql('DROP TABLE "animal_foster_placement"');
        $this->addSql('DROP TABLE "animal_image"');
        $this->addSql('DROP TABLE "animal_return"');
        $this->addSql('DROP TABLE "animal_type"');
        $this->addSql('DROP TABLE "document"');
        $this->addSql('DROP TABLE "foster_animal_offer"');
        $this->addSql('DROP TABLE "foster_family"');
        $this->addSql('DROP TABLE foster_registry');
        $this->addSql('DROP TABLE foster_registry_shelter');
        $this->addSql('DROP TABLE foster_registry_foster_family');
        $this->addSql('DROP TABLE "shelter"');
        $this->addSql('DROP TABLE "shelter_approval"');
        $this->addSql('DROP TABLE "shelter_employee"');
        $this->addSql('DROP TABLE "user"');
    }
}
