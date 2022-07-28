<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728093906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inside_shopping_cart ADD shopping_cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE inside_shopping_cart ADD CONSTRAINT FK_86A9474045F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id)');
        $this->addSql('CREATE INDEX IDX_86A9474045F80CD ON inside_shopping_cart (shopping_cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inside_shopping_cart DROP FOREIGN KEY FK_86A9474045F80CD');
        $this->addSql('DROP INDEX IDX_86A9474045F80CD ON inside_shopping_cart');
        $this->addSql('ALTER TABLE inside_shopping_cart DROP shopping_cart_id');
    }
}
