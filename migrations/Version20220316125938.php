<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Faker\Factory;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316125938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'generate fake data';
    }

    public function up(Schema $schema): void
    {
        $faker = Factory::create();

        $this->connection->beginTransaction();
        for($i=1; $i < 10023; $i++) {
            $this->connection->insert('author', ['name' => $faker->name]);
        }

        for($i=1; $i < 10023; $i++) {
            $this->connection->insert(
                'book',
                [
                    'title' => $faker->company,
                    'author_id' => $i
                ]);
        }

        $this->connection->commit();
    }

    public function down(Schema $schema): void
    {
        $this->addSql('truncate TABLE author');
        $this->addSql('truncate TABLE book');
    }
}
