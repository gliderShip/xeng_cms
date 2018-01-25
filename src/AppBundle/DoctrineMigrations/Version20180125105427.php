<?php

namespace AppBundle\DoctrineMigrations;

use AppBundle\Entity\Content\Category;
use AppBundle\Services\Content\CategoryManager;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180125105427 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    private static $productionFixtures = array(
        'categories' => array(
            array('name' => 'evidenced', 'label' => 'Trending', 'hidden' => false),
            array('name' => 'kryesore', 'label' => 'Main', 'hidden' => 'false'),
        ),
    );

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        /** @var CategoryManager $cm */
        $cm = $this->container->get('xeng.category_manager');
        foreach (self::$productionFixtures['categories'] as $cat) {
            $cm->createCategory($cat['name'], $cat['label'], $cat['hidden']);
        }

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        /** TODO remove fixtures 1 by 1 using the manager or truncate */

    }
}
