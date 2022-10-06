<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221002232803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature_value DROP FOREIGN KEY FK_D429523D727ACA70');
        $this->addSql('DROP INDEX IDX_D429523D727ACA70 ON feature_value');
        $this->addSql('ALTER TABLE feature_value DROP parent_id, DROP value');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature_value ADD parent_id INT DEFAULT NULL, ADD value VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE feature_value ADD CONSTRAINT FK_D429523D727ACA70 FOREIGN KEY (parent_id) REFERENCES feature_value (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D429523D727ACA70 ON feature_value (parent_id)');
    }
}
