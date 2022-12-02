<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115074602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders CHANGE shoppingcart shoppingcart VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE shoppingcart_pizza CHANGE shoppingcart_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE shoppingcart_pizza ADD CONSTRAINT FK_C8CF76A9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C8CF76A9A76ED395 ON shoppingcart_pizza (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders CHANGE shoppingcart shoppingcart TEXT NOT NULL');
        $this->addSql('ALTER TABLE shoppingcart_pizza DROP FOREIGN KEY FK_C8CF76A9A76ED395');
        $this->addSql('DROP INDEX IDX_C8CF76A9A76ED395 ON shoppingcart_pizza');
        $this->addSql('ALTER TABLE shoppingcart_pizza CHANGE user_id shoppingcart_id INT NOT NULL');
    }
}
