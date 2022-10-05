<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221002232309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature_value ADD feature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE feature_value ADD CONSTRAINT FK_D429523D60E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('CREATE INDEX IDX_D429523D60E4B879 ON feature_value (feature_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature_value DROP FOREIGN KEY FK_D429523D60E4B879');
        $this->addSql('DROP INDEX IDX_D429523D60E4B879 ON feature_value');
        $this->addSql('ALTER TABLE feature_value DROP feature_id');
    }
}
