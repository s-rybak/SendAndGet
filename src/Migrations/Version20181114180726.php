<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114180726 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file_email (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) NOT NULL, file_id INT NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(10) NOT NULL, app_id INT NOT NULL, status VARCHAR(10) NOT NULL, aviable_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_lat_lng (id INT AUTO_INCREMENT NOT NULL, lat VARCHAR(100) NOT NULL, lng VARCHAR(100) NOT NULL, file_id INT NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, file_id INT NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE file_email');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE file_lat_lng');
        $this->addSql('DROP TABLE file_user');
    }
}
