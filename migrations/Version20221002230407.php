<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221002230407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, feature_value_id INT DEFAULT NULL, field_type_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, code_name VARCHAR(100) NOT NULL, form_order INT NOT NULL, is_active TINYINT(1) NOT NULL, is_required TINYINT(1) NOT NULL, next_feature_in_same_section TINYINT(1) NOT NULL, INDEX IDX_1FD7756612469DE2 (category_id), INDEX IDX_1FD77566727ACA70 (parent_id), INDEX IDX_1FD7756680CD149D (feature_value_id), INDEX IDX_1FD775662B68A933 (field_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feature_value (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_D429523D727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_type (id INT AUTO_INCREMENT NOT NULL, code_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_order (id INT AUTO_INCREMENT NOT NULL, requester VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_order_feature_value (id INT AUTO_INCREMENT NOT NULL, purchase_order_id INT DEFAULT NULL, feature_value_id INT DEFAULT NULL, INDEX IDX_E5091652A45D7E6A (purchase_order_id), INDEX IDX_E509165280CD149D (feature_value_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD7756612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD77566727ACA70 FOREIGN KEY (parent_id) REFERENCES feature (id)');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD7756680CD149D FOREIGN KEY (feature_value_id) REFERENCES feature_value (id)');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD775662B68A933 FOREIGN KEY (field_type_id) REFERENCES field_type (id)');
        $this->addSql('ALTER TABLE feature_value ADD CONSTRAINT FK_D429523D727ACA70 FOREIGN KEY (parent_id) REFERENCES feature_value (id)');
        $this->addSql('ALTER TABLE purchase_order_feature_value ADD CONSTRAINT FK_E5091652A45D7E6A FOREIGN KEY (purchase_order_id) REFERENCES purchase_order (id)');
        $this->addSql('ALTER TABLE purchase_order_feature_value ADD CONSTRAINT FK_E509165280CD149D FOREIGN KEY (feature_value_id) REFERENCES feature_value (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD7756612469DE2');
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD77566727ACA70');
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD7756680CD149D');
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD775662B68A933');
        $this->addSql('ALTER TABLE feature_value DROP FOREIGN KEY FK_D429523D727ACA70');
        $this->addSql('ALTER TABLE purchase_order_feature_value DROP FOREIGN KEY FK_E5091652A45D7E6A');
        $this->addSql('ALTER TABLE purchase_order_feature_value DROP FOREIGN KEY FK_E509165280CD149D');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE feature_value');
        $this->addSql('DROP TABLE field_type');
        $this->addSql('DROP TABLE purchase_order');
        $this->addSql('DROP TABLE purchase_order_feature_value');
    }
}
