<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180517081640 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE full_empty_car_bill DROP FOREIGN KEY FK_FB8BE262AB76E9D');
        $this->addSql('DROP INDEX IDX_FB8BE262AB76E9D ON full_empty_car_bill');
        $this->addSql('ALTER TABLE full_empty_car_bill CHANGE empty_card_bill_id empty_car_bill_id INT NOT NULL');
        $this->addSql('ALTER TABLE full_empty_car_bill ADD CONSTRAINT FK_FB8BE262DA1E88C7 FOREIGN KEY (empty_car_bill_id) REFERENCES empty_car_bill (id)');
        $this->addSql('CREATE INDEX IDX_FB8BE262DA1E88C7 ON full_empty_car_bill (empty_car_bill_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE full_empty_car_bill DROP FOREIGN KEY FK_FB8BE262DA1E88C7');
        $this->addSql('DROP INDEX IDX_FB8BE262DA1E88C7 ON full_empty_car_bill');
        $this->addSql('ALTER TABLE full_empty_car_bill CHANGE empty_car_bill_id empty_card_bill_id INT NOT NULL');
        $this->addSql('ALTER TABLE full_empty_car_bill ADD CONSTRAINT FK_FB8BE262AB76E9D FOREIGN KEY (empty_card_bill_id) REFERENCES empty_car_bill (id)');
        $this->addSql('CREATE INDEX IDX_FB8BE262AB76E9D ON full_empty_car_bill (empty_card_bill_id)');
    }
}
