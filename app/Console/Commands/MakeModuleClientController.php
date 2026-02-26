<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str; // Thêm class Str của Laravel

class MakeModuleClientController extends Command
{
    protected $signature = 'make:module-client-controller {module} {name}';

    protected $description = 'Create a Client Controller for a specific module';

    public function handle()
    {
        // 1. Lấy argument và tự động format chữ cái đầu thành viết hoa (courses -> Courses)
        $rawModule = $this->argument('module');
        $moduleNamespace = Str::studly($rawModule); 
        
        $rawName = $this->argument('name');
        $name = Str::studly($rawName); // Đảm bảo tên Controller cũng luôn viết hoa chữ đầu

        // Đường dẫn vật lý (Vẫn dùng $rawModule hoặc $moduleNamespace tùy thuộc vào việc thư mục của bạn viết hoa hay viết thường. 
        // Thường nwidart/laravel-modules sẽ tạo thư mục viết hoa nên mình dùng $moduleNamespace luôn).
        $basePath = base_path("Modules/{$moduleNamespace}/app/Http/Controllers/Clients");

        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        $controllerName = $name . 'Controller';
        $controllerPath = "{$basePath}/{$controllerName}.php";

        if (File::exists($controllerPath)) {
            $this->error("Lỗi: Controller [{$controllerName}] đã tồn tại!");
            return self::FAILURE;
        }

        $repositoryClass = $name . 'Repository';
        $repositoryProperty = lcfirst($name) . 'Repository';

        // 2. Sử dụng $moduleNamespace đã được viết hoa cho file nội dung
        $controllerContent = "<?php

namespace Modules\\{$moduleNamespace}\\app\\Http\\Controllers\\Clients;

use App\\Http\\Controllers\\Controller;
use Modules\\{$moduleNamespace}\\Repositories\\{$repositoryClass};

class {$controllerName} extends Controller
{
    protected \${$repositoryProperty};

    public function __construct({$repositoryClass} \${$repositoryProperty})
    {
        \$this->{$repositoryProperty} = \${$repositoryProperty};
    }
}
";

        File::put($controllerPath, $controllerContent);

        $this->info("Đã tạo thành công Client Controller tại: {$controllerPath}");
        
        return self::SUCCESS;
    }
}