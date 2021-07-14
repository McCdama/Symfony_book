<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714151031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // we will got an error after running migrate.
        // $this->addSql('ALTER TABLE conference ADD slug VARCHAR(255) NOT NULL');

        /* FIX: tweaking the migration */
        $this->addSql('ALTER TABLE conference ADD slug VARCHAR(255)');
        $this->addSql("UPDATE conference SET slug=CONCAT(LOWER(city), '-', year)");
        //$this->addSql('ALTER TABLE conference ALTER COLUMN slug SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP slug');
    }
}
