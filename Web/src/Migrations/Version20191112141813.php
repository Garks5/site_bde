<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112141813 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaries ADD activities_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB2A4DB562 FOREIGN KEY (activities_id) REFERENCES activities (id)');
        $this->addSql('CREATE INDEX IDX_4ED55CCB2A4DB562 ON commentaries (activities_id)');
        $this->addSql('ALTER TABLE products ADD picture VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB2A4DB562');
        $this->addSql('DROP INDEX IDX_4ED55CCB2A4DB562 ON commentaries');
        $this->addSql('ALTER TABLE commentaries DROP activities_id');
        $this->addSql('ALTER TABLE products DROP picture');
    }
}
