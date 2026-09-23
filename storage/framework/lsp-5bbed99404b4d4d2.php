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

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Symfony\Component\Finder\Finder;

$components = new class
{
protected $autoloaded = [];

protected $prefixes = [];

public function __construct()
{
$this->autoloaded = require base_path('vendor/composer/autoload_psr4.php');
}

public function all()
{
$components = collect(array_merge(
$this->getStandardClasses(),
$this->getStandardViews(),
$this->getNamespaced(),
$this->getAnonymousNamespaced(),
$this->getAnonymous(),
$this->getAliases(),
$this->getVendorComponents(),
))->groupBy('key')->pipe($this->setProps(...))->map(fn ($items) => [
'isVendor' => $items->first()['isVendor'],
'paths' => $items->pluck('path')->unique()->values(),
'props' => $this->formatProps($items),
]);

return [
'components' => $components,
'prefixes' => $this->prefixes,
];
}

protected function formatProps($items)
{
$props = $items->pluck('props');

if ($codeBlock = $props->firstWhere(fn ($prop) => is_string($prop))) {
return $codeBlock;
}

return $props->values()
->filter()
->flatMap(fn ($i) => $i)
->map(fn ($i) => array_key_exists('default', $i)
? array_merge($i, ['default' => LspHelper::formatDefaultValue($i['default'])])
: $i
);
}

protected function getStandardViews()
{
$path = resource_path('views/components');

return $this->findFiles($path, 'blade.php');
}

protected function findFiles($path, $extension, $keyCallback = null)
{
if (!is_dir($path)) {
return [];
}

$files = Finder::create()
->files()
->name('*.' . $extension)
->in($path);
$components = [];
$pathRealPath = realpath($path);

foreach ($files as $file) {
$realPath = $file->getRealPath();

$key = str($realPath)
->replace($pathRealPath, '')
->ltrim('/\\')
->replace('.' . $extension, '')
->replace(['/', '\\'], '.')
->pipe(fn ($str) => $this->handleIndexComponents($str));

$components[] = [
'path' => LspHelper::relativePath($realPath),
'isVendor' => LspHelper::isVendor($realPath),
'key' => $keyCallback ? $keyCallback($key) : $key,
];
}

return $components;
}

protected function getStandardClasses()
{
$path = app_path('View/Components');

$appNamespace = collect($this->autoloaded)
->filter(fn ($paths) => in_array(app_path(), $paths))
->keys()
->first() ?? '';

return collect($this->findFiles(
$path,
'php',
fn ($key) => $key->explode('.')
->map(fn ($p) => Str::kebab($p))
->implode('.'),
))->map(function ($item) use ($appNamespace) {
$class = str($item['path'])
->after('View/Components/')
->replace('.php', '')
->replace('/', '\\')
->prepend($appNamespace . 'View\\Components\\')
->toString();

if (!class_exists($class)) {
return $item;
}

$reflection = new ReflectionClass($class);
$parameters = collect($reflection->getConstructor()?->getParameters() ?? [])
->filter(fn ($p) => $p->isPromoted())
->keyBy(fn ($p) => $p->getName());

$props = collect($reflection->getProperties())
->filter(fn ($p) => $p->isPublic() && $p->getDeclaringClass()->getName() === $class)
->map(fn ($p) => [
'name' => Str::kebab($p->getName()),
'type' => (string) ($p->getType() ?? 'mixed'),
...LspHelper::propertyDefault($p, $parameters->get($p->getName())),
]);

[$except, $props] = $props->partition(fn ($p) => $p['name'] === 'except');

if ($except->isNotEmpty()) {
$except = $except->first()['default'];
$props = $props->reject(fn ($p) => in_array($p['name'], $except));
}

return [
...$item,
'props' => $props,
];
})->all();
}

protected function getAliases()
{
$components = [];

foreach (Blade::getClassComponentAliases() as $key => $class) {
if (class_exists($class)) {
$reflection = new ReflectionClass($class);

$components[] = [
'path' => LspHelper::relativePath($reflection->getFileName()),
'isVendor' => LspHelper::isVendor($reflection->getFileName()),
'key' => $key,
];
}
}

return $components;
}

protected function getAnonymousNamespaced()
{
$components = [];

foreach (Blade::getAnonymousComponentNamespaces() as $key => $dir) {
$path = collect([$dir, resource_path('views/' . $dir)])->first(fn ($p) => is_dir($p));

if (!$path) {
continue;
}

array_push(
$components,
...$this->findFiles(
$path,
'blade.php',
fn ($k) => $k->kebab()->prepend($key . '::'),
)
);
}

return $components;
}

protected function getAnonymous()
{
$components = [];

foreach (Blade::getAnonymousComponentPaths() as $item) {
array_push(
$components,
...$this->findFiles(
$item['path'],
'blade.php',
function (Stringable $key) use ($item) {
$prefix = $item['prefix'] ? $item['prefix'] . '::' : '';
$key = $key->kebab();
$keys = [];

$keys[] = $key->prepend($prefix);

if ($item['prefix'] === 'flux') {
$keys[] = $key->prepend('flux:');
}

return $keys;
},
)
);

if (!in_array($item['prefix'], $this->prefixes)) {
$this->prefixes[] = $item['prefix'];
}
}

return $components;
}

protected function getVendorComponents(): array
{
$components = [];


$view = App::make('view');


$finder = $view->getFinder();


$views = $finder->getHints();

foreach ($views as $key => $paths) {
foreach ($paths as $path) {
$path .= '/components';

if (!is_dir($path)) {
continue;
}

array_push(
$components,
...$this->findFiles(
$path,
'blade.php',
fn (Stringable $k) => $k->kebab()->prepend($key . '::'),
)
);
}
}

return $components;
}

protected function handleIndexComponents($str)
{
if ($str->endsWith('.index')) {
return $str->replaceLast('.index', '');
}

if (!$str->contains('.')) {
return $str;
}

$parts = $str->explode('.');

if ($parts->slice(-2)->unique()->count() === 1) {
$parts->pop();

return str($parts->implode('.'));
}

return $str;
}

protected function getNamespaced()
{
$namespaced = Blade::getClassComponentNamespaces();
$components = [];

foreach ($namespaced as $key => $classNamespace) {
$path = $this->getNamespacePath($classNamespace);

if (!$path) {
continue;
}

array_push(
$components,
...$this->findFiles(
$path,
'php',
fn ($k) => $k->kebab()->prepend($key . '::'),
)
);
}

return $components;
}

protected function getNamespacePath($classNamespace)
{
foreach ($this->autoloaded as $ns => $paths) {
if (!str_starts_with($classNamespace, $ns)) {
continue;
}

foreach ($paths as $p) {
$dir = str($classNamespace)
->replace($ns, '')
->replace('\\', '/')
->prepend($p . DIRECTORY_SEPARATOR)
->toString();

if (is_dir($dir)) {
return $dir;
}
}

return null;
}

return null;
}

protected function setProps($groups)
{
try {
$compiler = app('blade.compiler');
} catch (Throwable $e) {
return $groups;
}

return $groups->map(function ($group) use ($compiler) {
return $group->transform(function ($component) use ($compiler) {
if (isset($component['props'])) {
return $component;
}

if (!str($component['path'])->endsWith('.blade.php')) {
return $component;
}

if (!$props = $this->parseProps($compiler, $component)) {
return $component;
}

return array_merge($component, ['props' => $props]);
});
});
}

protected function parseProps($compiler, array $component): ?string
{
$content = file_get_contents(base_path($component['path']));

$result = '';

$compiler->directive('props', function ($expression) use (&$result) {
return $result = $expression;
});

$compiler->compileString($content);

if (empty($result)) {
return null;
}

return '@props(' . $result . ')';
}
};

echo json_encode($components->all());
