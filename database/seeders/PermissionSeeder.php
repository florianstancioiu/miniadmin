<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'List Dashboard',
                'slug' => 'list-dashboard',
                'group' => 'dashboard',
            ],
            /** pages */
            [
                'title' => 'List Pages',
                'slug' => 'list-pages',
                'group' => 'pages',
            ],
            [
                'title' => 'Create Pages',
                'slug' => 'create-pages',
                'group' => 'pages',
            ],
            [
                'title' => 'Store Pages',
                'slug' => 'store-pages',
                'group' => 'pages',
            ],
            [
                'title' => 'Edit Pages',
                'slug' => 'edit-pages',
                'group' => 'pages',
            ],
            [
                'title' => 'Update Pages',
                'slug' => 'update-pages',
                'group' => 'pages',
            ],
            [
                'title' => 'Destroy Pages',
                'slug' => 'destroy-pages',
                'group' => 'pages',
            ],
            /** posts */
            [
                'title' => 'List Posts',
                'slug' => 'list-posts',
                'group' => 'posts',
            ],
            [
                'title' => 'Create Posts',
                'slug' => 'create-posts',
                'group' => 'posts',
            ],
            [
                'title' => 'Store Posts',
                'slug' => 'store-posts',
                'group' => 'posts',
            ],
            [
                'title' => 'Edit Posts',
                'slug' => 'edit-posts',
                'group' => 'posts',
            ],
            [
                'title' => 'Update Posts',
                'slug' => 'update-posts',
                'group' => 'posts',
            ],
            [
                'title' => 'Destroy Posts',
                'slug' => 'destroy-posts',
                'group' => 'posts',
            ],
            /** categories */
            [
                'title' => 'List Categories',
                'slug' => 'list-categories',
                'group' => 'categories',
            ],
            [
                'title' => 'Create Categories',
                'slug' => 'create-categories',
                'group' => 'categories',
            ],
            [
                'title' => 'Store Categories',
                'slug' => 'store-categories',
                'group' => 'categories',
            ],
            [
                'title' => 'Edit Categories',
                'slug' => 'edit-categories',
                'group' => 'categories',
            ],
            [
                'title' => 'Update Categories',
                'slug' => 'update-categories',
                'group' => 'categories',
            ],
            [
                'title' => 'Destroy Categories',
                'slug' => 'destroy-categories',
                'group' => 'categories',
            ],
            /** tags */
            [
                'title' => 'List Tags',
                'slug' => 'list-tags',
                'group' => 'tags',
            ],
            [
                'title' => 'Create Tags',
                'slug' => 'create-tags',
                'group' => 'tags',
            ],
            [
                'title' => 'Store Tags',
                'slug' => 'store-tags',
                'group' => 'tags',
            ],
            [
                'title' => 'Edit Tags',
                'slug' => 'edit-tags',
                'group' => 'tags',
            ],
            [
                'title' => 'Update Tags',
                'slug' => 'update-tags',
                'group' => 'tags',
            ],
            [
                'title' => 'Destroy Tags',
                'slug' => 'destroy-tags',
                'group' => 'tags',
            ],
            /** media */
            [
                'title' => 'List Media',
                'slug' => 'list-media',
                'group' => 'media',
            ],
            [
                'title' => 'Store Media',
                'slug' => 'store-media',
                'group' => 'media',
            ],
            /** users */
            [
                'title' => 'List Users',
                'slug' => 'list-users',
                'group' => 'users',
            ],
            [
                'title' => 'Create Users',
                'slug' => 'create-users',
                'group' => 'users',
            ],
            [
                'title' => 'Store Users',
                'slug' => 'store-users',
                'group' => 'users',
            ],
            [
                'title' => 'Edit Users',
                'slug' => 'edit-users',
                'group' => 'users',
            ],
            [
                'title' => 'Update Users',
                'slug' => 'update-users',
                'group' => 'users',
            ],
            [
                'title' => 'Destroy Users',
                'slug' => 'destroy-users',
                'group' => 'users',
            ],
            /** roles */
            [
                'title' => 'List Roles',
                'slug' => 'list-roles',
                'group' => 'roles',
            ],
            [
                'title' => 'Create Roles',
                'slug' => 'create-roles',
                'group' => 'roles',
            ],
            [
                'title' => 'Store Roles',
                'slug' => 'store-roles',
                'group' => 'roles',
            ],
            [
                'title' => 'Edit Roles',
                'slug' => 'edit-roles',
                'group' => 'roles',
            ],
            [
                'title' => 'Update Roles',
                'slug' => 'update-roles',
                'group' => 'roles',
            ],
            [
                'title' => 'Destroy Roles',
                'slug' => 'destroy-roles',
                'group' => 'roles',
            ],
            /** permissions */
            [
                'title' => 'List Permissions',
                'slug' => 'list-permissions',
                'group' => 'permissions',
            ],
            [
                'title' => 'Create Permissions',
                'slug' => 'create-permissions',
                'group' => 'permissions',
            ],
            [
                'title' => 'Store Permissions',
                'slug' => 'store-permissions',
                'group' => 'permissions',
            ],
            [
                'title' => 'Edit Permissions',
                'slug' => 'edit-permissions',
                'group' => 'permissions',
            ],
            [
                'title' => 'Update Permissions',
                'slug' => 'update-permissions',
                'group' => 'permissions',
            ],
            [
                'title' => 'Destroy Permissions',
                'slug' => 'destroy-permissions',
                'group' => 'permissions',
            ],
            /** settings */
            [
                'title' => 'List Settings',
                'slug' => 'list-settings',
                'group' => 'settings',
            ],
            [
                'title' => 'Store Settings',
                'slug' => 'store-settings',
                'group' => 'settings',
            ],
        ];

        Permission::insert($data);
    }
}
