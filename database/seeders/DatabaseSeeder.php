<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Roles ───────────────────────────────────────────────
        $admin  = Role::create(['name' => 'admin',  'label' => 'Administrador', 'description' => 'Acesso total ao sistema']);
        $editor = Role::create(['name' => 'editor', 'label' => 'Editor',        'description' => 'Criar e editar artigos']);
        $viewer = Role::create(['name' => 'viewer', 'label' => 'Leitor',        'description' => 'Somente leitura']);

        // ─── Groups ──────────────────────────────────────────────
        $devops  = Group::create(['name' => 'devops',      'label' => 'DevOps',         'color' => '#6366f1', 'description' => 'Infraestrutura, CI/CD, Segurança']);
        $dev     = Group::create(['name' => 'dev',         'label' => 'Desenvolvimento', 'color' => '#0ea5e9', 'description' => 'Projetos e aplicações']);
        $gestao  = Group::create(['name' => 'gestao',      'label' => 'Gestão',          'color' => '#f59e0b', 'description' => 'Processos e estimativas']);
        $ti      = Group::create(['name' => 'ti',          'label' => 'TI Geral',        'color' => '#10b981', 'description' => 'Ferramentas e ambiente']);

        // ─── Tags padrão ─────────────────────────────────────────
        $tags = [
            ['name' => 'Docker',      'slug' => 'docker',      'color' => '#0ea5e9'],
            ['name' => 'Laravel',     'slug' => 'laravel',     'color' => '#ef4444'],
            ['name' => 'Linux',       'slug' => 'linux',       'color' => '#f59e0b'],
            ['name' => 'Segurança',   'slug' => 'seguranca',   'color' => '#ef4444'],
            ['name' => 'CI/CD',       'slug' => 'ci-cd',       'color' => '#8b5cf6'],
            ['name' => 'MySQL',       'slug' => 'mysql',       'color' => '#0ea5e9'],
            ['name' => 'Redis',       'slug' => 'redis',       'color' => '#ef4444'],
            ['name' => 'Nginx',       'slug' => 'nginx',       'color' => '#10b981'],
            ['name' => 'GCP',         'slug' => 'gcp',         'color' => '#f59e0b'],
            ['name' => 'Bitbucket',   'slug' => 'bitbucket',   'color' => '#0ea5e9'],
            ['name' => 'Incidente',   'slug' => 'incidente',   'color' => '#ef4444'],
            ['name' => 'Runbook',     'slug' => 'runbook',     'color' => '#10b981'],
        ];
        foreach ($tags as $tag) Tag::create($tag);

        // ─── Usuário admin ────────────────────────────────────────
        $user = User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@devops-wiki.local',
            'password' => Hash::make('Admin@2026!'),
            'role_id'  => $admin->id,
            'active'   => true,
        ]);

        // Admin pertence a todos os grupos
        $user->groups()->attach([$devops->id, $dev->id, $gestao->id, $ti->id]);

        $this->command->info('✅ Seed concluído!');
        $this->command->info('   Login: admin@devops-wiki.local');
        $this->command->info('   Senha: Admin@2026!');
    }
}
