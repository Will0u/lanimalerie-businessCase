<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728092157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inside_shopping_cart (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, shopping_cart_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_86A947404584665A (product_id), INDEX IDX_86A9474045F80CD (shopping_cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inside_shopping_cart ADD CONSTRAINT FK_86A947404584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE inside_shopping_cart ADD CONSTRAINT FK_86A9474045F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inside_shopping_cart');
    }
}
