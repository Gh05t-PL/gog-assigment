<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227082710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_D34A04AD2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart (id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart_shopping_cart_line (shopping_cart_id VARCHAR(255) NOT NULL, shopping_cart_line_id VARCHAR(255) NOT NULL, INDEX IDX_3B78146945F80CD (shopping_cart_id), INDEX IDX_3B781469642E2F83 (shopping_cart_line_id), PRIMARY KEY(shopping_cart_id, shopping_cart_line_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart_line (id VARCHAR(255) NOT NULL, product_id VARCHAR(255) DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_2B958C1C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shopping_cart_shopping_cart_line ADD CONSTRAINT FK_3B78146945F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shopping_cart_shopping_cart_line ADD CONSTRAINT FK_3B781469642E2F83 FOREIGN KEY (shopping_cart_line_id) REFERENCES shopping_cart_line (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shopping_cart_line ADD CONSTRAINT FK_2B958C1C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_cart_shopping_cart_line DROP FOREIGN KEY FK_3B78146945F80CD');
        $this->addSql('ALTER TABLE shopping_cart_shopping_cart_line DROP FOREIGN KEY FK_3B781469642E2F83');
        $this->addSql('ALTER TABLE shopping_cart_line DROP FOREIGN KEY FK_2B958C1C4584665A');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE shopping_cart');
        $this->addSql('DROP TABLE shopping_cart_shopping_cart_line');
        $this->addSql('DROP TABLE shopping_cart_line');
    }
}
