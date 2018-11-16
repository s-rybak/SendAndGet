<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114182802 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE api_app (id INT AUTO_INCREMENT NOT NULL, host VARCHAR(100) DEFAULT NULL, contact_email VARCHAR(100) NOT NULL,secret VARCHAR(255) NOT NULL, live_key VARCHAR(255) NOT NULL, test_key VARCHAR(255) NOT NULL, limits INT NOT NULL DEFAULT 10, storage INT NOT NULL DEFAULT 0, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , calls_count INT NOT NULL DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE api_app');

    }
}
