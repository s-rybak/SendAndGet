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

	    $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, excerpt VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, status ENUM(\'published\', \'draft\') DEFAULT \'draft\', image VARCHAR(100) DEFAULT NULL, updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO page (id,title,slug,excerpt,content) VALUES 
						( 1,'Faq','faq','frequently asked questions','initial content for frequently asked questions'),
						( 2,'About us','about_us','About us page','initial content for About us page'),
						( 3,'Contact us','contact_us','Contact us page','initial content for Contact us page'),
						( 4,'Statistic','statistic','Statistic page','initial content for Statistic page'),
						( 5,'Terms and conditions','tos','Terms and conditions','initial content for Terms and conditions page'),
						( 6,'Api','api','Api','initial content for Api page' )
						");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE page');
    }
}
