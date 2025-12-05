<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:module-controller')]
class MakeModuleController extends Command
{
    protected $signature = 'make:module-controller {module} {name}';
    protected $description = 'Create Controller for a specific module with repository injection';

    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $basePath = base_path("Modules/$module/app/Http/Controllers");

        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        // Tạo tên controller
        $controllerName = $name . 'Controller';
        $controllerPath = "$basePath/$controllerName.php";

        if (File::exists($controllerPath)) {
            $this->error("Controller [$controllerName] đã tồn tại!");
            return Command::FAILURE;
        }

        // Tạo tên repository property (lowercase first letter)
        $repositoryProperty = lcfirst($name) . 'Repository';
        $repositoryInterface = $name . 'RepositoryInterface';

        // Tạo nội dung controller
        $controllerContent = "<?php

namespace Modules\\{$module}\\Http\\Controllers;

use App\\Http\\Controllers\\Controller;
use Modules\\{$module}\\Repositories\\{$repositoryInterface};

class {$controllerName} extends Controller
{

    protected \${$repositoryProperty};

    public function __construct({$repositoryInterface} \${$repositoryProperty})
    {
        \$this->{$repositoryProperty} = \${$repositoryProperty};
    }
}
";

        File::put($controllerPath, $controllerContent);

        $this->info("Controller [$controllerName] đã được tạo thành công!");
        $this->info("Path: Modules/$module/app/Http/Controllers/$controllerName.php");
        
        return Command::SUCCESS;
    }
}

