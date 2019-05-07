# GeName - name generator
Generates file name according to specified rules.

# GeName - генератор имен

Генерирует любые имена по заданным правилам, в т.ч. имена файлов.

Библиотека предсталяет набор интерфейсов для расширения и управления генерацией имен.

# Пример работы

use Belca\GeName\GeName;

$config = [
    'date' => \Belca\GeName\DateGenerator::class,
    'random_string' => \Belca\GeName\RandomStringGenerator::class,
];

$gename = new GeName($config);

// File name generation. Example 1

$pattern = '{directory}/{random_string}-{date}.jpg';

$directory = '/var/www/server/files/';

$gename->setPattern($pattern);
$gename->setDirectory($directory, false);

$filename = $gename->generateName(); // output: '/var/www/server/files/kd2rh3fDH-2019-04-14.jpg'

// File name generation. Example 1

$pattern = '{random_string}-{date}.jpg';

$gename->setPattern($pattern);
$gename->relativeFileExists(true);

$filename = $gename->generateName(); // output: 'kdOnf3fDH-2019-04-14.jpg'

// Генерация имени, например, документа

$pattern = 'document {date} - {creator}';

$params = [
    'creator' => 'Oleg Dmitrochenko',
];

$gename->setPattern($pattern);
$gename->resetDirectory();

$filename = $gename->generateName(); // output: 'document 2019-04-14 - Oleg Dmitrochenko'

// Извлечение сгенерированных значений
$values = $gename->getGeneratedValues();
