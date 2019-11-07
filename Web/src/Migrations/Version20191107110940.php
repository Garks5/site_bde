<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107110940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commentary (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, commentary VARCHAR(255) NOT NULL, INDEX IDX_1CAC12CA79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_activity (inscription_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_5E176FF5DAC5993 (inscription_id), INDEX IDX_5E176FF81C06096 (activity_id), PRIMARY KEY(inscription_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_role_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, mail VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, localisation VARCHAR(50) NOT NULL, INDEX IDX_8D93D64989E8BDC (id_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_5A10856479F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription_activity ADD CONSTRAINT FK_5E176FF5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_activity ADD CONSTRAINT FK_5E176FF81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64989E8BDC FOREIGN KEY (id_role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE composition_order');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('ALTER TABLE activity ADD id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A79F37AE5 ON activity (id_user_id)');
        $this->addSql('ALTER TABLE picture ADD id_user_id INT DEFAULT NULL, ADD id_activity_id INT DEFAULT NULL, CHANGE url url VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8979F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8999D2AD61 FOREIGN KEY (id_activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8979F37AE5 ON picture (id_user_id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8999D2AD61 ON picture (id_activity_id)');
        $this->addSql('ALTER TABLE role CHANGE name name VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscription_activity DROP FOREIGN KEY FK_5E176FF5DAC5993');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A79F37AE5');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA79F37AE5');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8979F37AE5');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856479F37AE5');
        $this->addSql('CREATE TABLE composition (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE composition_order (composition_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_48592EE787A2E12 (composition_id), INDEX IDX_48592EE78D9F6D38 (order_id), PRIMARY KEY(composition_id, order_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, localisation VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE commentary');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_activity');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP INDEX IDX_AC74095A79F37AE5 ON activity');
        $this->addSql('ALTER TABLE activity DROP id_user_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8999D2AD61');
        $this->addSql('DROP INDEX IDX_16DB4F8979F37AE5 ON picture');
        $this->addSql('DROP INDEX IDX_16DB4F8999D2AD61 ON picture');
        $this->addSql('ALTER TABLE picture DROP id_user_id, DROP id_activity_id, CHANGE url url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role CHANGE name name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
