<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;

class MakeModuleRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-request {module} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Form Request inside a module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('module');
        $requestName = $this->argument('name');

        $modulePath = base_path("Modules/{$moduleName}");

        // Kiểm tra module tồn tại
        if (!File::exists($modulePath)) {
            $this->error("Module [$moduleName] không tồn tại!");
            return;
        }

        // Đường dẫn request
        $requestPath = $modulePath . '/app/Http/Requests';

        // Tạo folder nếu chưa có
        if (!File::exists($requestPath)) {
            File::makeDirectory($requestPath, 0777, true);
        }

        $filePath = "$requestPath/{$requestName}.php";

        if (File::exists($filePath)) {
            $this->error("Request [$requestName] đã tồn tại!");
            return;
        }

        // Nội dung file Request
        $stub = <<<PHP
<?php

namespace Modules\\$moduleName\\App\\Http\\Requests;

use Illuminate\Foundation\Http\FormRequest;

class $requestName extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
PHP;

        File::put($filePath, $stub);

        $this->info("Đã tạo Request: Modules/$moduleName/app/Http/Requests/$requestName.php");
    }
}
