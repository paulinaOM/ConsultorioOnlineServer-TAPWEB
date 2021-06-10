<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102202802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A424B8E99');
        $this->addSql('DROP INDEX IDX_1FC0F36A424B8E99 ON doctor');
        $this->addSql('ALTER TABLE doctor DROP id_especiality');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A565D2059 FOREIGN KEY (id_speciality) REFERENCES speciality (id)');
        $this->addSql('CREATE INDEX IDX_1FC0F36A565D2059 ON doctor (id_speciality)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A565D2059');
        $this->addSql('DROP INDEX IDX_1FC0F36A565D2059 ON doctor');
        $this->addSql('ALTER TABLE doctor ADD id_especiality INT NOT NULL');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A424B8E99 FOREIGN KEY (id_especiality) REFERENCES speciality (id)');
        $this->addSql('CREATE INDEX IDX_1FC0F36A424B8E99 ON doctor (id_especiality)');
    }
}
