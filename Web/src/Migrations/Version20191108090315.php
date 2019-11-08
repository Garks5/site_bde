<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108090315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscription_activity DROP FOREIGN KEY FK_5E176FF81C06096');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8999D2AD61');
        $this->addSql('CREATE TABLE components (id INT AUTO_INCREMENT NOT NULL, products_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_EE48F5FD6C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE components_orders (components_id INT NOT NULL, orders_id INT NOT NULL, INDEX IDX_2C9EC5DCA91F907 (components_id), INDEX IDX_2C9EC5DCFFE9AD6 (orders_id), PRIMARY KEY(components_id, orders_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE votes (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, INDEX IDX_518B7ACF67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activities (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, date DATETIME NOT NULL, available TINYINT(1) NOT NULL, INDEX IDX_B5F1AFE567B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, types_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_B3BA5A5A8EB23357 (types_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, activities_id INT DEFAULT NULL, url VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_8F7C2FC067B3B43D (users_id), INDEX IDX_8F7C2FC02A4DB562 (activities_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaries (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, commentary VARCHAR(255) NOT NULL, INDEX IDX_4ED55CCB67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, available TINYINT(1) NOT NULL, INDEX IDX_E52FFDEE67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE components ADD CONSTRAINT FK_EE48F5FD6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE components_orders ADD CONSTRAINT FK_2C9EC5DCA91F907 FOREIGN KEY (components_id) REFERENCES components (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE components_orders ADD CONSTRAINT FK_2C9EC5DCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE activities ADD CONSTRAINT FK_B5F1AFE567B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A8EB23357 FOREIGN KEY (types_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC067B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC02A4DB562 FOREIGN KEY (activities_id) REFERENCES activities (id)');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE commentary');
        $this->addSql('DROP TABLE inscription_activity');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE vote');
        $this->addSql('ALTER TABLE inscriptions ADD activities_id INT DEFAULT NULL, DROP date');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C2A4DB562 FOREIGN KEY (activities_id) REFERENCES activities (id)');
        $this->addSql('CREATE INDEX IDX_74E0281C2A4DB562 ON inscriptions (activities_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_8D93D64989E8BDC');
        $this->addSql('DROP INDEX IDX_8D93D64989E8BDC ON users');
        $this->addSql('ALTER TABLE users CHANGE id_role_id roles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E938C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E938C751C4 ON users (roles_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE components_orders DROP FOREIGN KEY FK_2C9EC5DCA91F907');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C2A4DB562');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC02A4DB562');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A8EB23357');
        $this->addSql('ALTER TABLE components DROP FOREIGN KEY FK_EE48F5FD6C8A81A9');
        $this->addSql('ALTER TABLE components_orders DROP FOREIGN KEY FK_2C9EC5DCFFE9AD6');
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATETIME NOT NULL, available TINYINT(1) NOT NULL, INDEX IDX_AC74095A79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentary (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, commentary VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1CAC12CA79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE inscription_activity (inscription_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_5E176FF5DAC5993 (inscription_id), INDEX IDX_5E176FF81C06096 (activity_id), PRIMARY KEY(inscription_id, activity_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_activity_id INT DEFAULT NULL, url VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_16DB4F8979F37AE5 (id_user_id), INDEX IDX_16DB4F8999D2AD61 (id_activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_5A10856479F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE inscription_activity ADD CONSTRAINT FK_5E176FF5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscriptions (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_activity ADD CONSTRAINT FK_5E176FF81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8979F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8999D2AD61 FOREIGN KEY (id_activity_id) REFERENCES activity (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE components');
        $this->addSql('DROP TABLE components_orders');
        $this->addSql('DROP TABLE votes');
        $this->addSql('DROP TABLE activities');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE commentaries');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP INDEX IDX_74E0281C2A4DB562 ON inscriptions');
        $this->addSql('ALTER TABLE inscriptions ADD date DATETIME NOT NULL, DROP activities_id');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E938C751C4');
        $this->addSql('DROP INDEX IDX_1483A5E938C751C4 ON users');
        $this->addSql('ALTER TABLE users CHANGE roles_id id_role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_8D93D64989E8BDC FOREIGN KEY (id_role_id) REFERENCES roles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D64989E8BDC ON users (id_role_id)');
    }
}