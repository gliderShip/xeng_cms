<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180124154151 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE x_profile (
                    id INT AUTO_INCREMENT NOT NULL, 
                    user_id INT DEFAULT NULL, 
                    image_id INT DEFAULT NULL, 
                    first_name VARCHAR(150) NOT NULL, 
                    last_name VARCHAR(150) NOT NULL, 
                    UNIQUE INDEX UNIQ_3D4FE178A76ED395 (user_id), 
                    UNIQUE INDEX UNIQ_3D4FE1783DA5256D (image_id), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE x_profile_image (
                    id INT AUTO_INCREMENT NOT NULL, 
                    profile INT DEFAULT NULL, 
                    path VARCHAR(255) NOT NULL, 
                    original_name VARCHAR(255) NOT NULL, 
                    mime_type VARCHAR(100) NOT NULL, 
                    size INT NOT NULL, 
                    last_updated DATETIME NOT NULL, 
                    UNIQUE INDEX UNIQ_5204B7A88157AA0F (profile), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE x_role (
                    id INT AUTO_INCREMENT NOT NULL, 
                    name VARCHAR(100) NOT NULL, 
                    description VARCHAR(255) NOT NULL, 
                    enabled TINYINT(1) NOT NULL, 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE x_role_permission (
                    id INT AUTO_INCREMENT NOT NULL, 
                    role_id INT DEFAULT NULL, 
                    module VARCHAR(50) NOT NULL, 
                    permission VARCHAR(255) NOT NULL, 
                    INDEX IDX_B556246FD60322AC (role_id), 
                    UNIQUE INDEX role_permission_unique (role_id, permission), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE x_user (
                    id INT AUTO_INCREMENT NOT NULL, 
                    profile_id INT DEFAULT NULL, 
                    username VARCHAR(100) NOT NULL, 
                    email VARCHAR(100) NOT NULL, 
                    password VARCHAR(255) NOT NULL, 
                    confirmation_token VARCHAR(255) DEFAULT NULL, 
                    password_requested_at DATETIME DEFAULT NULL, 
                    last_login DATETIME DEFAULT NULL, 
                    roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', 
                    enabled TINYINT(1) NOT NULL, 
                    UNIQUE INDEX UNIQ_40277F40CCFA12B8 (profile_id), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE x_user_role (
                    id INT AUTO_INCREMENT NOT NULL, 
                    user_id INT DEFAULT NULL, 
                    role_id INT DEFAULT NULL, 
                    INDEX IDX_AC980D92A76ED395 (user_id), 
                    INDEX IDX_AC980D92D60322AC (role_id), 
                    UNIQUE INDEX user_role_unique (user_id, role_id), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE content_node (
                    id INT AUTO_INCREMENT NOT NULL, 
                    owner INT DEFAULT NULL, 
                    slug VARCHAR(255) NOT NULL, 
                    created_at DATETIME NOT NULL, 
                    modified_at DATETIME NOT NULL, 
                    status INT NOT NULL, 
                    published_at DATETIME DEFAULT NULL, 
                    contentType VARCHAR(255) NOT NULL, 
                    INDEX IDX_481D0580CF60E67C (owner), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE base_content (
                    id INT NOT NULL, 
                    image_id INT DEFAULT NULL, 
                    author INT DEFAULT NULL, 
                    title VARCHAR(150) NOT NULL, 
                    UNIQUE INDEX UNIQ_CAC389CD3DA5256D (image_id), 
                    INDEX IDX_CAC389CDBDAFD8C8 (author), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE category (
                    id INT AUTO_INCREMENT NOT NULL, 
                    name VARCHAR(150) NOT NULL, 
                    `label` VARCHAR(150) NOT NULL, 
                    hidden TINYINT(1) NOT NULL, 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE content_category (
                id INT AUTO_INCREMENT NOT NULL, 
                node_id INT DEFAULT NULL, 
                category_id INT DEFAULT NULL, 
                INDEX IDX_54FBF32E460D9FD7 (node_id), 
                INDEX IDX_54FBF32E12469DE2 (category_id), 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE content_image (
                    id INT AUTO_INCREMENT NOT NULL, 
                    owner INT DEFAULT NULL, 
                    caption VARCHAR(255) NOT NULL, 
                    path VARCHAR(255) NOT NULL, 
                    original_name VARCHAR(255) NOT NULL, 
                    mime_type VARCHAR(100) NOT NULL, 
                    size INT NOT NULL, 
                    last_updated DATETIME NOT NULL, 
                    INDEX IDX_2EFE508DCF60E67C (owner), 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE news_article (
                    id INT NOT NULL, 
                    summary VARCHAR(255) NOT NULL, 
                    body LONGTEXT NOT NULL, 
                    PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8 
            COLLATE utf8_unicode_ci 
            ENGINE = InnoDB'
        );

        $this->addSql(
            'ALTER TABLE x_profile 
                    ADD CONSTRAINT FK_3D4FE178A76ED395 FOREIGN KEY (user_id) REFERENCES x_user (id),
                    ADD CONSTRAINT FK_3D4FE1783DA5256D FOREIGN KEY (image_id) REFERENCES x_profile_image (id)'
        );

        $this->addSql(
            'ALTER TABLE x_profile_image 
                    ADD CONSTRAINT FK_5204B7A88157AA0F FOREIGN KEY (profile) REFERENCES x_profile (id)'
        );

        $this->addSql(
            'ALTER TABLE x_role_permission 
                    ADD CONSTRAINT FK_B556246FD60322AC FOREIGN KEY (role_id) REFERENCES x_role (id)'
        );

        $this->addSql(
            'ALTER TABLE x_user 
                    ADD CONSTRAINT FK_40277F40CCFA12B8 FOREIGN KEY (profile_id) REFERENCES x_profile (id)'
        );

        $this->addSql(
            'ALTER TABLE x_user_role 
                    ADD CONSTRAINT FK_AC980D92A76ED395 FOREIGN KEY (user_id) REFERENCES x_user (id),
                    ADD CONSTRAINT FK_AC980D92D60322AC FOREIGN KEY (role_id) REFERENCES x_role (id)'
        );

        $this->addSql(
            'ALTER TABLE content_node 
                    ADD CONSTRAINT FK_481D0580CF60E67C FOREIGN KEY (owner) REFERENCES x_user (id)'
        );
        $this->addSql(
            'ALTER TABLE base_content 
                    ADD CONSTRAINT FK_CAC389CD3DA5256D FOREIGN KEY (image_id) REFERENCES content_image (id),
                    ADD CONSTRAINT FK_CAC389CDBDAFD8C8 FOREIGN KEY (author) REFERENCES x_user (id),
                    ADD CONSTRAINT FK_CAC389CDBF396750 FOREIGN KEY (id) REFERENCES content_node (id) ON DELETE CASCADE'
        );

        $this->addSql(
            'ALTER TABLE content_category 
                    ADD CONSTRAINT FK_54FBF32E460D9FD7 FOREIGN KEY (node_id) REFERENCES content_node (id),
                    ADD CONSTRAINT FK_54FBF32E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)'
        );

        $this->addSql(
            'ALTER TABLE content_image 
                    ADD CONSTRAINT FK_2EFE508DCF60E67C FOREIGN KEY (owner) REFERENCES base_content (id)'
        );
        $this->addSql(
            'ALTER TABLE news_article 
                    ADD CONSTRAINT FK_55DE1280BF396750 FOREIGN KEY (id) REFERENCES content_node (id) ON DELETE CASCADE'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE x_profile_image DROP FOREIGN KEY FK_5204B7A88157AA0F');
        $this->addSql('ALTER TABLE x_user DROP FOREIGN KEY FK_40277F40CCFA12B8');
        $this->addSql('ALTER TABLE x_profile DROP FOREIGN KEY FK_3D4FE1783DA5256D');
        $this->addSql('ALTER TABLE x_role_permission DROP FOREIGN KEY FK_B556246FD60322AC');
        $this->addSql('ALTER TABLE x_user_role DROP FOREIGN KEY FK_AC980D92D60322AC');
        $this->addSql('ALTER TABLE x_profile DROP FOREIGN KEY FK_3D4FE178A76ED395');
        $this->addSql('ALTER TABLE x_user_role DROP FOREIGN KEY FK_AC980D92A76ED395');
        $this->addSql('ALTER TABLE content_node DROP FOREIGN KEY FK_481D0580CF60E67C');
        $this->addSql('ALTER TABLE base_content DROP FOREIGN KEY FK_CAC389CDBDAFD8C8');
        $this->addSql('ALTER TABLE base_content DROP FOREIGN KEY FK_CAC389CDBF396750');
        $this->addSql('ALTER TABLE content_category DROP FOREIGN KEY FK_54FBF32E460D9FD7');
        $this->addSql('ALTER TABLE news_article DROP FOREIGN KEY FK_55DE1280BF396750');
        $this->addSql('ALTER TABLE content_image DROP FOREIGN KEY FK_2EFE508DCF60E67C');
        $this->addSql('ALTER TABLE content_category DROP FOREIGN KEY FK_54FBF32E12469DE2');
        $this->addSql('ALTER TABLE base_content DROP FOREIGN KEY FK_CAC389CD3DA5256D');
        $this->addSql('DROP TABLE x_profile');
        $this->addSql('DROP TABLE x_profile_image');
        $this->addSql('DROP TABLE x_role');
        $this->addSql('DROP TABLE x_role_permission');
        $this->addSql('DROP TABLE x_user');
        $this->addSql('DROP TABLE x_user_role');
        $this->addSql('DROP TABLE content_node');
        $this->addSql('DROP TABLE base_content');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE content_category');
        $this->addSql('DROP TABLE content_image');
        $this->addSql('DROP TABLE news_article');
    }
}
