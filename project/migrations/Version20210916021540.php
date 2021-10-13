<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916021540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, degree_title VARCHAR(255) DEFAULT NULL, school VARCHAR(255) DEFAULT NULL, date_earned DATE DEFAULT NULL, extra VARCHAR(512) DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DB0A5ED2217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(100) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, linked_in_url VARCHAR(255) DEFAULT NULL, github_url VARCHAR(255) DEFAULT NULL, facebook_url VARCHAR(255) DEFAULT NULL, twitter_url VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, rank_one_to_ten INT DEFAULT NULL, category VARCHAR(100) DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5E3DE477217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', username VARCHAR(64) NOT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, confirmation_key VARCHAR(255) DEFAULT NULL, last_login_at DATETIME DEFAULT NULL, agreed_to_terms_on DATETIME DEFAULT NULL, confirmation_key_expiration DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, guid VARCHAR(260) DEFAULT NULL, UNIQUE INDEX user_unique (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_experience (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, title VARCHAR(255) NOT NULL, employer VARCHAR(255) DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, is_current TINYINT(1) NOT NULL, summary LONGTEXT DEFAULT NULL, duties LONGTEXT DEFAULT NULL, interests LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1EF36CD0217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_experience_skill (work_experience_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_1892B9BB6347713 (work_experience_id), INDEX IDX_1892B9BB5585C142 (skill_id), PRIMARY KEY(work_experience_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE work_experience_skill ADD CONSTRAINT FK_1892B9BB6347713 FOREIGN KEY (work_experience_id) REFERENCES work_experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_experience_skill ADD CONSTRAINT FK_1892B9BB5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED2217BBB47');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477217BBB47');
        $this->addSql('ALTER TABLE work_experience DROP FOREIGN KEY FK_1EF36CD0217BBB47');
        $this->addSql('ALTER TABLE work_experience_skill DROP FOREIGN KEY FK_1892B9BB5585C142');
        $this->addSql('ALTER TABLE work_experience_skill DROP FOREIGN KEY FK_1892B9BB6347713');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work_experience');
        $this->addSql('DROP TABLE work_experience_skill');
    }
}
