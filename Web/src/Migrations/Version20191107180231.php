<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107180231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE components (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE components_order (components_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_AB152796CA91F907 (components_id), INDEX IDX_AB1527968D9F6D38 (order_id), PRIMARY KEY(components_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, available TINYINT(1) NOT NULL, INDEX IDX_F529939879F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, id_type_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, price INT NOT NULL, INDEX IDX_B3BA5A5A1BD125E3 (id_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE components_order ADD CONSTRAINT FK_AB152796CA91F907 FOREIGN KEY (components_id) REFERENCES components (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE components_order ADD CONSTRAINT FK_AB1527968D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939879F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A1BD125E3 FOREIGN KEY (id_type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE components_order DROP FOREIGN KEY FK_AB152796CA91F907');
        $this->addSql('ALTER TABLE components_order DROP FOREIGN KEY FK_AB1527968D9F6D38');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A1BD125E3');
        $this->addSql('DROP TABLE components');
        $this->addSql('DROP TABLE components_order');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE type');
    }
}
