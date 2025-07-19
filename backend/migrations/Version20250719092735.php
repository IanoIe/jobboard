<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250719092735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_job ADD email VARCHAR(255) NOT NULL, ADD cv_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP cv_filename');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_job DROP email, DROP cv_filename');
        $this->addSql('ALTER TABLE user ADD cv_filename VARCHAR(255) DEFAULT NULL');
    }
}
