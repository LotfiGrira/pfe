<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des rôles
        $role_admin = Role::create(['name' => 'admin']);
        $role_user = Role::create(['name' => 'user']);

        // Création des permissions
        $permission_create_examen = Permission::create(['name' => 'create examen']);
        $permission_edit_examen = Permission::create(['name' => 'edit examen']);
        $permission_delete_examen = Permission::create(['name' => 'delete examen']);
        $permission_list_examen = Permission::create(['name' => 'list examen']);
        $permission_create_question = Permission::create(['name' => 'create question']);
        $permission_edit_question = Permission::create(['name' => 'edit question']);
        $permission_delete_question = Permission::create(['name' => 'delete question']);
        $permission_list_question = Permission::create(['name' => 'list question']);
        $permission_answer_question = Permission::create(['name' => 'answer question']);
        $permission_view_question = Permission::create(['name' => 'view question']);

        // Assignation des permissions à l'admin
        $role_admin->syncPermissions([
            $permission_create_examen,
            $permission_edit_examen,
            $permission_delete_examen,
            $permission_list_examen,
            $permission_create_question,
            $permission_edit_question,
            $permission_delete_question,
            $permission_list_question,
        ]);

        // Assignation des permissions à l'utilisateur
        $role_user->syncPermissions([
            $permission_answer_question,
            $permission_view_question,
        ]);
    }
}
