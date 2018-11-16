<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113094255 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_translation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) DEFAULT NULL, excerpt VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL,  locale VARCHAR(2) NOT NULL, translatable_id INT NOT NULL , PRIMARY KEY(id), CONSTRAINT fk_page_page_translations FOREIGN KEY (translatable_id) REFERENCES page (id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

	    $this->addSql("INSERT INTO page_translation (translatable_id,locale,title,excerpt,content) VALUES 
						( 1,'ua','Faq','frequently asked questions','initial content for frequently asked questions'),
						( 2,'ua','About us','About us page','initial content for About us page'),
						( 3,'ua','Contact us','Contact us page','initial content for Contact us page'),
						( 4,'ua','Statistic','Statistic page','initial content for Statistic page'),
						( 5,'ua','Terms and conditions','Terms and conditions','initial content for Terms and conditions page'),
						( 6,'ua','Api','Api','initial content for Api page' ),
						( 1,'de','Faq','frequently asked questions','initial content for frequently asked questions'),
						( 2,'de','About us','About us page','initial content for About us page'),
						( 3,'de','Contact us','Contact us page','initial content for Contact us page'),
						( 4,'de','Statistic','Statistic page','initial content for Statistic page'),
						( 5,'de','Terms and conditions','Terms and conditions','initial content for Terms and conditions page'),
						( 6,'de','Api','Api','initial content for Api page' ),
						( 1,'en','Faq','frequently asked questions','initial content for frequently asked questions'),
						( 2,'en','About us','About us page','initial content for About us page'),
						( 3,'en','Contact us','Contact us page','initial content for Contact us page'),
						( 4,'en','Statistic','Statistic page','initial content for Statistic page'),
						( 5,'en','Terms and conditions','Terms and conditions','initial content for Terms and conditions page'),
						( 6,'en','Api','Api','initial content for Api page' )
						");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_translation DROP FOREIGN KEY fk_page_page_translations ');
        $this->addSql('DROP TABLE page_translation');

    }
}
