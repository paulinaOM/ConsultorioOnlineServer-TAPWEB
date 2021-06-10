<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102203430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A6B3CA4B FOREIGN KEY (id_user) REFERENCES userdata (id)');
        $this->addSql('CREATE INDEX IDX_1FC0F36A6B3CA4B ON doctor (id_user)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A6B3CA4B');
        $this->addSql('DROP INDEX IDX_1FC0F36A6B3CA4B ON doctor');
    }
}
