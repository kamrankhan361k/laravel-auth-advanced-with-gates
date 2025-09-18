<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::table('permission_role')->delete();
        DB::table('role_user')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        // Create permissions
        $permissions = [
            'create-post',
            'edit-post',
            'delete-post',
            'publish-post',
            'unpublish-post',
            'create-user',
            'edit-user',
            'delete-user',
            'assign-role',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'display_name' => ucwords(str_replace('-', ' ', $permission)),
                'description' => 'Can ' . str_replace('-', ' ', $permission),
            ]);
        }

        // Create roles and assign created permissions
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'User has access to all system features'
        ]);
        $adminRole->permissions()->sync(Permission::pluck('id'));

        $editorRole = Role::create([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'User can create, edit, publish and unpublish posts'
        ]);
        $editorPermissions = Permission::whereIn('name', [
            'create-post', 'edit-post', 'publish-post', 'unpublish-post'
        ])->pluck('id');
        $editorRole->permissions()->sync($editorPermissions);

        $authorRole = Role::create([
            'name' => 'author',
            'display_name' => 'Author',
            'description' => 'User can create and edit their own posts'
        ]);
        $authorPermissions = Permission::whereIn('name', [
            'create-post', 'edit-post'
        ])->pluck('id');
        $authorRole->permissions()->sync($authorPermissions);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach($adminRole->id);

        // Create editor user
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
        ]);
        $editor->roles()->attach($editorRole->id);

        // Create author user
        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => bcrypt('password'),
        ]);
        $author->roles()->attach($authorRole->id);
    }
}
