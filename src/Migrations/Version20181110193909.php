<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181110193909 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

	    $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(100) NOT NULL, image VARCHAR(100) DEFAULT NULL, updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO page (id,slug) VALUES 
						( 1,'faq' ),
						( 2,'about_us' ),
						( 3,'contact_us' ),
						( 4,'statistic' ),
						( 5,'tos' ),
						( 6,'api' )
						");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE page');
    }
}
