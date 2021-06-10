<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104205614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prueba1 (id INT AUTO_INCREMENT NOT NULL, campo1 VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prueba2 (id INT AUTO_INCREMENT NOT NULL, foraneo_id INT DEFAULT NULL, campo1 VARCHAR(109) NOT NULL, INDEX IDX_F546DF39E674EEE8 (foraneo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prueba2 ADD CONSTRAINT FK_F546DF39E674EEE8 FOREIGN KEY (foraneo_id) REFERENCES prueba1 (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prueba2 DROP FOREIGN KEY FK_F546DF39E674EEE8');
        $this->addSql('DROP TABLE prueba1');
        $this->addSql('DROP TABLE prueba2');
    }
}
