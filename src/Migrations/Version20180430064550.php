<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430064550 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car_card_and_waybill (id INT AUTO_INCREMENT NOT NULL, car_card_id INT NOT NULL, waybill_id INT NOT NULL, INDEX IDX_85EA9368196761FC (car_card_id), INDEX IDX_85EA936888F82440 (waybill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_card_and_waybill ADD CONSTRAINT FK_85EA9368196761FC FOREIGN KEY (car_card_id) REFERENCES car_card (id)');
        $this->addSql('ALTER TABLE car_card_and_waybill ADD CONSTRAINT FK_85EA936888F82440 FOREIGN KEY (waybill_id) REFERENCES waybill (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE car_card_and_waybill');
    }
}
