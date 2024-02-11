<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableAuthenticationUsers extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("CREATE TABLE authentication_users
           (id UUID NOT NULL,
            email VARCHAR(255) NOT NULL,
            PRIMARY KEY(id))");
    }

    public function down(): void
    {
        $this->execute("DROP TABLE authentication_users");
    }
}
