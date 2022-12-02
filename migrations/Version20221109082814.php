<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221109082814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shoppingcart_pizza DROP FOREIGN KEY FK_C8CF76A978566A91');
        $this->addSql('DROP INDEX UNIQ_C8CF76A978566A91 ON shoppingcart_pizza');
        $this->addSql('ALTER TABLE shoppingcart_pizza CHANGE shoppingcart_id_id shoppingcart_id INT NOT NULL');
        $this->addSql('ALTER TABLE shoppingcart_pizza ADD CONSTRAINT FK_C8CF76A9685930AE FOREIGN KEY (shoppingcart_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8CF76A9685930AE ON shoppingcart_pizza (shoppingcart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shoppingcart_pizza DROP FOREIGN KEY FK_C8CF76A9685930AE');
        $this->addSql('DROP INDEX UNIQ_C8CF76A9685930AE ON shoppingcart_pizza');
        $this->addSql('ALTER TABLE shoppingcart_pizza CHANGE shoppingcart_id shoppingcart_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE shoppingcart_pizza ADD CONSTRAINT FK_C8CF76A978566A91 FOREIGN KEY (shoppingcart_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8CF76A978566A91 ON shoppingcart_pizza (shoppingcart_id_id)');
    }
}
