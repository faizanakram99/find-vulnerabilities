<?php

namespace Gounsch;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\TypeRegistry;
use Doctrine\DBAL\Types\Types;

class Files
{
    public function __construct(
        private Connection $connection,
        private ?string $user,
    ) {
    }

    public function setup(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if ($schemaManager->tableExists('files')) {
            return;
        }

        $schemaManager->createTable(
            new Table('files', [
                new Column('filename', Type::getType(Types::STRING)),
                new Column('data', Type::getType(Types::BLOB)),
                new Column('user', Type::getType(Types::STRING)),
            ])
        );
    }

    public function list(): array
    {
        if (null === $this->user) {
            return [];
        }

        return $this->connection->fetchFirstColumn('SELECT filename from files where user = :user', [
            'user' => $this->user,
        ]);
    }

    public function get(string $filename): string
    {
        if (null === $this->user) {
            return '';
        }

        return (string) $this->connection->fetchOne('SELECT data from files where filename = :name AND user = :user', [
            'name' => $filename,
            'user' => $this->user,
        ]);
    }

    public function add(string $filename, string $data): void
    {
        if (null === $user = $this->user) {
            return;
        }

        $this->delete($filename);

        $this->connection->insert('files', compact('filename', 'data', 'user'));
    }

    public function delete(string $filename): void
    {
        if (null === $user = $this->user) {
            return;
        }

        $this->connection->delete('files', compact('filename', 'user'));
    }
}