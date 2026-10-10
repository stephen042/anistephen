<?php
// Editable profile content: about, capabilities, product experience, technical stack, education.
// Experience is presented as products built, not employment history.

return [
    'about' => [
        'heading' => 'Building Software Around Real Business Problems',
        'paragraphs' => [
            'I’m a software developer focused on building practical software for businesses, startups and organizations.',
            'Over the years, I’ve worked on e-commerce platforms, marketplaces, school management systems, attendance platforms and custom business applications. My approach is to understand how the business needs to work first, then build the software around those processes.',
            'I’m particularly interested in products that need to grow — where the software has to support more users, more data, more transactions and more business operations over time.',
        ],
    ],

    // "I Build More Than Websites" capability blocks on the homepage.
    'capabilities' => [
        'heading'     => 'I Build More Than Websites',
        'intro'       => 'I build software around real business operations — systems that teams use every day to serve customers, handle transactions and run the business.',
        'items'       => [
            ['title' => 'Business Software', 'text' => 'Systems designed around real business processes and operational needs.'],
            ['title' => 'SaaS Platforms', 'text' => 'Multi-user applications designed to support growing organizations and businesses.'],
            ['title' => 'E-commerce & Marketplaces', 'text' => 'Commerce platforms, seller systems, orders, checkout and marketplace workflows.'],
            ['title' => 'APIs & Integrations', 'text' => 'Backend systems, REST APIs and integrations that connect applications and services.'],
        ],
    ],

    // Product-based experience. Not employers — products built and developed.
    'product_experience' => [
        'intro' => "I don't just write code. I build software products around real business operations, from early requirements through development, deployment and continued improvement.",
        'items' => [
            [
                'title'    => 'BestSchoolPage',
                'subtitle' => 'School Management / Education Technology',
                'text'     => 'Built and continuously developed a school management platform covering students, teachers, attendance, fees, results, certificates and reporting.',
                'status'   => 'Active',
                'slug'     => 'bestschoolpage',
            ],
            [
                'title'    => 'Nujora',
                'subtitle' => 'Multi-Vendor E-commerce Marketplace',
                'text'     => 'Built and developed marketplace functionality including product management, categories, customer accounts, orders and seller-oriented commerce workflows.',
                'status'   => 'Active',
                'slug'     => 'nujora',
            ],
            [
                'title'    => 'FPN Smart Attendance System',
                'subtitle' => 'Education / Attendance Technology',
                'text'     => 'Built a smart attendance platform combining identification, device verification and location/network verification.',
                'status'   => 'Active',
                'slug'     => 'fpn-smart-attendance',
            ],
            [
                'title'    => 'SettleCart',
                'subtitle' => 'Multi-Vendor Commerce / Dispatch',
                'text'     => 'Built commerce workflows around multiple stores, checkout, payment, vendor operations, dispatch and settlement.',
                'status'   => 'Active / In development',
                'slug'     => 'settlecart',
            ],
            [
                'title'    => 'Buy2055 Originals',
                'subtitle' => 'E-commerce',
                'text'     => 'Built the customer-facing e-commerce storefront and supporting commerce functionality.',
                'status'   => 'Active',
                'slug'     => 'buy2055-originals',
            ],
        ],
    ],

    // Compact technical stack, grouped. No percentages.
    'tech_groups' => [
        [
            'title' => 'Languages',
            'items' => ['PHP', 'JavaScript', 'SQL', "Go Lang"],
        ],
        [
            'title' => 'Backend',
            'items' => ['Laravel', 'REST APIs', 'MySQL', "Go Lang"],
        ],
        [
            'title' => 'Frontend',
            'items' => ['Vue.js', 'Livewire', 'Blade', 'Tailwind CSS'],
        ],
        [
            'title' => 'Tools & Infrastructure',
            'items' => ['Git', 'Docker', 'Queues', 'Jobs', 'Notifications', 'Authentication', 'Authorization'],
        ],
    ],

    'education' => [
        [
            'title'       => 'HND — Computer Science / Software & Web Development',
            'school'      => 'Federal Polytechnic Nekede, Imo State, Nigeria',
            // Leave empty if you prefer not to show dates.
            'date'        => '',
            'description' => '',
        ],
    ],
];
