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

use Illuminate\Routing\Route;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Artisan;
use Laravel\Folio\FolioManager;
use Symfony\Component\Console\Output\BufferedOutput;

$routes = new class
{
public function all()
{
return collect(app('router')->getRoutes()->getRoutes())
->map(fn (Route $route) => $this->getRoute($route))
->merge($this->getFolioRoutes());
}

protected function getFolioRoutes()
{
try {
$output = new BufferedOutput;

Artisan::call('folio:list', ['--json' => true], $output);

$mountPaths = collect(app(FolioManager::class)->mountPaths());

return collect(json_decode($output->fetch(), true))->map(fn ($route) => $this->getFolioRoute($route, $mountPaths));
} catch (Exception|Throwable $e) {
return [];
}
}

protected function getFolioRoute($route, $mountPaths)
{
if ($mountPaths->count() === 1) {
$mountPath = $mountPaths[0];
} else {
$mountPath = $mountPaths->first(fn ($mp) => file_exists($mp->path . DIRECTORY_SEPARATOR . $route['view']));
}

$path = $route['view'];

if ($mountPath) {
$path = $mountPath->path . DIRECTORY_SEPARATOR . $path;
}

return [
'method' => $route['method'],
'uri' => $route['uri'],
'name' => $route['name'],
'action' => null,
'parameters' => [],
'filename' => LspHelper::relativePath($path),
'line' => 0,
];
}

protected function getRoute(Route $route)
{
try {
$reflection = $this->getRouteReflection($route);
} catch (Throwable $e) {
$reflection = null;
}

return [
'method' => collect($route->methods())
->filter(fn ($method) => $method !== 'HEAD')
->implode('|'),
'uri' => $route->uri(),
'name' => $route->getName(),
'action' => $route->getActionName(),
'parameters' => $route->parameterNames(),
'filename' => $reflection ? LspHelper::relativePath($reflection->getFileName()) : null,
'line' => $reflection ? $reflection->getStartLine() : null,
'livewire' => $this->getLivewireView($route),
];
}

protected function getLivewireView(Route $route): ?string
{
if ($route->getActionName() !== 'Livewire\Features\SupportRouting\LivewirePageController') {
return null;
}

return $route->defaults['_livewire_component'] ?? null;
}

protected function getRouteReflection(Route $route)
{
if ($route->getActionName() === 'Closure') {
return new ReflectionFunction($route->getAction()['uses']);
}

if (!str_contains($route->getActionName(), '@')) {
return new ReflectionClass($route->getActionName());
}

try {
return new ReflectionMethod($route->getControllerClass(), $route->getActionMethod());
} catch (Throwable $e) {
$namespace = app(UrlGenerator::class)->getRootControllerNamespace()
?? (app()->getNamespace() . 'Http\Controllers');

return new ReflectionMethod(
$namespace . '\\' . ltrim($route->getControllerClass(), '\\'),
$route->getActionMethod(),
);
}
}
};

echo $routes->all()->toJson();
