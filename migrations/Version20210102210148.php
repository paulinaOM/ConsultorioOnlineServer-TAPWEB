<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102210148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor_service (id INT AUTO_INCREMENT NOT NULL, id_doctor INT NOT NULL, id_service INT NOT NULL, cost NUMERIC(10, 2) NOT NULL, INDEX IDX_7230F97F39F74687 (id_doctor), INDEX IDX_7230F97F3F0033A2 (id_service), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doctor_service ADD CONSTRAINT FK_7230F97F39F74687 FOREIGN KEY (id_doctor) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE doctor_service ADD CONSTRAINT FK_7230F97F3F0033A2 FOREIGN KEY (id_service) REFERENCES service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor_service DROP FOREIGN KEY FK_7230F97F3F0033A2');
        $this->addSql('DROP TABLE doctor_service');
        $this->addSql('DROP TABLE service');
    }
}
