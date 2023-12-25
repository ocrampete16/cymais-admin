<?php

use App\Enums\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->getPermissionsAsStrings() as $permission) {
            $now = new DateTimeImmutable();

            DB::table($this->getPermissionsTableName())->insert([
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table($this->getPermissionsTableName())->whereIn('name', $this->getPermissionsAsStrings())->delete();
    }

    private function getPermissionsTableName(): string
    {
        $tableNames = config('permission.table_names');

        return $tableNames['permissions'];
    }

    /**
     * @return string[]
     */
    private function getPermissionsAsStrings(): array
    {
        return [
            Permission::APPROVE_USER_REGISTRATION->value,
            Permission::ADD_USER->value,
            Permission::REMOVE_USER->value,
        ];
    }
};
