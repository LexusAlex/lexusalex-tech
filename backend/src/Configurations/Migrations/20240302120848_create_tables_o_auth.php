<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTablesOAuth extends AbstractMigration
{
    public function up(): void
    {
        $this->execute(
            "CREATE TABLE oauth_auth_codes
                            (identifier VARCHAR(80) NOT NULL,
                             expiry_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                             user_identifier UUID NOT NULL,
                             PRIMARY KEY(identifier)
                            )"
        );

        $this->execute(
            "CREATE TABLE oauth_refresh_tokens
                            (identifier VARCHAR(80) NOT NULL,
                             expiry_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                             user_identifier UUID NOT NULL,
                             PRIMARY KEY(identifier)
                            )"
        );
    }

    public function down(): void
    {
        $this->execute("DROP TABLE oauth_auth_codes");
        $this->execute("DROP TABLE oauth_refresh_tokens");
    }
}
