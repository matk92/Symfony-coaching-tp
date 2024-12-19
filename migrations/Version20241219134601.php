<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219134601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coach (id SERIAL NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE customer (id SERIAL NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN customer.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE program (id SERIAL NOT NULL, coach_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92ED77843C105691 ON program (coach_id)');
        $this->addSql('CREATE TABLE session (id SERIAL NOT NULL, program_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D43EB8070A ON session (program_id)');
        $this->addSql('CREATE INDEX IDX_D044D5D49395C3F3 ON session (customer_id)');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED77843C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D43EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D49395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program DROP CONSTRAINT FK_92ED77843C105691');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D43EB8070A');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D49395C3F3');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE session');
    }
}
