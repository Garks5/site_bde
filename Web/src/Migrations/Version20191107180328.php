<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107180328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D699D2AD61');
        $this->addSql('DROP INDEX IDX_5E90F6D699D2AD61 ON inscription');
        $this->addSql('ALTER TABLE inscription CHANGE id_activity_id id_activities_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D694656407 FOREIGN KEY (id_activities_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D694656407 ON inscription (id_activities_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D694656407');
        $this->addSql('DROP INDEX IDX_5E90F6D694656407 ON inscription');
        $this->addSql('ALTER TABLE inscription CHANGE id_activities_id id_activity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D699D2AD61 FOREIGN KEY (id_activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D699D2AD61 ON inscription (id_activity_id)');
    }
}
