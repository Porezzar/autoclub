<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncWheelProductImages extends Command
{
    protected $signature = 'products:sync-wheel-images';

    protected $description = 'Download real wheel photos from retailer/manufacturer sites';

    /**
     * Product name => remote image URL (verified against catalog models).
     *
     * @var array<string, array{url: string, local: string, source: string}>
     */
    private const MAP = [
        'BBS CH-R 18×8.5 ET35 5×112' => [
            'url' => 'https://www.lkperformance.co.uk/media/ProductImage/2585/image/resized/large.jpg',
            'local' => 'disk-bbs-ch-r.png',
            'source' => 'lkperformance.co.uk',
        ],
        'OZ Racing Ultraleggera 17×7 ET45 5×114.3' => [
            'url' => 'https://s1.shinservice.ru/catalog/disk/oz/huge/Ultraleggera.s.jpg',
            'local' => 'disk-oz-ultraleggera.png',
            'source' => 'shinservice.ru',
        ],
        'Replica Audi A5 18×8 ET35 5×112' => [
            'url' => 'https://mosautoshina.ru/i/wheel/replica/audi-a38.jpg',
            'local' => 'disk-replica-audi.png',
            'source' => 'mosautoshina.ru (Replica A38, Audi)',
        ],
        'MAK Fahr 19×8 ET40 5×112' => [
            'url' => 'https://mosautoshina.ru/i/wheel/mak-fahr-max.jpg',
            'local' => 'disk-mak-fahr.png',
            'source' => 'mosautoshina.ru',
        ],
        'Kosei K1 Racing 16×6.5 ET45 4×100' => [
            'url' => 'https://mosautoshina.ru/i/wheel/kosei-k1-racing-max.jpg',
            'local' => 'disk-kosei-k1.png',
            'source' => 'mosautoshina.ru',
        ],
        'Dezent RE Dark 17×7 ET48 5×108' => [
            'url' => 'https://s1.shinservice.ru/catalog/disk/dezent/huge/RE.s.jpg',
            'local' => 'disk-dezent-re.png',
            'source' => 'shinservice.ru',
        ],
        'Trebl 90533 16×6.5 ET40 4×100' => [
            'url' => 'https://mosautoshina.ru/i/wheel/trebl-9053-max.jpg',
            'local' => 'disk-steel-trebl.png',
            'source' => 'mosautoshina.ru (Trebl 9053)',
        ],
        'Magnetto 15003 15×6 ET43 4×100' => [
            'url' => 'https://s1.shinservice.ru/catalog/disk/magnetto/huge/15003.s.jpg',
            'local' => 'disk-steel-magnetto.png',
            'source' => 'shinservice.ru',
        ],
        'Next NX-063 16×6.5 ET50 5×114.3' => [
            'url' => 'https://mosautoshina.ru/i/wheel/next-nx-063-max.jpg',
            'local' => 'disk-steel-next.png',
            'source' => 'mosautoshina.ru',
        ],
        'iFree KH-131 17×7 ET39 5×108' => [
            'url' => 'https://s1.shinservice.ru/catalog/disk/ifree/huge/Benks.s.jpg',
            'local' => 'disk-steel-ifree.png',
            'source' => 'shinservice.ru (iFree Бэнкс)',
        ],
        'Arrivo AR919 14×5.5 ET43 4×100' => [
            'url' => 'https://mosautoshina.ru/i/wheel/arrivo-ar01512p-max.jpg',
            'local' => 'disk-steel-arrivo.png',
            'source' => 'mosautoshina.ru (Arrivo AR015)',
        ],
        'Eurodisk 10015 15×6 ET28 5×139.7' => [
            'url' => 'https://atww.ru/upload/iblock/ba3/17ddma602mjdq7k0ofbgz8vrtf642wvk.webp',
            'local' => 'disk-steel-eurodisk.png',
            'source' => 'atww.ru (Eurodisk 15006 5×139.7)',
        ],
        'Rays Volk TE37 18×9.5 ET22 5×114.3' => [
            'url' => 'https://image.nengun.com/catalogue/500x375/nengun-9963-0000-10-rays-volk_racing_te37_wheel-f07d4441.jpg',
            'local' => 'disk-forged-te37.png',
            'source' => 'nengun.com',
        ],
        'BBS FI-R 19×8.5 ET32 5×112' => [
            'url' => 'https://www.systemmotorsports.com/cdn/shop/products/BBS_FIR_1024x1024.png?v=1575679754',
            'local' => 'disk-forged-bbs-fi.png',
            'source' => 'systemmotorsports.com',
        ],
        'Work Emotion ZR10 18×8 ET38 5×114.3' => [
            'url' => 'https://mosautoshina.ru/i/wheel/work-emotion-xt-7-max.jpg',
            'local' => 'disk-forged-work.png',
            'source' => 'mosautoshina.ru (Work Emotion XT-7)',
        ],
        'HRE P101 20×9 ET25 5×112' => [
            'url' => 'https://s3.amazonaws.com/cdn.hrewheels.com/img/wheel-original/137764070426c54b10fac91b060845fab004a557d2.png',
            'local' => 'disk-forged-hre.png',
            'source' => 'hrewheels.com',
        ],
        'ADV.1 ADV005 19×8.5 ET35 5×120' => [
            'url' => 'https://motorsportsla.com/cdn/shop/products/adv.1-ADV005-Track-Spec-Advanced-Series-05.jpg?v=1602066580',
            'local' => 'disk-forged-adv1.png',
            'source' => 'motorsportsla.com',
        ],
        'Rotiform BUC 18×8.5 ET45 5×112' => [
            'url' => 'https://cdn.vividracing.com/file/vr23/680/1/BUC-FORGED-MONO_11.webp',
            'local' => 'disk-forged-rotiform.png',
            'source' => 'vividracing.com',
        ],
    ];

    public function handle(ProductImageService $images): int
    {
        $dir = $images->directory();
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach (Product::whereHas('category', fn ($q) => $q->where('group', 'diski'))->get() as $product) {
            $mapping = self::MAP[$product->name] ?? null;
            if (! $mapping) {
                $this->warn("No image mapping: {$product->name}");
                continue;
            }

            $baseName = pathinfo($mapping['local'], PATHINFO_FILENAME);
            $downloadExt = strtolower(pathinfo(parse_url($mapping['url'], PHP_URL_PATH) ?? '', PATHINFO_EXTENSION)) ?: 'jpg';
            if ($downloadExt === 'jpeg') {
                $downloadExt = 'jpg';
            }
            $downloadPath = $dir.DIRECTORY_SEPARATOR.$baseName.'-dl.'.$downloadExt;

            $this->info("Downloading: {$product->name} ← {$mapping['source']}");

            $response = Http::timeout(45)
                ->withOptions(['verify' => false])
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; AutoclubCatalog/1.0)'])
                ->get($mapping['url']);

            if (! $response->successful()) {
                $this->error("HTTP {$response->status()}: {$mapping['url']}");
                continue;
            }

            file_put_contents($downloadPath, $response->body());

            $mapping['local'] = $this->finalizeWheelImage($images, $downloadPath, $baseName);

            $svgPath = $dir.DIRECTORY_SEPARATOR.pathinfo($mapping['local'], PATHINFO_FILENAME).'.svg';
            if (is_file($svgPath)) {
                unlink($svgPath);
            }

            $product->update(['image' => $mapping['local']]);
            $this->info("OK: {$mapping['local']}");
        }

        $this->info('Wheel product images synced.');

        return self::SUCCESS;
    }

    private function finalizeWheelImage(ProductImageService $images, string $downloadPath, string $baseName): string
    {
        $dir = dirname($downloadPath);
        $downloadExt = strtolower(pathinfo($downloadPath, PATHINFO_EXTENSION));
        $pngLocal = $baseName.'.png';
        $pngPath = $dir.DIRECTORY_SEPARATOR.$pngLocal;

        if (! $images->canProcessImages()) {
            return $this->storeUnprocessedWheel($downloadPath, $baseName, $downloadExt);
        }

        $shouldProcess = $downloadExt === 'webp' || $images->needsBackgroundRemoval($downloadPath);
        $dimensions = @getimagesize($downloadPath);
        if ($shouldProcess && $dimensions && max($dimensions[0], $dimensions[1]) < 520) {
            $shouldProcess = false;
        }

        if (! $shouldProcess) {
            return $this->storeUnprocessedWheel($downloadPath, $baseName, $downloadExt);
        }

        $tempPath = $pngPath.'.tmp';

        if (! $images->processFile($downloadPath, $tempPath, $downloadExt === 'webp') || ! is_file($tempPath)) {
            @unlink($tempPath);

            return $this->storeUnprocessedWheel($downloadPath, $baseName, $downloadExt);
        }

        if (is_file($pngPath)) {
            unlink($pngPath);
        }
        rename($tempPath, $pngPath);
        $this->removeStaleWheelFiles($dir, $baseName, $pngLocal);

        if (is_file($downloadPath)) {
            unlink($downloadPath);
        }

        return $pngLocal;
    }

    private function storeUnprocessedWheel(string $downloadPath, string $baseName, string $downloadExt): string
    {
        $dir = dirname($downloadPath);
        $finalName = $baseName.'.'.$downloadExt;
        $finalPath = $dir.DIRECTORY_SEPARATOR.$finalName;

        if ($downloadPath !== $finalPath) {
            if (is_file($finalPath)) {
                unlink($finalPath);
            }
            rename($downloadPath, $finalPath);
        }

        $this->removeStaleWheelFiles($dir, $baseName, $finalName);

        return $finalName;
    }

    private function removeStaleWheelFiles(string $dir, string $baseName, string $keepName): void
    {
        foreach (['png', 'jpg', 'jpeg', 'webp'] as $ext) {
            $candidate = $baseName.'.'.$ext;
            if ($candidate !== $keepName) {
                $path = $dir.DIRECTORY_SEPARATOR.$candidate;
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }

        foreach (glob($dir.DIRECTORY_SEPARATOR.$baseName.'-dl.*') ?: [] as $tempFile) {
            if (is_file($tempFile)) {
                unlink($tempFile);
            }
        }
    }
}
