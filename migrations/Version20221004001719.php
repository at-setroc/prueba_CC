<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004001719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE feature ADD active TINYINT(1) NOT NULL, ADD required TINYINT(1) NOT NULL, DROP is_active, DROP is_required');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE feature ADD is_active TINYINT(1) NOT NULL, ADD is_required TINYINT(1) NOT NULL, DROP active, DROP required');
    }
}
