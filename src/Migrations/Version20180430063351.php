<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430063351 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_card CHANGE car_initial reporting_mark VARCHAR(6) NOT NULL');
        $this->addSql('ALTER TABLE waybill ADD number INT DEFAULT NULL, ADD stop_at2 VARCHAR(64) DEFAULT NULL, ADD instructions_exceptions VARCHAR(64) DEFAULT NULL, DROP length_capacity, CHANGE spot_location stop_at VARCHAR(64) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_card CHANGE reporting_mark car_initial VARCHAR(6) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE waybill ADD length_capacity VARCHAR(10) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD spot_location VARCHAR(64) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP number, DROP stop_at, DROP stop_at2, DROP instructions_exceptions');
    }
}
