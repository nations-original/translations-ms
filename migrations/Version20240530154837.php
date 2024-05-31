<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530154837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applications (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, password LONGTEXT NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_F7C966F05E237E06 (name), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locales (id INT AUTO_INCREMENT NOT NULL, application_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E59B54BB3E030ACD (application_id), UNIQUE INDEX name_application (name, application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, locale_id INT NOT NULL, string VARCHAR(255) NOT NULL, translation LONGTEXT NOT NULL, translation_male LONGTEXT DEFAULT NULL, translation_female LONGTEXT DEFAULT NULL, translation_one LONGTEXT DEFAULT NULL, translation_few LONGTEXT DEFAULT NULL, translation_many LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at TIMESTAMP on update CURRENT_TIMESTAMP, INDEX IDX_B469456FE559DFD1 (locale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE locales ADD CONSTRAINT FK_E59B54BB3E030ACD FOREIGN KEY (application_id) REFERENCES applications (uuid)');
        $this->addSql('ALTER TABLE translation ADD CONSTRAINT FK_B469456FE559DFD1 FOREIGN KEY (locale_id) REFERENCES locales (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE locales DROP FOREIGN KEY FK_E59B54BB3E030ACD');
        $this->addSql('ALTER TABLE translation DROP FOREIGN KEY FK_B469456FE559DFD1');
        $this->addSql('DROP TABLE applications');
        $this->addSql('DROP TABLE locales');
        $this->addSql('DROP TABLE translation');
    }
}
