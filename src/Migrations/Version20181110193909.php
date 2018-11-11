<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181110193909 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, parent_id INT NUll, title VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, excerpt VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, status ENUM(\'published\',\'draft\') NOT NULL, lang VARCHAR(2) NOT NULL, image VARCHAR(100) DEFAULT NULL, updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO page (id,parent_id,title,slug,excerpt,content,status,lang) VALUES 
						( 1,NULL , 'Faq','faq','frequently asked questions','initial content for frequently asked questions','draft','en' ),
						( 2,1,'Faq','faq','frequently asked questions','initial content for frequently asked questions','draft','ua' ),
						( 3,1,'Faq','faq','frequently asked questions','initial content for frequently asked questions','draft','de' ),
						
						( 4,NULL ,'About us','about_us','About us page','initial content for About us page','draft','en' ),
						( 5,4,'About us','about_us','About us page','initial content for About us page','draft','ua' ),
						( 6,4,'About us','about_us','About us page','initial content for About us page','draft','de' ),
						
						( 7,NULL, 'Contact us','contact_us','Contact us page','initial content for Contact us page','draft','en' ),
						( 8,7,'Contact us','contact_us','Contact us page','initial content for Contact us page','draft','ua' ),
						( 9,7,'Contact us','contact_us','Contact us page','initial content for Contact us page','draft','de' ),
						
						( 10,null ,'Statistic','statistic','Statistic page','initial content for Statistic page','draft','en' ),
						( 11,10,'Statistic','statistic','Statistic page','initial content for Statistic page','draft','ua' ),
						( 12,10,'Statistic','statistic','Statistic page','initial content for Statistic page','draft','de' ),
						
						( 13,null,'Terms and conditions','tos','Terms and conditions','initial content for Terms and conditions page','draft','en' ),
						( 14,13,'Terms and conditions','tos','Terms and conditions','initial content for Terms and conditions page','draft','ua' ),
						( 15,13,'Terms and conditions','tos','Terms and conditions','initial content for Terms and conditions page','draft','de' ),
						
						( 16,null,'Api','api','Api','initial content for Api page','draft','en' ),
						( 17,16,'Api','api','Api','initial content for Api page','draft','ua' ),
						( 18,16,'Api','api','Api','initial content for Api page','draft','de' );
						");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE page');

    }
}
