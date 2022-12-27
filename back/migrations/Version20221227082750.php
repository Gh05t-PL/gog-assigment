<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227082750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fixtures from requirements';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO product VALUES (\'56c0f626-bcca-4a5e-96a8-d427c0ca96a8\', \'Fallout\', 1.99)');
        $this->addSql('INSERT INTO product VALUES (\'e43e3d2d-e972-470c-8c1e-3567c1b359da\', \'Don’t Starve\', 2.99)');
        $this->addSql('INSERT INTO product VALUES (\'cf14b840-8091-4282-9072-382b6e820ad8\', \'Baldur’s Gate\', 3.99)');
        $this->addSql('INSERT INTO product VALUES (\'643f6762-f2db-4d7c-b739-1a60b06c6621\', \'Icewind Dale\', 4.99)');
        $this->addSql('INSERT INTO product VALUES (\'5683a4e0-9b55-4244-a72b-1a1f6d4c3143\', \'Bloodborne\', 5.99)');
    }

    public function down(Schema $schema): void
    {
        // noop
    }
}
