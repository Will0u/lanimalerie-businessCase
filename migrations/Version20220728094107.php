<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728094107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill ADD shopping_cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E345F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id)');
        $this->addSql('CREATE INDEX IDX_7A2119E345F80CD ON bill (shopping_cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E345F80CD');
        $this->addSql('DROP INDEX IDX_7A2119E345F80CD ON bill');
        $this->addSql('ALTER TABLE bill DROP shopping_cart_id');
    }
}
