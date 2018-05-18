<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180517040550 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE empty_car_bill (id INT AUTO_INCREMENT NOT NULL, home_billed_from_id INT DEFAULT NULL, loading_billed_from_id INT DEFAULT NULL, loading_to_id INT DEFAULT NULL, loading_shipper_id INT DEFAULT NULL, home_to_or_via VARCHAR(64) DEFAULT NULL, loading_spot VARCHAR(10) DEFAULT NULL, INDEX IDX_897570F59D65E70B (home_billed_from_id), INDEX IDX_897570F517A765D9 (loading_billed_from_id), INDEX IDX_897570F5F8D2CBEB (loading_to_id), INDEX IDX_897570F5CCF8DBED (loading_shipper_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE full_empty_card_bill (id INT AUTO_INCREMENT NOT NULL, car_card_id INT NOT NULL, empty_card_bill_id INT NOT NULL, INDEX IDX_D38787DB196761FC (car_card_id), INDEX IDX_D38787DBAB76E9D (empty_card_bill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE empty_car_bill ADD CONSTRAINT FK_897570F59D65E70B FOREIGN KEY (home_billed_from_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE empty_car_bill ADD CONSTRAINT FK_897570F517A765D9 FOREIGN KEY (loading_billed_from_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE empty_car_bill ADD CONSTRAINT FK_897570F5F8D2CBEB FOREIGN KEY (loading_to_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE empty_car_bill ADD CONSTRAINT FK_897570F5CCF8DBED FOREIGN KEY (loading_shipper_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE full_empty_card_bill ADD CONSTRAINT FK_D38787DB196761FC FOREIGN KEY (car_card_id) REFERENCES car_card (id)');
        $this->addSql('ALTER TABLE full_empty_card_bill ADD CONSTRAINT FK_D38787DBAB76E9D FOREIGN KEY (empty_card_bill_id) REFERENCES empty_car_bill (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE full_empty_card_bill DROP FOREIGN KEY FK_D38787DBAB76E9D');
        $this->addSql('DROP TABLE empty_car_bill');
        $this->addSql('DROP TABLE full_empty_card_bill');
    }
}
