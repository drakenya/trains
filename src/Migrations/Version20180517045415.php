<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180517045415 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM full_empty_card_bill');

        $this->addSql('CREATE TABLE full_empty_car_bill (id INT AUTO_INCREMENT NOT NULL, car_card_id INT NOT NULL, empty_card_bill_id INT NOT NULL, INDEX IDX_FB8BE262196761FC (car_card_id), INDEX IDX_FB8BE262AB76E9D (empty_card_bill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE full_empty_car_bill ADD CONSTRAINT FK_FB8BE262196761FC FOREIGN KEY (car_card_id) REFERENCES car_card (id)');
        $this->addSql('ALTER TABLE full_empty_car_bill ADD CONSTRAINT FK_FB8BE262AB76E9D FOREIGN KEY (empty_card_bill_id) REFERENCES empty_car_bill (id)');
        $this->addSql('DROP TABLE full_empty_card_bill');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE full_empty_card_bill (id INT AUTO_INCREMENT NOT NULL, car_card_id INT NOT NULL, empty_card_bill_id INT NOT NULL, INDEX IDX_D38787DB196761FC (car_card_id), INDEX IDX_D38787DBAB76E9D (empty_card_bill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE full_empty_card_bill ADD CONSTRAINT FK_D38787DB196761FC FOREIGN KEY (car_card_id) REFERENCES car_card (id)');
        $this->addSql('ALTER TABLE full_empty_card_bill ADD CONSTRAINT FK_D38787DBAB76E9D FOREIGN KEY (empty_card_bill_id) REFERENCES empty_car_bill (id)');
        $this->addSql('DROP TABLE full_empty_car_bill');
    }
}
