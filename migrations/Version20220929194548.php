<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220929194548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D6499F75D7B0 ON user');
        $this->addSql('ALTER TABLE user ADD creation_date DATETIME DEFAULT NULL, DROP external_id, DROP first_name, DROP last_name, DROP avatar');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD external_id VARCHAR(20) NOT NULL, ADD first_name VARCHAR(100) DEFAULT NULL, ADD last_name VARCHAR(100) DEFAULT NULL, ADD avatar VARCHAR(255) DEFAULT NULL, DROP creation_date');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499F75D7B0 ON user (external_id)');
    }
}
