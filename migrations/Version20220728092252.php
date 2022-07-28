<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728092252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_cart ADD inside_shopping_cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F66E98AF8 FOREIGN KEY (inside_shopping_cart_id) REFERENCES inside_shopping_cart (id)');
        $this->addSql('CREATE INDEX IDX_72AAD4F66E98AF8 ON shopping_cart (inside_shopping_cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F66E98AF8');
        $this->addSql('DROP INDEX IDX_72AAD4F66E98AF8 ON shopping_cart');
        $this->addSql('ALTER TABLE shopping_cart DROP inside_shopping_cart_id');
    }
}
