<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:module-repository')]
class MakeModuleRepository extends Command
{
    protected $signature = 'make:module-repository {module} {name}';
    protected $description = 'Create Repository and Interface for a specific module';

    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $basePath = base_path("Modules/$module/app/Repositories");

        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        // === Create Interface ===
        $interfacePath = "$basePath/{$name}RepositoryInterface.php";
        $interfaceContent = <<<PHP
<?php

namespace Modules\\$module\\Repositories;

use App\\Repositories\\RepositoryInterface;

interface {$name}RepositoryInterface extends RepositoryInterface
{
    // Define methods here
}

PHP;
        File::put($interfacePath, $interfaceContent);

        // === Create Repository ===
        $repoPath = "$basePath/{$name}Repository.php";
        $repoContent = <<<PHP
<?php

namespace Modules\\$module\\Repositories;

use App\\Repositories\\BaseRepository;
use Modules\\$module\\Models\\$name;

class {$name}Repository extends BaseRepository implements {$name}RepositoryInterface
{
    public function getModel()
    {
        return $name::class;
    }
}

PHP;

        File::put($repoPath, $repoContent);

        // === Auto-bind ServiceProvider ===
        $providerPath = base_path("Modules/$module/Providers/{$module}ServiceProvider.php");

        if (File::exists($providerPath)) {
            $providerContent = File::get($providerPath);

            $bindCode = <<<PHP
        \$this->app->bind(
            \\Modules\\$module\\Repositories\\{$name}RepositoryInterface::class,
            \\Modules\\$module\\Repositories\\{$name}Repository::class
        );
PHP;

            $providerContent = preg_replace(
                '/public function register\(\)\s*\{/',
                "public function register()\n    {\n$bindCode\n",
                $providerContent
            );

            File::put($providerPath, $providerContent);
        }

        $this->info("Repository + Interface for [$module] created!");
        return Command::SUCCESS;
    }
}
