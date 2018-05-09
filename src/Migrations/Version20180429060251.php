<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180429060251 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car_card (id INT AUTO_INCREMENT NOT NULL, car_initial VARCHAR(6) NOT NULL, car_number VARCHAR(10) NOT NULL, aar_type VARCHAR(6) NOT NULL, length_capacity VARCHAR(10) DEFAULT NULL, description VARCHAR(64) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE waybill (id INT AUTO_INCREMENT NOT NULL, from_address VARCHAR(64) DEFAULT NULL, to_address VARCHAR(64) DEFAULT NULL, shipper VARCHAR(64) DEFAULT NULL, consignee VARCHAR(64) DEFAULT NULL, aar_class VARCHAR(3) DEFAULT NULL, length_capacity VARCHAR(10) DEFAULT NULL, route_via VARCHAR(64) DEFAULT NULL, spot_location VARCHAR(64) DEFAULT NULL, lading_quantity VARCHAR(10) DEFAULT NULL, lading_description VARCHAR(64) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legacy_industry (id INT AUTO_INCREMENT NOT NULL, era VARCHAR(10) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(10) DEFAULT NULL, reporting_marks VARCHAR(255) DEFAULT NULL, ship_receive VARCHAR(10) DEFAULT NULL, commodity VARCHAR(255) DEFAULT NULL, stcc VARCHAR(255) DEFAULT NULL, reciprocal VARCHAR(255) DEFAULT NULL, source VARCHAR(255) DEFAULT NULL, external_source VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE car_card');
        $this->addSql('DROP TABLE waybill');
        $this->addSql('DROP TABLE legacy_industry');
        $this->addSql('DROP TABLE user');
    }
}
