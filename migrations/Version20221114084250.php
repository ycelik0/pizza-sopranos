<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114084250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD shoppingcart VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_C8CF76A9685930AE ON shoppingcart_pizza');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP shoppingcart');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8CF76A9685930AE ON shoppingcart_pizza (shoppingcart_id)');
    }
}
