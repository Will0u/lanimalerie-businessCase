<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728092624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_cart ADD status_id INT NOT NULL, ADD payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F66BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F64C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_72AAD4F66BF700BD ON shopping_cart (status_id)');
        $this->addSql('CREATE INDEX IDX_72AAD4F64C3A3BB ON shopping_cart (payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F66BF700BD');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F64C3A3BB');
        $this->addSql('DROP INDEX IDX_72AAD4F66BF700BD ON shopping_cart');
        $this->addSql('DROP INDEX IDX_72AAD4F64C3A3BB ON shopping_cart');
        $this->addSql('ALTER TABLE shopping_cart DROP status_id, DROP payment_id');
    }
}
