<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180517032852 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM car_card_and_waybill');
        $this->addSql('DELETE FROM waybill');
        $this->addSql('DELETE FROM car_card');

        $this->addSql('CREATE TABLE aar_code (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(4) NOT NULL, class VARCHAR(1) NOT NULL, common_name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_81398E0964D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE full_waybill (id INT AUTO_INCREMENT NOT NULL, car_card_id INT NOT NULL, waybill_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8B85F009196761FC (car_card_id), INDEX IDX_8B85F00988F82440 (waybill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, station_number VARCHAR(6) DEFAULT NULL, station_name VARCHAR(64) NOT NULL, state VARCHAR(3) NOT NULL, on_layout TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE railroad (id INT AUTO_INCREMENT NOT NULL, reporting_mark VARCHAR(5) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E0964D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE full_waybill ADD CONSTRAINT FK_8B85F009196761FC FOREIGN KEY (car_card_id) REFERENCES car_card (id)');
        $this->addSql('ALTER TABLE full_waybill ADD CONSTRAINT FK_8B85F00988F82440 FOREIGN KEY (waybill_id) REFERENCES waybill (id)');
        $this->addSql('DROP TABLE car_card_and_waybill');
        $this->addSql('ALTER TABLE car_card ADD aar_code_id INT NOT NULL, ADD railroad_id INT NOT NULL, DROP reporting_mark, DROP aar_type');
        $this->addSql('ALTER TABLE car_card ADD CONSTRAINT FK_DD7E8C7F2C1DBC0A FOREIGN KEY (aar_code_id) REFERENCES aar_code (id)');
        $this->addSql('ALTER TABLE car_card ADD CONSTRAINT FK_DD7E8C7F8F2BE99D FOREIGN KEY (railroad_id) REFERENCES railroad (id)');
        $this->addSql('CREATE INDEX IDX_DD7E8C7F2C1DBC0A ON car_card (aar_code_id)');
        $this->addSql('CREATE INDEX IDX_DD7E8C7F8F2BE99D ON car_card (railroad_id)');
        $this->addSql('ALTER TABLE waybill ADD aar_code_id INT NOT NULL, ADD consignee_id INT DEFAULT NULL, DROP from_address, DROP to_address, DROP shipper, DROP consignee, DROP aar_class, CHANGE number shipper_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE waybill ADD CONSTRAINT FK_D8ACA9652C1DBC0A FOREIGN KEY (aar_code_id) REFERENCES aar_code (id)');
        $this->addSql('ALTER TABLE waybill ADD CONSTRAINT FK_D8ACA96538459F23 FOREIGN KEY (shipper_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE waybill ADD CONSTRAINT FK_D8ACA96596549545 FOREIGN KEY (consignee_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_D8ACA9652C1DBC0A ON waybill (aar_code_id)');
        $this->addSql('CREATE INDEX IDX_D8ACA96538459F23 ON waybill (shipper_id)');
        $this->addSql('CREATE INDEX IDX_D8ACA96596549545 ON waybill (consignee_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_card DROP FOREIGN KEY FK_DD7E8C7F2C1DBC0A');
        $this->addSql('ALTER TABLE waybill DROP FOREIGN KEY FK_D8ACA9652C1DBC0A');
        $this->addSql('ALTER TABLE waybill DROP FOREIGN KEY FK_D8ACA96538459F23');
        $this->addSql('ALTER TABLE waybill DROP FOREIGN KEY FK_D8ACA96596549545');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E0964D218E');
        $this->addSql('ALTER TABLE car_card DROP FOREIGN KEY FK_DD7E8C7F8F2BE99D');
        $this->addSql('CREATE TABLE car_card_and_waybill (id INT AUTO_INCREMENT NOT NULL, car_card_id INT NOT NULL, waybill_id INT NOT NULL, INDEX IDX_85EA9368196761FC (car_card_id), INDEX IDX_85EA936888F82440 (waybill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_card_and_waybill ADD CONSTRAINT FK_85EA9368196761FC FOREIGN KEY (car_card_id) REFERENCES car_card (id)');
        $this->addSql('ALTER TABLE car_card_and_waybill ADD CONSTRAINT FK_85EA936888F82440 FOREIGN KEY (waybill_id) REFERENCES waybill (id)');
        $this->addSql('DROP TABLE aar_code');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE full_waybill');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE railroad');
        $this->addSql('DROP INDEX IDX_DD7E8C7F2C1DBC0A ON car_card');
        $this->addSql('DROP INDEX IDX_DD7E8C7F8F2BE99D ON car_card');
        $this->addSql('ALTER TABLE car_card ADD reporting_mark VARCHAR(6) NOT NULL COLLATE utf8mb4_unicode_ci, ADD aar_type VARCHAR(6) NOT NULL COLLATE utf8mb4_unicode_ci, DROP aar_code_id, DROP railroad_id');
        $this->addSql('DROP INDEX IDX_D8ACA9652C1DBC0A ON waybill');
        $this->addSql('DROP INDEX IDX_D8ACA96538459F23 ON waybill');
        $this->addSql('DROP INDEX IDX_D8ACA96596549545 ON waybill');
        $this->addSql('ALTER TABLE waybill ADD from_address VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD to_address VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD shipper VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD consignee VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD aar_class VARCHAR(3) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD number INT DEFAULT NULL, DROP aar_code_id, DROP shipper_id, DROP consignee_id');
    }
}
