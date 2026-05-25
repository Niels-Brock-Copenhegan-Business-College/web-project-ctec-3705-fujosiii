<?php
/**
 * This file is part of the Student Course Hub project.
 */
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class InitialDataSeeder extends AbstractSeed
{
    public function run(): void
    {
        // ── Admin user ────────────────────────────────────────────────────────
        $this->table('admins')->insert([
            [
                'name'     => 'Admin User',
                'email'    => 'admin@university.ac.uk',
                'password' => password_hash('Admin1234!', PASSWORD_BCRYPT),
                'role'     => 'admin',
            ],
        ])->saveData();

        // ── Staff ─────────────────────────────────────────────────────────────
        $this->table('staff')->insert([
            ['name' => 'Dr. Sarah Mitchell', 'email' => 's.mitchell@university.ac.uk', 'title' => 'Programme Leader, Computer Science'],
            ['name' => 'Prof. James Okafor',  'email' => 'j.okafor@university.ac.uk',  'title' => 'Professor of Cyber Security'],
            ['name' => 'Dr. Priya Patel',     'email' => 'p.patel@university.ac.uk',   'title' => 'Lecturer in Software Engineering'],
            ['name' => 'Dr. Tom Hughes',      'email' => 't.hughes@university.ac.uk',  'title' => 'Programme Leader, Data Science'],
        ])->saveData();

        // ── Programmes ────────────────────────────────────────────────────────
        $this->table('programmes')->insert([
            [
                'title'          => 'BSc Computer Science',
                'slug'           => 'bsc-computer-science',
                'level'          => 'Undergraduate',
                'description'    => 'A comprehensive foundation in computer science covering algorithms, programming, databases, and software engineering.',
                'duration_years' => 3,
                'ucas_code'      => 'G400',
                'is_published'   => 1,
                'leader_id'      => 1,
            ],
            [
                'title'          => 'MSc Cyber Security',
                'slug'           => 'msc-cyber-security',
                'level'          => 'Postgraduate',
                'description'    => 'An advanced programme covering network security, ethical hacking, cryptography and digital forensics.',
                'duration_years' => 1,
                'ucas_code'      => null,
                'is_published'   => 1,
                'leader_id'      => 2,
            ],
            [
                'title'          => 'MSc Data Science',
                'slug'           => 'msc-data-science',
                'level'          => 'Postgraduate',
                'description'    => 'Develop expertise in machine learning, statistical modelling, and big data technologies.',
                'duration_years' => 1,
                'ucas_code'      => null,
                'is_published'   => 1,
                'leader_id'      => 4,
            ],
        ])->saveData();

        // ── Modules ───────────────────────────────────────────────────────────
        $this->table('modules')->insert([
            ['title' => 'Programming Fundamentals',   'code' => 'CS101', 'credits' => 20, 'leader_id' => 3],
            ['title' => 'Data Structures & Algorithms','code' => 'CS102', 'credits' => 20, 'leader_id' => 3],
            ['title' => 'Database Systems',            'code' => 'CS201', 'credits' => 20, 'leader_id' => 1],
            ['title' => 'Web Development',             'code' => 'CS202', 'credits' => 20, 'leader_id' => 3],
            ['title' => 'Network Security',            'code' => 'CY301', 'credits' => 20, 'leader_id' => 2],
            ['title' => 'Ethical Hacking',             'code' => 'CY302', 'credits' => 20, 'leader_id' => 2],
            ['title' => 'Machine Learning',            'code' => 'DS301', 'credits' => 20, 'leader_id' => 4],
            ['title' => 'Statistical Modelling',       'code' => 'DS302', 'credits' => 20, 'leader_id' => 4],
        ])->saveData();

        // ── Programme Modules ─────────────────────────────────────────────────
        $this->table('programme_modules')->insert([
            // BSc CS - Year 1
            ['programme_id' => 1, 'module_id' => 1, 'year' => 1, 'sort_order' => 0],
            ['programme_id' => 1, 'module_id' => 2, 'year' => 1, 'sort_order' => 1],
            // BSc CS - Year 2
            ['programme_id' => 1, 'module_id' => 3, 'year' => 2, 'sort_order' => 0],
            ['programme_id' => 1, 'module_id' => 4, 'year' => 2, 'sort_order' => 1],
            // MSc Cyber Security
            ['programme_id' => 2, 'module_id' => 5, 'year' => 1, 'sort_order' => 0],
            ['programme_id' => 2, 'module_id' => 6, 'year' => 1, 'sort_order' => 1],
            // MSc Data Science (shares CS201)
            ['programme_id' => 3, 'module_id' => 3, 'year' => 1, 'sort_order' => 0],
            ['programme_id' => 3, 'module_id' => 7, 'year' => 1, 'sort_order' => 1],
            ['programme_id' => 3, 'module_id' => 8, 'year' => 1, 'sort_order' => 2],
        ])->saveData();
    }
}
