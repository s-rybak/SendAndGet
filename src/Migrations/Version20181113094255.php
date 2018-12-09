<?php

declare(strict_types=1);

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113094255 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_translation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) DEFAULT NULL, excerpt VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL,  locale VARCHAR(2) NOT NULL, translatable_id INT NOT NULL , PRIMARY KEY(id), CONSTRAINT fk_page_page_translations FOREIGN KEY (translatable_id) REFERENCES page (id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO page_translation (translatable_id,locale,title,excerpt,content) VALUES 
						( 1,'ua','Faq','frequently asked questions','initial content for frequently asked questions'),
						( 2,'ua','About us','About us page','initial content for About us page'),
						( 3,'ua','Contact us','Contact us page','initial content for Contact us page'),
						( 4,'ua','Statistic','Statistic page','initial content for Statistic page'),
						( 5,'ua','Terms and conditions','Terms and conditions','initial content for Terms and conditions page'),
						( 6,'ua','Api','Api','initial content for Api page' ),
						( 7,'ua','Send','You always can send file to <span class=\"highlight\">user</span>, <span class=\"highlight\">location</span>, <span class=\"highlight\">email</span>. Just click on triangle near \"Send link\" button','Send every files ( photo, music, documents, etc.) you want. <br>Get<span class=\"highlight\">direct</span>links. <br>Configure<span class=\"highlight\">security</span>.<br>Attach files to<span class=\"highlight\">user</span>, location, email, time, etc. <br>' ),
						( 8,'ua','Get','Get','Get files from another <span class=\"highlight\">user</span><br>Search files in current <span class=\"highlight\">location</span><br>Find files attached to your<span class=\"highlight\">email</span><br>Get files by its <span class=\"highlight\">file id</span>' ),
						( 1,'de','Faq','frequently asked questions','initial content for frequently asked questions'),
						( 2,'de','About us','About us page','initial content for About us page'),
						( 3,'de','Contact us','Contact us page','initial content for Contact us page'),
						( 4,'de','Statistic','Statistic page','initial content for Statistic page'),
						( 5,'de','Terms and conditions','Terms and conditions','initial content for Terms and conditions page'),
						( 6,'de','Api','Api','initial content for Api page' ),
						( 7,'de','Send','You always can send file to <span class=\"highlight\">user</span>, <span class=\"highlight\">location</span>, <span class=\"highlight\">email</span>. Just click on triangle near \"Send link\" button','Send every files ( photo, music, documents, etc.) you want. <br>Get<span class=\"highlight\">direct</span>links. <br>Configure<span class=\"highlight\">security</span>.<br>Attach files to<span class=\"highlight\">user</span>, location, email, time, etc. <br>' ),
						( 8,'de','Get','Get','Get files from another <span class=\"highlight\">user</span><br>Search files in current <span class=\"highlight\">location</span><br>Find files attached to your<span class=\"highlight\">email</span><br>Get files by its <span class=\"highlight\">file id</span>' ),
						( 1,'en','Faq','frequently asked questions','initial content for frequently asked questions'),
						( 2,'en','About us','About us page','initial content for About us page'),
						( 3,'en','Contact us','Contact us page','initial content for Contact us page'),
						( 4,'en','Statistic','Statistic page','initial content for Statistic page'),
						( 5,'en','Terms and conditions','Terms and conditions','initial content for Terms and conditions page'),
						( 6,'en','Api','Api','initial content for Api page' ),
						( 7,'en','Send','You always can send file to <span class=\"highlight\">user</span>, <span class=\"highlight\">location</span>, <span class=\"highlight\">email</span>. Just click on triangle near \"Send link\" button','Send every files ( photo, music, documents, etc.) you want. <br>Get<span class=\"highlight\">direct</span>links. <br>Configure<span class=\"highlight\">security</span>.<br>Attach files to<span class=\"highlight\">user</span>, location, email, time, etc. <br>' ),
						( 8,'en','Get','Get','Get files from another <span class=\"highlight\">user</span><br>Search files in current <span class=\"highlight\">location</span><br>Find files attached to your<span class=\"highlight\">email</span><br>Get files by its <span class=\"highlight\">file id</span>' )
						");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_translation DROP FOREIGN KEY fk_page_page_translations ');
        $this->addSql('DROP TABLE page_translation');
    }
}
