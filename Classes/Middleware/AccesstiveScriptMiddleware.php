<?php

namespace Accesstive\Accesstive\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;

/**
 * Accesstive Script Injection Middleware
 *
 * Description: Injects Accesstive assistant script before closing body tag using PSR-15 middleware
 * Author: Accesstive
 * License: GPLv2 or later
 * Version: 1.0.0
 * Created: 2024
 * Package: accesstive
 * Changelog: Converted from hook-based to PSR-15 middleware approach
 * Notes: Uses TYPO3 PSR-15 middleware system for reliable script injection
 */
class AccesstiveScriptMiddleware implements MiddlewareInterface
{
    /**
     * Process the request and inject Accesstive script
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Get the response from the handler
        $response = $handler->handle($request);
        
        // Only process HTML responses
        if (!$this->isHtmlResponse($response)) {
            return $response;
        }
        
        // Get the response body
        $body = (string) $response->getBody();
        // Get data token details from settings using site sets
        $site = $request->getAttribute('site');
+       $dataToken = '';
+        if ($site !== null && method_exists($site, 'getSettings')) {
+            $dataToken = $site->getSettings()->get('accesstive.dataToken', '');
+        }

        if (empty($dataToken)) {
            $frontendTypoScript = $request->getAttribute('frontend.typoscript');
            if ($frontendTypoScript) {
                $setup = $frontendTypoScript->getSetupArray();
                // Match the path from your setup.typoscript
                $dataToken = $setup['plugin.']['tx_accesstive.']['settings.']['datatoken'] ?? '';
            }
        }
        // Inject the Accesstive script before closing body tag
        if(!empty($dataToken)){
            $script = '<script async src="https://cdn.accesstive.com/assistance.js" type="module" data-token="' . htmlspecialchars($dataToken) . '"></script>';
        }else{
            $script = '<script async src="https://cdn.accesstive.com/assistance.js" type="module"></script>';    
        }
        
        $closeTag = '</body>';
+       $pos = strripos($body, $closeTag);
+       if ($pos !== false) {
+            $modifiedBody = substr($body, 0, $pos) . $script . substr($body, $pos);
+       }else {
+            $modifiedBody = $body . $script;
+       }
        
        // Create new response with modified body
        return new HtmlResponse($modifiedBody, $response->getStatusCode(), $response->getHeaders());
    }
    
    /**
     * Check if the response is an HTML response
     *
     * @param ResponseInterface $response
     * @return bool
     */
    private function isHtmlResponse(ResponseInterface $response): bool
    {
        $contentType = $response->getHeaderLine('Content-Type');
        return strpos($contentType, 'text/html') !== false;
    }
} 
