<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Летние шины', 'slug' => 'letnie', 'group' => Category::GROUP_TIRES, 'sort_order' => 1, 'image' => 'icon-summer.svg'],
            ['name' => 'Зимние шины', 'slug' => 'zimnie', 'group' => Category::GROUP_TIRES, 'sort_order' => 2, 'image' => 'icon-winter.svg'],
            ['name' => 'Всесезонные шины', 'slug' => 'vsesezonnye', 'group' => Category::GROUP_TIRES, 'sort_order' => 3, 'image' => 'icon-allseason.svg'],
            ['name' => 'Литые диски', 'slug' => 'litye-diski', 'group' => Category::GROUP_WHEELS, 'sort_order' => 1, 'image' => 'icon-disk-alloy.svg'],
            ['name' => 'Стальные диски', 'slug' => 'stalnye-diski', 'group' => Category::GROUP_WHEELS, 'sort_order' => 2, 'image' => 'icon-disk-steel.svg'],
            ['name' => 'Кованые диски', 'slug' => 'kovannye-diski', 'group' => Category::GROUP_WHEELS, 'sort_order' => 3, 'image' => 'icon-disk-forged.svg'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $products = [
            // Летние шины (6)
            ['category' => 'letnie', 'slug' => 'michelin-primacy-4-205-55-r16', 'name' => 'Michelin Primacy 4 205/55 R16', 'price' => 8490, 'image' => 'michelin-primacy-4.png', 'description' => 'Летняя шина с отличным сцеплением на мокрой дороге. Низкий уровень шума, экономия топлива.'],
            ['category' => 'letnie', 'slug' => 'bridgestone-turanza-t005-225-45-r17', 'name' => 'Bridgestone Turanza T005 225/45 R17', 'price' => 11200, 'image' => 'bridgestone-turanza-t005.png', 'description' => 'Премиальная летняя шина для комфортной езды. Усиленная боковина, стабильность на скорости.'],
            ['category' => 'letnie', 'slug' => 'continental-premiumcontact-6-195-65-r15', 'name' => 'Continental PremiumContact 6 195/65 R15', 'price' => 6790, 'image' => 'continental-premiumcontact-6.png', 'description' => 'Универсальная летняя модель для городских автомобилей. Короткий тормозной путь.'],
            ['category' => 'letnie', 'slug' => 'yokohama-bluerth-gt-ae51-215-55-r17', 'name' => 'Yokohama BluEarth-GT AE51 215/55 R17', 'price' => 7890, 'image' => 'yokohama-bluerth-gt-ae51.png', 'description' => 'Экономичная летняя шина с низким сопротивлением качению и мягким ходом.'],
            ['category' => 'letnie', 'slug' => 'pirelli-cinturato-p7-205-50-r17', 'name' => 'Pirelli Cinturato P7 205/50 R17', 'price' => 9340, 'image' => 'pirelli-cinturato-p7.png', 'description' => 'Спортивно-комфортная летняя модель для седанов бизнес-класса.'],
            ['category' => 'letnie', 'slug' => 'hankook-ventus-prime4-k135-225-40-r18', 'name' => 'Hankook Ventus Prime4 K135 225/40 R18', 'price' => 10290, 'image' => 'hankook-ventus-prime4-k135.png', 'description' => 'Летняя шина повышенной износостойкости для активной городской езды.'],

            // Зимние шины (6)
            ['category' => 'zimnie', 'slug' => 'nokian-hakkapeliitta-10-205-55-r16', 'name' => 'Nokian Hakkapeliitta 10 205/55 R16', 'price' => 9890, 'image' => 'nokian-hakkapeliitta-10.png', 'description' => 'Шипованная зимняя шина для суровых условий. Надёжное сцепление на льду и снегу.'],
            ['category' => 'zimnie', 'slug' => 'gislaved-nord-frost-200-215-60-r16', 'name' => 'Gislaved Nord*Frost 200 215/60 R16', 'price' => 5490, 'image' => 'gislaved-nord-frost-200.png', 'description' => 'Доступная зимняя шина с шипами. Хорошая управляемость в городе.'],
            ['category' => 'zimnie', 'slug' => 'pirelli-ice-zero-fr-225-50-r17', 'name' => 'Pirelli Ice Zero FR 225/50 R17', 'price' => 10500, 'image' => 'pirelli-ice-zero-fr.png', 'description' => 'Фрикционная зимняя шина без шипов. Для регионов с мягкой зимой.'],
            ['category' => 'zimnie', 'slug' => 'continental-vikingcontact-7-205-55-r16', 'name' => 'Continental VikingContact 7 205/55 R16', 'price' => 8750, 'image' => 'continental-vikingcontact-7.png', 'description' => 'Немецкая зимняя шина с коротким тормозным путём на снегу и льду.'],
            ['category' => 'zimnie', 'slug' => 'michelin-x-ice-north-4-225-45-r17', 'name' => 'Michelin X-Ice North 4 225/45 R17', 'price' => 11890, 'image' => 'michelin-x-ice-north-4.png', 'description' => 'Шипованная модель для северных регионов с усиленным каркасом.'],
            ['category' => 'zimnie', 'slug' => 'yokohama-iceguard-g075-215-60-r16', 'name' => 'Yokohama iceGuard Studless G075 215/60 R16', 'price' => 7290, 'image' => 'yokohama-iceguard-g075.png', 'description' => 'Фрикционная зимняя шина для кроссоверов и минивэнов.'],

            // Всесезонные шины (6)
            ['category' => 'vsesezonnye', 'slug' => 'goodyear-vector-4seasons-gen-3-205-55-r16', 'name' => 'Goodyear Vector 4Seasons Gen-3 205/55 R16', 'price' => 7990, 'image' => 'goodyear-vector-4seasons-gen-3.png', 'description' => 'Всесезонная шина для круглогодичной эксплуатации. Сбалансированные характеристики.'],
            ['category' => 'vsesezonnye', 'slug' => 'michelin-crossclimate-2-225-45-r17', 'name' => 'Michelin CrossClimate 2 225/45 R17', 'price' => 12490, 'image' => 'michelin-crossclimate-2.png', 'description' => 'Премиальная всесезонка с маркировкой 3PMSF. Подходит для лёгкого снега.'],
            ['category' => 'vsesezonnye', 'slug' => 'hankook-kinergy-4s2-195-65-r15', 'name' => 'Hankook Kinergy 4S2 195/65 R15', 'price' => 5890, 'image' => 'hankook-kinergy-4s2.png', 'description' => 'Экономичная всесезонная модель. Долгий срок службы протектора.'],
            ['category' => 'vsesezonnye', 'slug' => 'continental-allseasoncontact-215-55-r17', 'name' => 'Continental AllSeasonContact 215/55 R17', 'price' => 8990, 'image' => 'continental-allseasoncontact.png', 'description' => 'Всесезонная шина с сертификацией 3PMSF для умеренного климата.'],
            ['category' => 'vsesezonnye', 'slug' => 'bridgestone-weather-control-a005-205-55-r16', 'name' => 'Bridgestone Weather Control A005 205/55 R16', 'price' => 9490, 'image' => 'bridgestone-weather-control-a005.png', 'description' => 'Универсальная модель для города и трассы в любое время года.'],
            ['category' => 'vsesezonnye', 'slug' => 'nokian-seasonproof-195-65-r15', 'name' => 'Nokian Seasonproof 195/65 R15', 'price' => 6490, 'image' => 'nokian-seasonproof.png', 'description' => 'Доступная всесезонная шина с надёжным поведением на мокром асфальте.'],

            // Литые диски (6)
            ['category' => 'litye-diski', 'slug' => 'bbs-ch-r-18x8-5-et35', 'name' => 'BBS CH-R 18×8.5 ET35 5×112', 'price' => 28900, 'image' => 'disk-bbs-ch-r.png', 'description' => 'Литой диск премиум-класса. Лёгкий сплав, строгий дизайн для немецких автомобилей.'],
            ['category' => 'litye-diski', 'slug' => 'oz-racing-ultraleggera-17x7-et45', 'name' => 'OZ Racing Ultraleggera 17×7 ET45 5×114.3', 'price' => 22400, 'image' => 'disk-oz-ultraleggera.png', 'description' => 'Облегчённый литой диск итальянского производства для динамичной езды.'],
            ['category' => 'litye-diski', 'slug' => 'replica-audi-a5-18x8-et35', 'name' => 'Replica Audi A5 18×8 ET35 5×112', 'price' => 12900, 'image' => 'disk-replica-audi.png', 'description' => 'Литой диск в стиле Audi A5. Серебристое покрытие, точная посадка.'],
            ['category' => 'litye-diski', 'slug' => 'mak-fahr-19x8-et40', 'name' => 'MAK Fahr 19×8 ET40 5×112', 'price' => 18700, 'image' => 'disk-mak-fahr.png', 'description' => 'Стильный литой диск с многоспицевым дизайном для VW и Skoda.'],
            ['category' => 'litye-diski', 'slug' => 'kosei-k1-racing-16x6-5-et45', 'name' => 'Kosei K1 Racing 16×6.5 ET45 4×100', 'price' => 9900, 'image' => 'disk-kosei-k1.png', 'description' => 'Компактный литой диск для городских хэтчбеков и седанов B-класса.'],
            ['category' => 'litye-diski', 'slug' => 'dezent-re-dark-17x7-et48', 'name' => 'Dezent RE Dark 17×7 ET48 5×108', 'price' => 14200, 'image' => 'disk-dezent-re.png', 'description' => 'Литой диск с чёрным матовым покрытием для Ford и Volvo.'],

            // Стальные диски (6)
            ['category' => 'stalnye-diski', 'slug' => 'trebl-90533-16x6-5-et40', 'name' => 'Trebl 90533 16×6.5 ET40 4×100', 'price' => 3200, 'image' => 'disk-steel-trebl.png', 'description' => 'Штампованный стальной диск для зимней резины. Практичный и надёжный.'],
            ['category' => 'stalnye-diski', 'slug' => 'magnetto-15003-15x6-et43', 'name' => 'Magnetto 15003 15×6 ET43 4×100', 'price' => 2790, 'image' => 'disk-steel-magnetto.png', 'description' => 'Стальной диск с заводским покрытием для компактных автомобилей.'],
            ['category' => 'stalnye-diski', 'slug' => 'next-nx-063-16x6-5-et50', 'name' => 'Next NX-063 16×6.5 ET50 5×114.3', 'price' => 3490, 'image' => 'disk-steel-next.png', 'description' => 'Усиленный стальной диск для кроссоверов и универсалов.'],
            ['category' => 'stalnye-diski', 'slug' => 'ifree-kh-131-17x7-et39', 'name' => 'iFree KH-131 17×7 ET39 5×108', 'price' => 4100, 'image' => 'disk-steel-ifree.png', 'description' => 'Стальной диск с декоративными вентиляционными отверстиями.'],
            ['category' => 'stalnye-diski', 'slug' => 'arrivo-ar919-14x5-5-et43', 'name' => 'Arrivo AR919 14×5.5 ET43 4×100', 'price' => 2190, 'image' => 'disk-steel-arrivo.png', 'description' => 'Бюджетный стальной диск для малолитражных автомобилей.'],
            ['category' => 'stalnye-diski', 'slug' => 'eurodisk-10015-15x6-et28', 'name' => 'Eurodisk 10015 15×6 ET28 5×139.7', 'price' => 4590, 'image' => 'disk-steel-eurodisk.png', 'description' => 'Стальной диск для внедорожников и пикапов с разболтовкой 5×139.7.'],

            // Кованые диски (6)
            ['category' => 'kovannye-diski', 'slug' => 'rays-volk-te37-18x9-5-et22', 'name' => 'Rays Volk TE37 18×9.5 ET22 5×114.3', 'price' => 68900, 'image' => 'disk-forged-te37.png', 'description' => 'Легендарный кованый диск из Японии. Максимальная прочность при малом весе.'],
            ['category' => 'kovannye-diski', 'slug' => 'bbs-fi-r-19x8-5-et32', 'name' => 'BBS FI-R 19×8.5 ET32 5×112', 'price' => 84500, 'image' => 'disk-forged-bbs-fi.png', 'description' => 'Кованый диск BBS с технологией Flow Forming для спортивных автомобилей.'],
            ['category' => 'kovannye-diski', 'slug' => 'work-emotion-zr10-18x8-et38', 'name' => 'Work Emotion ZR10 18×8 ET38 5×114.3', 'price' => 52800, 'image' => 'disk-forged-work.png', 'description' => 'Кованый диск с агрессивной спицевой формой для тюнинга и трека.'],
            ['category' => 'kovannye-diski', 'slug' => 'hre-p101-20x9-et25', 'name' => 'HRE P101 20×9 ET25 5×112', 'price' => 112000, 'image' => 'disk-forged-hre.png', 'description' => 'Премиальный кованый диск HRE для Porsche и Audi высокой мощности.'],
            ['category' => 'kovannye-diski', 'slug' => 'adv1-adv005-19x8-5-et35', 'name' => 'ADV.1 ADV005 19×8.5 ET35 5×120', 'price' => 76400, 'image' => 'disk-forged-adv1.png', 'description' => 'Кованый диск с индивидуальной отделкой для BMW и Mercedes.'],
            ['category' => 'kovannye-diski', 'slug' => 'rotiform-buc-18x8-5-et45', 'name' => 'Rotiform BUC 18×8.5 ET45 5×112', 'price' => 45600, 'image' => 'disk-forged-rotiform.png', 'description' => 'Кованый моноблок с глубокой посадкой для stance-проектов.'],
        ];

        foreach ($products as $item) {
            $category = Category::where('slug', $item['category'])->firstOrFail();

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['image'],
                    'description' => $item['description'],
                    'available' => true,
                ]
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@autoclub.ru'],
            [
                'name' => 'Администратор',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $client = User::updateOrCreate(
            ['email' => 'client@autoclub.ru'],
            [
                'name' => 'Алексей Смирнов',
                'password' => 'password',
                'is_admin' => false,
            ]
        );

        $client->profile()->updateOrCreate(
            ['user_id' => $client->id],
            [
                'phone' => '+7 (999) 154-56-56',
                'city' => 'Чебоксары',
                'address' => 'ул. Автомобильная, 10',
                'postal_code' => '428000',
            ]
        );
    }
}
