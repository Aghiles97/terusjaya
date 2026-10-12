<?php

namespace App\Controllers;

class FeedController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Generate the dynamic PWA (Progressive Web App) manifest
     */
    public function manifest()
    {
        $langCode = inputGet('lang');

        $language = model('LanguageModel')->getLanguageByShortForm($langCode);
        if (empty($language)) {
            $language = $this->activeLang;
        }

        $baseUrl = generateBaseURLByLangId($language->id);
        $appScope = rtrim(base_url(), '/') . '/';
        $settings = model('SettingsModel')->getSettings($language->id);

        $appName = $this->generalSettings->application_name ?? 'Modesy';
        $siteDescription = $settings->site_description ?? '';

        $manifest = [
            'id'               => $appScope,
            'dir'              => ($language->text_direction ?? 'ltr') === 'rtl' ? 'rtl' : 'ltr',
            'lang'             => $language->short_form,
            'name'             => $appName,
            'short_name'       => $appName,
            'description'      => $siteDescription,
            'icons'            => [
                [
                    'src'     => getAppIcon(144),
                    'sizes'   => '144x144',
                    'type'    => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src'     => getAppIcon(192),
                    'sizes'   => '192x192',
                    'type'    => 'image/png',
                    'purpose' => 'any'
                ],
                [
                    'src'     => getAppIcon(512),
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'any'
                ]
            ],
            'scope'            => $appScope,
            'start_url'        => $baseUrl,
            'display'          => 'standalone',
            'orientation'      => 'any',
            'theme_color'      => '#FFFFFF',
            'background_color' => '#FFFFFF'
        ];

        return $this->response
            ->setJSON($manifest)
            ->setContentType('application/manifest+json');
    }
}
