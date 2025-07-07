<?php
/**
 * Extension Manager/Repository config file for ext "accesstive".
 *
 * Description: Accesstive is an all-in-one accessibility platform that helps websites become inclusive, compliant, and user-friendly. It combines powerful tools like an accessibility assistant widget, AI-based live audits, monitoring, and an intelligent assistant.
 * Author: Accesstive
 * License: GPLv2 or later
 * Version: 1.0.0
 * Created: 2024
 * Package: accesstive
 * Changelog: Initial release with backend module and widget integration
 * Notes: Compatible with TYPO3 v10+
 */

$EM_CONF['accesstive'] = [
    'title' => 'Accesstive',
    'description' => 'Accesstive is an all-in-one accessibility platform that helps websites become inclusive, compliant, and user-friendly. It combines powerful tools like an accessibility assistant widget, AI-based live audits, monitoring, and an intelligent assistant. Designed for businesses, developers, and agencies—Accesstive makes accessibility simple, scalable, and smart.',
    'category' => 'fe',
    'author' => 'Accesstive',
    'author_email' => 'support@accesstive.com',
    'author_company' => 'Accesstive',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-13.4.99',
            'php' => '7.4.0-8.3.99'
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => [
            'Accesstive\\Accesstive\\' => 'Classes/'
        ]
    ],
]; 