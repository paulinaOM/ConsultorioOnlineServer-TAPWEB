<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104173142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergy (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, id_consultation INT NOT NULL, filename VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chronic_disease (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation_service (id INT AUTO_INCREMENT NOT NULL, id_consultation INT NOT NULL, id_service INT NOT NULL, id_doctor INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(15) NOT NULL, id_consultation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_consultation (id INT AUTO_INCREMENT NOT NULL, id_patient INT NOT NULL, symptom VARCHAR(200) NOT NULL, atention_status INT NOT NULL, consultation_date DATE NOT NULL, id_doctor INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, substance VARCHAR(50) NOT NULL, laboratory VARCHAR(50) NOT NULL, cost NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, city VARCHAR(100) NOT NULL, state VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, birthdate DATE NOT NULL, phone VARCHAR(10) NOT NULL, email VARCHAR(100) NOT NULL, id_user INT NOT NULL, status_covid VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_allergy (id INT AUTO_INCREMENT NOT NULL, id_patient INT NOT NULL, id_allergy INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_disease (id INT AUTO_INCREMENT NOT NULL, id_patient INT NOT NULL, id_disease INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_surgery (id INT AUTO_INCREMENT NOT NULL, id_patient INT NOT NULL, id_surgery INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, id_consultation INT NOT NULL, id_medicine INT NOT NULL, instructions LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surgery (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax_data (id INT AUTO_INCREMENT NOT NULL, id_patient INT NOT NULL, billing_address VARCHAR(100) NOT NULL, shipping_date VARCHAR(100) NOT NULL, id_payment INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE userdata CHANGE role role SMALLINT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE allergy');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE chronic_disease');
        $this->addSql('DROP TABLE consultation_service');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE medical_consultation');
        $this->addSql('DROP TABLE medicine');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patient_allergy');
        $this->addSql('DROP TABLE patient_disease');
        $this->addSql('DROP TABLE patient_surgery');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE surgery');
        $this->addSql('DROP TABLE tax_data');
        $this->addSql('ALTER TABLE userdata CHANGE role role SMALLINT DEFAULT NULL');
    }
}
