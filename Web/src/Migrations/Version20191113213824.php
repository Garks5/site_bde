<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113213824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscriptions ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_74E0281C67B3B43D ON inscriptions (users_id)');
        $this->addSql('ALTER TABLE users RENAME INDEX roles_id TO IDX_1483A5E938C751C4');
        $this->addSql('ALTER TABLE activities ADD place VARCHAR(255) NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE products ADD picture VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commentaries ADD activities_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB2A4DB562 FOREIGN KEY (activities_id) REFERENCES activities (id)');
        $this->addSql('CREATE INDEX IDX_4ED55CCB2A4DB562 ON commentaries (activities_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activities DROP place, DROP name, DROP description, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB2A4DB562');
        $this->addSql('DROP INDEX IDX_4ED55CCB2A4DB562 ON commentaries');
        $this->addSql('ALTER TABLE commentaries DROP activities_id');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C67B3B43D');
        $this->addSql('DROP INDEX IDX_74E0281C67B3B43D ON inscriptions');
        $this->addSql('ALTER TABLE inscriptions DROP users_id');
        $this->addSql('ALTER TABLE products DROP picture');
        $this->addSql('ALTER TABLE users RENAME INDEX idx_1483a5e938c751c4 TO roles_id');
    }
}
