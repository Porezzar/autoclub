<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncProductImages extends Command
{
    protected $signature = 'products:sync-images';

    protected $description = 'Download official tire photos and update the database';

    private const BASE = 'https://www.tyrereviews.com/public/tyres';

    /** @var array<string, array{remote: string, local: string}> */
    private const MAP = [
        'Michelin Primacy 4 205/55 R16' => ['remote' => 'Michelin-Primacy-4.png', 'local' => 'michelin-primacy-4.png'],
        'Bridgestone Turanza T005 225/45 R17' => ['remote' => 'Bridgestone-Turanza-T005.png', 'local' => 'bridgestone-turanza-t005.png'],
        'Continental PremiumContact 6 195/65 R15' => ['remote' => 'Continental-Premium-Contact-6.png', 'local' => 'continental-premiumcontact-6.png'],
        'Yokohama BluEarth-GT AE51 215/55 R17' => ['remote' => 'Yokohama-BluEarth-GT-AE51.png', 'local' => 'yokohama-bluerth-gt-ae51.png'],
        'Pirelli Cinturato P7 205/50 R17' => ['remote' => 'Pirelli-Cinturato-P7-C2.png', 'local' => 'pirelli-cinturato-p7.png'],
        'Hankook Ventus Prime4 K135 225/40 R18' => ['remote' => 'Hankook-Ventus-Prime-4.png', 'local' => 'hankook-ventus-prime4-k135.png'],
        'Nokian Hakkapeliitta 10 205/55 R16' => ['remote' => 'Nokian-Hakkapeliitta-10.png', 'local' => 'nokian-hakkapeliitta-10.png'],
        'Gislaved Nord*Frost 200 215/60 R16' => ['remote' => 'Gislaved-Nord-Frost-200.jpg', 'local' => 'gislaved-nord-frost-200.png'],
        'Pirelli Ice Zero FR 225/50 R17' => ['remote' => 'Pirelli-Ice-Zero-FR.jpeg', 'local' => 'pirelli-ice-zero-fr.png'],
        'Continental VikingContact 7 205/55 R16' => ['remote' => 'Continental-VikingContact-7.jpg', 'local' => 'continental-vikingcontact-7.png'],
        'Michelin X-Ice North 4 225/45 R17' => ['remote' => 'Michelin-X-Ice-North-4.jpeg', 'local' => 'michelin-x-ice-north-4.png'],
        'Yokohama iceGuard Studless G075 215/60 R16' => ['remote' => 'Pirelli-Ice-Zero-FR.jpeg', 'local' => 'yokohama-iceguard-g075.png'],
        'Goodyear Vector 4Seasons Gen-3 205/55 R16' => ['remote' => 'Goodyear-Vector-4Seasons-Gen-3.png', 'local' => 'goodyear-vector-4seasons-gen-3.png'],
        'Michelin CrossClimate 2 225/45 R17' => ['remote' => 'Michelin-CrossClimate-2.png', 'local' => 'michelin-crossclimate-2.png'],
        'Hankook Kinergy 4S2 195/65 R15' => ['remote' => 'Hankook-Kinergy-4S2.png', 'local' => 'hankook-kinergy-4s2.png'],
        'Continental AllSeasonContact 215/55 R17' => ['remote' => 'Continental-AllSeasonContact.png', 'local' => 'continental-allseasoncontact.png'],
        'Bridgestone Weather Control A005 205/55 R16' => ['remote' => 'Bridgestone-Weather-Control-A005.png', 'local' => 'bridgestone-weather-control-a005.png'],
        'Nokian Seasonproof 195/65 R15' => ['remote' => 'Goodyear-Vector-4Seasons-Gen-3.png', 'local' => 'nokian-seasonproof.png'],
    ];

    public function handle(ProductImageService $images): int
    {
        $dir = $images->directory();
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach (Product::all() as $product) {
            $mapping = self::MAP[$product->name] ?? null;

            if (! $mapping) {
                continue;
            }

            $url = self::BASE.'/'.$mapping['remote'];
            $path = $dir.DIRECTORY_SEPARATOR.$mapping['local'];

            $this->info("Downloading: {$product->name}");

            $response = Http::timeout(30)->withOptions(['verify' => false])->get($url);

            if (! $response->successful()) {
                $this->error("HTTP {$response->status()}: {$url}");
                continue;
            }

            file_put_contents($path, $response->body());

            if ($images->canProcessImages() && $images->needsBackgroundRemoval($path)) {
                $pngLocal = pathinfo($mapping['local'], PATHINFO_FILENAME).'.png';
                $pngPath = $dir.DIRECTORY_SEPARATOR.$pngLocal;
                $tempPath = $pngPath.'.tmp';
                if ($images->processFile($path, $tempPath) && is_file($tempPath)) {
                    if (is_file($pngPath)) {
                        unlink($pngPath);
                    }
                    rename($tempPath, $pngPath);
                    if (is_file($path) && $path !== $pngPath) {
                        unlink($path);
                    }
                    $mapping['local'] = $pngLocal;
                    $path = $pngPath;
                } else {
                    @unlink($tempPath);
                }
            }

            $product->update(['image' => $mapping['local']]);
            $this->info("OK: {$mapping['local']}");
        }

        $this->info('All images synced.');

        return self::SUCCESS;
    }
}
