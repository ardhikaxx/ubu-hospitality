<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $superAdminRole = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Administrator', 'description' => 'Full administrative access', 'is_system' => true]
        );

        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator', 'description' => 'Operational and content administrator', 'is_system' => true]
        );

        $editorRole = Role::firstOrCreate(
            ['slug' => 'editor'],
            ['name' => 'Content Editor', 'description' => 'Can manage blog, pages, promos, and media', 'is_system' => false]
        );

        $staffRole = Role::firstOrCreate(
            ['slug' => 'staff'],
            ['name' => 'Operations Staff', 'description' => 'Can view and handle partnership leads and reviews', 'is_system' => false]
        );

        // 2. Permissions
        $permissions = [
            // Brands & Properties
            ['slug' => 'brands.manage', 'name' => 'Manage Brands', 'group' => 'Hospitality'],
            ['slug' => 'properties.manage', 'name' => 'Manage Properties', 'group' => 'Hospitality'],
            ['slug' => 'amenities.manage', 'name' => 'Manage Amenities', 'group' => 'Hospitality'],

            // Marketing & Content
            ['slug' => 'promotions.manage', 'name' => 'Manage Promotions', 'group' => 'Marketing'],
            ['slug' => 'experiences.manage', 'name' => 'Manage Experiences', 'group' => 'Marketing'],
            ['slug' => 'blog.manage', 'name' => 'Manage Blog Articles', 'group' => 'Content'],
            ['slug' => 'pages.manage', 'name' => 'Manage Static Pages & Sections', 'group' => 'Content'],
            ['slug' => 'navigations.manage', 'name' => 'Manage Header & Footer Menus', 'group' => 'Content'],
            ['slug' => 'media.manage', 'name' => 'Manage Media Files', 'group' => 'Content'],
            ['slug' => 'reviews.manage', 'name' => 'Manage Guest Reviews', 'group' => 'Content'],

            // Business & Operations
            ['slug' => 'partnerships.manage', 'name' => 'Manage Partnership Leads', 'group' => 'Operations'],
            ['slug' => 'partnerships.export', 'name' => 'Export Partnership Leads', 'group' => 'Operations'],

            // System & SEO
            ['slug' => 'seo.manage', 'name' => 'Manage SEO & 301 Redirects', 'group' => 'System'],
            ['slug' => 'settings.manage', 'name' => 'Manage Website Settings', 'group' => 'System'],
            ['slug' => 'users.manage', 'name' => 'Manage Admin Users & Roles', 'group' => 'System'],
            ['slug' => 'audit.view', 'name' => 'View Audit Logs', 'group' => 'System'],
        ];

        $permissionIds = [];
        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
            $permissionIds[] = $permission->id;
        }

        // Attach all to Super Admin and Admin
        $superAdminRole->permissions()->sync($permissionIds);
        $adminRole->permissions()->sync($permissionIds);

        // Editor permissions
        $editorPerms = Permission::whereIn('slug', [
            'brands.manage', 'properties.manage', 'amenities.manage',
            'promotions.manage', 'experiences.manage', 'blog.manage',
            'pages.manage', 'navigations.manage', 'media.manage', 'reviews.manage', 'seo.manage',
        ])->pluck('id')->toArray();
        $editorRole->permissions()->sync($editorPerms);

        // Staff permissions
        $staffPerms = Permission::whereIn('slug', [
            'partnerships.manage', 'reviews.manage',
        ])->pluck('id')->toArray();
        $staffRole->permissions()->sync($staffPerms);

        // 3. Create Default Super Admin User
        User::firstOrCreate(
            ['email' => 'admin@ubuhospitality.com'],
            [
                'name' => 'Super Administrator Ubu',
                'password' => Hash::make('AdminUbu2026!'),
                'role_id' => $superAdminRole->id,
                'phone' => '+6281234567890',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Demo Editor User
        User::firstOrCreate(
            ['email' => 'editor@ubuhospitality.com'],
            [
                'name' => 'Content Editor Ubu',
                'password' => Hash::make('EditorUbu2026!'),
                'role_id' => $editorRole->id,
                'phone' => '+6281234567891',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
