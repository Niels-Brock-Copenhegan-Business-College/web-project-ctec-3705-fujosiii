<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateInitialSchema extends AbstractMigration
{
    public function up(): void
    {
        // ── admins ────────────────────────────────────────────────────────────
        $this->table('admins')
            ->addColumn('name', 'string', ['limit' => 120])
            ->addColumn('email', 'string', ['limit' => 180])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('role', 'enum', ['values' => ['admin', 'staff'], 'default' => 'admin'])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['email'], ['unique' => true])
            ->create();

        // ── staff ─────────────────────────────────────────────────────────────
        $this->table('staff')
            ->addColumn('name', 'string', ['limit' => 120])
            ->addColumn('email', 'string', ['limit' => 180])
            ->addColumn('title', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('bio', 'text', ['null' => true])
            ->addColumn('photo', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['email'], ['unique' => true])
            ->create();

        // ── programmes ────────────────────────────────────────────────────────
        $this->table('programmes')
            ->addColumn('title', 'string', ['limit' => 200])
            ->addColumn('slug', 'string', ['limit' => 220])
            ->addColumn('level', 'enum', ['values' => ['Undergraduate', 'Postgraduate']])
            ->addColumn('description', 'text')
            ->addColumn('duration_years', 'integer', ['default' => 3])
            ->addColumn('ucas_code', 'string', ['limit' => 20, 'null' => true])
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('is_published', 'boolean', ['default' => false])
            ->addColumn('leader_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['slug'], ['unique' => true])
            ->create();

        // ── modules ───────────────────────────────────────────────────────────
        $this->table('modules')
            ->addColumn('title', 'string', ['limit' => 200])
            ->addColumn('code', 'string', ['limit' => 30])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('credits', 'integer', ['default' => 20])
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('leader_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['code'], ['unique' => true])
            ->create();

        // ── programme_modules (pivot) ─────────────────────────────────────────
        $this->table('programme_modules')
            ->addColumn('programme_id', 'integer', ['signed' => false])
            ->addColumn('module_id', 'integer', ['signed' => false])
            ->addColumn('year', 'integer', ['default' => 1])
            ->addColumn('sort_order', 'integer', ['default' => 0])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();

        // ── interests ─────────────────────────────────────────────────────────
        $this->table('interests')
            ->addColumn('programme_id', 'integer', ['signed' => false])
            ->addColumn('first_name', 'string', ['limit' => 80])
            ->addColumn('last_name', 'string', ['limit' => 80])
            ->addColumn('email', 'string', ['limit' => 180])
            ->addColumn('phone', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['programme_id', 'email'], ['unique' => true])
            ->create();

        // ── Foreign keys (added after all tables exist) ───────────────────────
        $this->table('programmes')
            ->addForeignKey('leader_id', 'staff', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->update();

        $this->table('modules')
            ->addForeignKey('leader_id', 'staff', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->update();

        $this->table('programme_modules')
            ->addForeignKey('programme_id', 'programmes', 'id', ['delete' => 'CASCADE'])
            ->addForeignKey('module_id', 'modules', 'id', ['delete' => 'CASCADE'])
            ->update();

        $this->table('interests')
            ->addForeignKey('programme_id', 'programmes', 'id', ['delete' => 'CASCADE'])
            ->update();
    }

    public function down(): void
    {
        $this->table('interests')->drop()->save();
        $this->table('programme_modules')->drop()->save();
        $this->table('modules')->drop()->save();
        $this->table('programmes')->drop()->save();
        $this->table('staff')->drop()->save();
        $this->table('admins')->drop()->save();
    }
}
