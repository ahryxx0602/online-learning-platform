<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleLang extends Command
{
    protected $signature = 'module:make-lang {module} {locale} {filename}';
    protected $description = 'Create a language file inside a module by filename';

    public function handle()
    {
        $module = $this->argument('module');
        $locale = $this->argument('locale');
        $filename = $this->argument('filename');

        $modulePath = base_path("Modules/{$module}");

        if (!File::exists($modulePath)) {
            $this->error("Module [$module] không tồn tại.");
            return;
        }

        // Đường dẫn đúng theo cấu trúc module hiện tại: Modules/User/lang/vi/
        $langPath = $modulePath . "/lang/{$locale}";

        if (!File::exists($langPath)) {
            File::makeDirectory($langPath, 0777, true);
        }

        $filePath = "{$langPath}/{$filename}.php";

        if (File::exists($filePath)) {
            $this->error("File lang [$filename.php] đã tồn tại trong [$locale]!");
            return;
        }

        // ===============================
        // Generate template theo filename
        // ===============================
        $content = $this->getStubContent($filename);

        File::put($filePath, $content);

        $this->info("✓ Đã tạo file lang: Modules/{$module}/lang/{$locale}/{$filename}.php");
    }

    /**
     * Tự trả về nội dung stub theo tên file
     */
    private function getStubContent($filename)
    {
        switch ($filename) {

            case 'validation':
                return <<<PHP
<?php

return [
    'required' => ':attribute bắt buộc phải nhập',
    'email' => ':attribute không đúng định dạng',
    'unique' => ':attribute đã tồn tại',
    'min' => ':attribute phải từ :min ký tự',
    'max' => ':attribute không được vượt quá :max ký tự',
    'integer' => ':attribute phải là số',
    'numeric' => ':attribute phải là số hợp lệ',
    'select' => ':attribute bắt buộc phải chọn',
];
PHP;

            case 'message':
                return <<<PHP
<?php

return [
    'create_success' => 'Tạo mới thành công',
    'update_success' => 'Cập nhật thành công',
    'delete_success' => 'Xóa thành công',
    'not_found' => 'Không tìm thấy dữ liệu',
    'error' => 'Có lỗi xảy ra, vui lòng thử lại',
];
PHP;

            default:
                return <<<PHP
<?php

return [
    // Thêm key-value lang tại đây
];
PHP;
        }
    }
}
