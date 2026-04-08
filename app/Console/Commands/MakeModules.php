<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModules extends Command
{
    protected $signature = 'make:modules {name} {table?}';
    protected $description = 'Cria um módulo com rotas, Livewire Components e views conforme padrão';

    public function handle()
    {
        $module = Str::studly($this->argument('name'));
        $table = $this->argument('table') ?? Str::snake(Str::pluralStudly($module));
        $model = Str::studly(Str::singular($table));
        $moduleNamespace = "Modules\\{$module}\\App\\Livewire";

        $basePath = base_path("modules/{$module}");

        $dirs = [
            "{$basePath}/routes",
            "{$basePath}/database/migrations",
            "{$basePath}/resources/views/livewire/page",
            "{$basePath}/resources/views/livewire/admin",
            "{$basePath}/App/Livewire/Page",
            "{$basePath}/App/Livewire/Admin",
            "{$basePath}/App/Models",
        ];

        foreach ($dirs as $dir) {
            if (!is_dir($dir)) mkdir($dir, 0755, true);
        }

        // Criar Service Provider
        $providerPath = "{$basePath}/{$module}ServiceProvider.php";
        if (!file_exists($providerPath)) {
            file_put_contents($providerPath, $this->getProviderStub($module));
        }

        // Criar rotas
        $routePath = "{$basePath}/routes/web.php";
        file_put_contents($routePath, $this->getRoutesStub($module, $model, $moduleNamespace));

        // Migration
        $timestamp = now()->format('Y_m_d_His');
        $migrationName = "{$timestamp}_create_{$table}_table.php";
        $migrationPath = "{$basePath}/database/migrations/{$migrationName}";
        file_put_contents($migrationPath, $this->getMigrationStub($table));

        // Model
        $modelPath = "{$basePath}/App/Models/{$model}.php";
        file_put_contents($modelPath, $this->getModelStub($model, $table, $module));

        // Livewire Components
        file_put_contents("{$basePath}/App/Livewire/Page/{$model}Index.php", $this->getLivewirePageStub($module, $model));
        file_put_contents("{$basePath}/App/Livewire/Admin/{$model}Edit.php", $this->getLivewireAdminStub($module, "{$model}Edit"));
        file_put_contents("{$basePath}/App/Livewire/Admin/{$model}Form.php", $this->getLivewireAdminStub($module, "{$model}Form"));
        file_put_contents("{$basePath}/App/Livewire/Admin/{$model}List.php", $this->getLivewireAdminStub($module, "{$model}List"));

        // Views
        $moduleLower = Str::lower($module);
        $viewPrefix = "{$basePath}/resources/views/livewire";

        file_put_contents("{$viewPrefix}/page/" . Str::kebab($model) . "-index.blade.php", $this->getViewStub("Página pública de {$model}", true));
        file_put_contents("{$viewPrefix}/admin/" . Str::kebab($model) . "-edit.blade.php", $this->getViewStub("Editar {$model}"));
        file_put_contents("{$viewPrefix}/admin/" . Str::kebab($model) . "-form.blade.php", $this->getViewStub("Formulário novo {$model}"));
        file_put_contents("{$viewPrefix}/admin/" . Str::kebab($model) . "-list.blade.php", $this->getViewStub("Lista de {$model}s"));


        $this->info("Módulo '{$module}' criado com sucesso com rotas, Livewire e views.");
    }

    protected function getProviderStub($module)
    {
        return <<<PHP
        <?php

        namespace Modules\\{$module};

        use Illuminate\Support\ServiceProvider;

        class {$module}ServiceProvider extends ServiceProvider
        {
            public function boot(): void
            {
                \$this->loadRoutesFrom(__DIR__.'/routes/web.php');
                \$this->loadViewsFrom(__DIR__.'/resources/views', strtolower('{$module}'));
                \$this->loadMigrationsFrom(__DIR__.'/database/migrations');
            }

            public function register(): void
            {
                //
            }
        }
        PHP;
    }

    protected function getRoutesStub($module, $model, $namespace)
    {
        $modelKebab = Str::kebab($model);

        return <<<PHP
            <?php

            use Illuminate\Support\Facades\Route;
            use {$namespace}\\Page\\{$model}Index;
            use {$namespace}\\Admin\\{$model}Edit;
            use {$namespace}\\Admin\\{$model}Form;
            use {$namespace}\\Admin\\{$model}List;

            // Rotas do módulo {$module}

            // Página pública
            Route::get('/{$modelKebab}s', {$model}Index::class)
                ->name('{$modelKebab}s');

            // Painel admin (autenticado e verificado)
            Route::middleware(['auth', 'verified'])->group(function () {
                Route::get('{$modelKebab}s/{$modelKebab}s-list', {$model}List::class)
                    ->name('{$modelKebab}s-list');

                Route::get('{$modelKebab}s/{$modelKebab}-novo', {$model}Form::class)
                    ->name('{$modelKebab}-novo');

                Route::get('{$modelKebab}s/{$modelKebab}-edit/{{{$modelKebab}s}}/editar', {$model}Edit::class)
                    ->name('{$modelKebab}-edit');
            });
            PHP;
    }


    protected function getMigrationStub($table)
    {
        return <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->id();
            \$table->string('title');
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};
PHP;
    }

    protected function getModelStub($model, $table, $module)
    {
        return <<<PHP
<?php

namespace Modules\\{$module}\\App\\Models;

use Illuminate\Database\Eloquent\Model;

class {$model} extends Model
{
    protected \$table = '{$table}';

    protected \$fillable = ['title'];
}
PHP;
    }

    protected function getLivewirePageStub($module, $model)
    {
        $moduleLower = Str::lower($module);
        $modelLower = Str::lower($model);
        $viewName = Str::kebab($model) . '-index';

        return <<<PHP
<?php

namespace Modules\\{$module}\\App\\Livewire\\Page;

use Livewire\\Component;

class {$model}Index extends Component
{
    public function render()
    {
        return view('{$moduleLower}::livewire.page.{$viewName}')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de {$model}',
                'meta_description' => 'Descrição detalhada da página {$model}.',
                'meta_keywords' => '{$modelLower}, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}
PHP;
    }


    protected function getLivewireAdminStub($module, $class)
    {
        $moduleLower = Str::lower($module);
        $viewName = Str::kebab($class);

        return <<<PHP
<?php

namespace Modules\\{$module}\\App\\Livewire\\Admin;

use Livewire\Component;

class {$class} extends Component
{
    public function render()
    {
        return view('{$moduleLower}::livewire.admin.{$viewName}');
    }
}
PHP;
    }

    protected function getViewStub($title, $isPage = false)
    {
        if ($isPage) {
            return <<<BLADE
            <div>
                <h1 class="text-2xl font-bold mb-4">{$title}</h1>
                <p>Conteúdo do componente Livewire: {$title}</p>
            </div>
            BLADE;
        }

        // views administrativas sem layout
        return <<<BLADE
            <div>
                <h1 class="text-xl font-bold mb-4">{$title}</h1>
                <p>Conteúdo administrativo do componente: {$title}</p>
            </div>
            BLADE;
    }
}
