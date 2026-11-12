<?php

/*
 * Company details used across the site (header, footer, contact section).
 * Source: Kafue Group Company Profile 2026.
 */
return [
    'name' => 'Kafue Group',
    'legal_name' => 'Kafue Group (Pty) Ltd',
    'enterprise_name' => 'KAFUE GROUP',
    'registration' => '2026/873079/07', // enterprise number
    'tagline' => 'Industrial sourcing and supply for mining, construction and infrastructure.',
    'description' => 'Kafue Group sources and supplies materials and equipment for mining operations, construction contractors and major infrastructure projects across Africa.',

    'address' => [
        'street' => '15 South Ridge',
        'city' => 'Kimberley',
        'region' => 'Northern Cape',
        'postcode' => '8301',
        'country' => 'South Africa',
    ],

    // Main navigation: label => route name (max four pages; the logo links home).
    'nav' => [
        ['label' => 'Products', 'route' => 'products'],
        ['label' => 'Services', 'route' => 'services'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Contact', 'route' => 'contact'],
    ],

    /*
     * Where quote request notifications go. Leave the addresses empty (in .env) until they are confirmed:
     * requests are still saved to the database, and no email is sent.
     *   MAIL_SALES_TO=sales@yourdomain
     *   MAIL_TOOLS_TO=tools@yourdomain   (optional; tools requests fall back to sales when unset)
     */
    'mail' => [
        'sales' => env('MAIL_SALES_TO'),
        'tools' => env('MAIL_TOOLS_TO'),
        'tools_categories' => ['Tools and equipment'],
    ],

    // Quote attachment limits
    'attachments' => [
        'max_kb' => 10240, // 10 MB
        'types' => ['pdf', 'xls', 'xlsx', 'csv', 'doc', 'docx', 'png', 'jpg', 'jpeg'],
    ],

    'email' => 'info@kafuegroup.co.za',
    'phone' => '+27 60 204 6268',
    'phone_href' => 'tel:+27602046268',
];
