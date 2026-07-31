<?php

namespace App\Http\Controllers;

use App\SitePageVisit;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ResumeController extends Controller
{
    private const PUBLIC_FILENAME = 'evgeniy-ampleev-resume-ru.pdf';

    public function show(Request $request): BinaryFileResponse
    {
        return $this->pdfResponse($request, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    public function download(Request $request): BinaryFileResponse
    {
        $response = $this->pdfResponse($request, ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        if ($request->isMethod('get') && $response->getStatusCode() === 200) {
            $this->recordDownload($request);
        }

        return $response;
    }

    private function pdfResponse(Request $request, string $disposition): BinaryFileResponse
    {
        $path = resource_path('documents/' . self::PUBLIC_FILENAME);
        abort_unless(is_file($path), 404);

        $response = response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'public, max-age=3600, must-revalidate',
            'X-Content-Type-Options' => 'nosniff',
        ]);
        $response->setContentDisposition($disposition, self::PUBLIC_FILENAME);
        $response->setEtag((string) hash_file('sha256', $path));
        $response->setLastModified((new DateTimeImmutable())->setTimestamp((int) filemtime($path)));
        $response->isNotModified($request);

        return $response;
    }

    private function recordDownload(Request $request): void
    {
        $referer = (string) $request->headers->get('referer');
        $refererPath = parse_url($referer, PHP_URL_PATH);
        $fromAboutPage = is_string($refererPath)
            && in_array(rtrim($refererPath, '/'), ['/about_me', '/en/about_me'], true);
        $source = $fromAboutPage ? 'about_me' : 'direct';

        try {
            SitePageVisit::create([
                'event_name' => 'about_resume_download',
                'page_url' => url('/resume/download'),
                'page_path' => '/resume/download',
                'locale' => $refererPath === '/en/about_me' ? 'en' : 'ru',
                'request_host' => $request->getHost(),
                'request_scheme' => $request->getScheme(),
                'request_referer' => $referer ?: null,
                'request_referer_host' => $referer ? parse_url($referer, PHP_URL_HOST) : null,
                'request_referer_path' => is_string($refererPath) ? $refererPath : null,
                'user_agent' => $request->userAgent(),
                'accept_language' => $request->headers->get('accept-language'),
                'server_payload' => json_encode([
                    'event_name' => 'about_resume_download',
                    'source' => $source,
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Could not record résumé download analytics.', [
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
