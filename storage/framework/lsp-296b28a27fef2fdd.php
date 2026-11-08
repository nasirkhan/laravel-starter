<?php
define('LARAVEL_START', microtime(true));
require getcwd() . '/vendor/autoload.php';
$app = require getcwd() . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
error_reporting(error_reporting() & ~(E_WARNING | E_CORE_WARNING | E_COMPILE_WARNING | E_USER_WARNING | E_DEPRECATED | E_USER_DEPRECATED));
class LspHelper
{
public static function relativePath($path)
{
if (!str_contains($path, base_path())) {
return (string) $path;
}

return ltrim(str_replace(base_path(), '', realpath($path) ?: $path), DIRECTORY_SEPARATOR);
}

public static function isVendor($path)
{
return str_contains($path, base_path('vendor'));
}

public static function propertyDefault(ReflectionProperty $property, ?ReflectionParameter $parameter = null): array
{
if ($property->hasDefaultValue()) {
return ['default' => $property->getDefaultValue()];
}

if ($parameter?->isDefaultValueAvailable()) {
return ['default' => $parameter->getDefaultValue()];
}

return [];
}

public static function formatDefaultValue(mixed $value): mixed
{
return match (true) {
is_array($value) => 'array(...)',
$value instanceof UnitEnum => get_class($value) . '::' . $value->name,
$value instanceof Closure => 'Closure',
is_object($value) => get_class($value),
is_string($value) => var_export($value, true),
is_null($value) => 'null',
is_bool($value) => $value ? 'true' : 'false',
default => $value,
};
}
}

use Illuminate\Support\Facades\File;
use Pest\Contracts\HasPrintableTestCaseName;
use Pest\Support\Str;
use Pest\TestSuite;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\TestSuiteLoader;
use PHPUnit\TextUI\XmlConfiguration\LoadedFromFileConfiguration;
use PHPUnit\TextUI\XmlConfiguration\Loader;
use SebastianBergmann\FileIterator\Facade;

$tests = new class
{
public function all(): array
{
if (!$this->isPhpUnitInstalled()) {
return [];
}

if ($this->isPestInstalled()) {
$this->bootPest();
}

return collect(
$this->getTestSuites()
)->map(fn ($suite) => [
'name' => $suite['name'],
'files' => collect(array_merge(
$this->collectPhpUnitTests($suite['files']),
$this->collectPestTests($suite['files']),
))->map($this->pathsTransformer($suite['directories'])),
])->all();
}

protected function pathsTransformer(array $directories): callable
{
$directories = array_map(LspHelper::relativePath(...), $directories);

return function (array $file) use ($directories) {
return array_merge($file, [
'path' => $path = LspHelper::relativePath($file['path']),
'name' => str($path)->basename()->replace('.php', ''),
'directories' => str($path)->dirname()
->replace($directories, '')
->ltrim(DIRECTORY_SEPARATOR)
->explode(DIRECTORY_SEPARATOR)
->filter(),
]);
};
}

protected function isPhpUnitInstalled(): bool
{
return class_exists(TestCase::class);
}

protected function isPestInstalled(): bool
{
return class_exists(TestSuite::class);
}

protected function bootPest(): void
{
require_once base_path('vendor/pestphp/pest/overrides/Runner/TestSuiteLoader.php');

TestSuite::getInstance(base_path(), 'tests');

if (file_exists($pestFile = base_path('tests/Pest.php'))) {
require_once $pestFile;
}
}




protected function getTestSuites(): array
{
if (is_null($config = $this->loadConfig())) {
return [[
'name' => 'default',
'directories' => [base_path('tests')],
'files' => $this->findTestFiles(base_path('tests')),
]];
}

$result = [];

foreach ($config->testSuite() as $suite) {
$files = collect();

foreach ($suite->directories() as $directory) {
$files->push(...$this->findTestFiles($directory->path()));
}

foreach ($suite->files() as $file) {
$files->push($file->path());
}

$result[] = [
'name' => $suite->name(),
'directories' => collect($suite->directories()->asArray())->map->path()->all(),
'files' => $files->all(),
];
}

return $result;
}

protected function loadConfig(): ?LoadedFromFileConfiguration
{
foreach ([
base_path('phpunit.xml'),
base_path('phpunit.xml.dist'),
] as $path) {
if (File::exists($path)) {
return (new Loader)->load($path);
}
}

return null;
}




protected function findTestFiles(string $directory): array
{
return (new Facade)->getFilesAsArray($directory, 'Test.php');
}





protected function collectPestTests(array $files): array
{
if (!$this->isPestInstalled()) {
return [];
}

if (is_null($pest = TestSuite::getInstance())) {
return [];
}

$results = [];

foreach ($files as $path) {
if (is_null($factory = $pest->tests->get($path))) {
continue;
}

$results[] = [
'path' => $path,
'tests' => collect($factory->methods)
->whereNotNull('description')
->map(fn ($method) => [
'name' => $method->description,
'eventName' => Str::evaluable($method->description),
'line' => (new ReflectionFunction($method->closure))->getStartLine(),
])
->values()
->all(),
];
}

return $results;
}





protected function collectPhpUnitTests(array $files): array
{
$loader = new TestSuiteLoader;

$results = [];

foreach ($files as $path) {
try {
$reflection = $loader->load($path);
} catch (Throwable $e) {
continue;
}

if (!$this->isPhpUnitTest($reflection)) {
continue;
}

$tests = $this->extractTestMethods($reflection);

if (!empty($tests)) {
$results[] = compact('path', 'tests');
}
}

return $results;
}

protected function isPhpUnitTest(ReflectionClass $reflection): bool
{
if (!$this->isPestInstalled()) {
return $reflection->isSubclassOf(TestCase::class);
}

return $reflection->isSubclassOf(TestCase::class)
&& !$reflection->implementsInterface(HasPrintableTestCaseName::class);
}





protected function extractTestMethods(ReflectionClass $reflection): array
{
$tests = [];

foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
if ($method->getDeclaringClass()->getName() !== $reflection->getName()) {
continue;
}

if (!$this->isTestMethod($method)) {
continue;
}

$tests[] = [
'name' => $name = $method->getName(),
'eventName' => $name,
'line' => $method->getStartLine(),
];
}

return $tests;
}

protected function isTestMethod(ReflectionMethod $method): bool
{
return str_starts_with($method->getName(), 'test')
|| $method->getAttributes(Test::class) !== [];
}
};

echo json_encode($tests->all());
