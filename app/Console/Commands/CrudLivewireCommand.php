<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class CrudLivewireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud
    {className? : The name of the class},
    {modelName? : The name of the model class}';

    protected $description = 'Generate a Livewire Crud';

    private $namespace;
    private $objectName;
    private $viewName;
    private $formFields;
    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
        $this->formFields = [
            ['name' => 'title', 'type' => 'string'],
            ['name' => 'image', 'type' => 'string'],
            ['name' => 'product_id', 'type' => 'string'],
        ];
    }

    public function handle()
    {
        // Gather all the parameters
        $this->getParameters();

        $this->generateModel();
        $this->generateMigration();

        // Generate the livewire class
        $this->generateLivewireClass();

        // Generate the livewire view
        $this->generateLivewireView();
        return 0;
    }

    private function getParameters()
    {
        $this->className = $this->argument('className');
        $this->modelName = $this->argument('modelName');

        if (!$this->className) {
            $this->className = $this->ask('Enter class name');
        }
        if (!$this->modelName) {
            $this->modelName = $this->ask('Enter model name');
        }

        $classNameArray = explode("/", $this->className);
        if (count($classNameArray) > 1) {

            $this->className = last($classNameArray);

            if (($key = array_search($this->className, $classNameArray)) !== false) {
                unset($classNameArray[$key]);
            }
            $this->namespace = implode('/', $classNameArray);
        }

        $this->className = Str::studly($this->className);
        $this->modelName = Str::studly($this->modelName);
        $this->table = Str::plural(Str::snake($this->modelName));

        $this->objectName = Str::camel($this->modelName);
        $this->viewName = $this->namespace != null ? Str::kebab($this->namespace . '/' . $this->className) : Str::kebab($this->className);
        //Remove starting -
        $this->viewName = str_replace('/-', '/', $this->viewName);
    }

    private function getValidationRules()
    {
        $rules = '';
        foreach ($this->formFields as $formField) {
            $rule = $this->file->get(base_path('/stubs/my-crud-generator/validation-rules/rule.stub'));
            $rule = Str::replace('{{objectName}}', $this->objectName, $rule);
            $rule = Str::replace('{{fieldName}}', $formField['name'], $rule);
            $rules = Str::of($rules)->append($rule);
        }
        $ruleWrapper = $this->file->get(base_path('/stubs/my-crud-generator/validation-rules/wrapper.stub'));
        $ruleWrapper = Str::replace('{{rules}}', $rules, $ruleWrapper);
        return $ruleWrapper;
    }

    private function getFormFields()
    {
        $fields = '';
        foreach ($this->formFields as $formField) {
            $field = $this->file->get(base_path('/stubs/my-crud-generator/form-fields/field.stub'));
            $field = Str::replace('{{objectName}}', $this->objectName, $field);
            $field = Str::replace('{{fieldName}}', $formField['name'], $field);
            $fields = Str::of($fields)->append($field);
        }
        return $fields;
    }

    private function getTableHeadings()
    {
        $headings = '';
        foreach ($this->formFields as $formField) {
            $heading = $this->file->get(base_path('/stubs/my-crud-generator/table/heading.stub'));
            $heading = Str::replace('{{fieldName}}', Str::title($formField['name']), $heading);
            $headings = Str::of($headings)->append($heading);
        }
        return $headings;
    }

    private function getTableTableData()
    {
        $data = '';
        foreach ($this->formFields as $formField) {
            $td = $this->file->get(base_path('/stubs/my-crud-generator/table/data.stub'));
            $td = Str::replace('{{objectName}}', $this->objectName, $td);
            $td = Str::replace('{{fieldName}}', $formField['name'], $td);
            $data = Str::of($data)->append($td);
        }
        return $data;
    }


    private function generateLivewireClass()
    {
        $fullPathForClassName = $this->namespace != null ? $this->namespace . '/' . $this->className : $this->className;
        $fileOrigin = base_path('/stubs/my-crud-generator/livewire.crud.stub');
        $fileDestinsation = base_path('/app/Http/Livewire/' . $fullPathForClassName . '.php');

        if ($this->file->exists($fileDestinsation)) {
            $this->info('This class file already exists : ' . $fullPathForClassName . '.php');
            $this->info('Aborting creation.');
            return false;
        }
        #Make Missing Directories
        $base = 'app/Http/Livewire';
        foreach (explode('/', $this->namespace) as $dir) {
            $base = $base . '/' . $dir;
            if ($dir != null && !$this->file->exists($base)) {
                mkdir($base);
            }
        }

        #Replace className for component
        $fileOriginalString = Str::replace(
            '{{className}}',
            $this->className,
            $this->file->get($fileOrigin)
        );
        #Replace modelName in component
        $fileOriginalString = Str::replace(
            '{{modelName}}',
            $this->modelName,
            $fileOriginalString
        );
        #Replace model objectName in component
        $fileOriginalString = Str::replace(
            '{{objectName}}',
            $this->objectName,
            $fileOriginalString
        );

        $namespace_formatted = str_replace('/', '\\', $this->namespace);
        if ($namespace_formatted != null) {
            $namespace_formatted = '\\' . $namespace_formatted;
        }

        #Add NameSpace
        $fileOriginalString = Str::replace(
            '{{namespace}}',
            $namespace_formatted,
            $fileOriginalString
        );

        #Replace viewName
        $fileOriginalString = Str::replace(
            '{{viewName}}',
            Str::replace('/', '.', $this->viewName),
            $fileOriginalString
        );

        #Replace validation rules
        $fileOriginalString = Str::replace('{{validationRules}}', $this->getValidationRules(), $fileOriginalString);

        #create and copy code into file
        $this->file->put($fileDestinsation, $fileOriginalString);
        $this->info('Livewire class file created : ' . $fileDestinsation);
    }

    private function generateLivewireView()
    {
        $fileOrigin = base_path('/stubs/my-crud-generator/livewire.view.crud.stub');
        $fileDestinsation = base_path('/resources/views/livewire/' . $this->viewName . '.blade.php');

        if ($this->file->exists($fileDestinsation)) {
            $this->info('This view file already exists : ' . Str::kebab($this->className) . '.blade.php');
            $this->info('Aborting creation.');
            return false;
        }

        $base = 'resources/views/livewire/';
        foreach (explode('/', $this->namespace) as $dir) {
            $dir = Str::kebab($dir);
            $base = $base . '/' . $dir;
            if ($dir != null && !$this->file->exists($base)) {
                mkdir($base);
            }
        }

        $fileOriginalString = Str::replace(
            '{{objectName}}',
            $this->objectName,
            $this->file->get($fileOrigin)
        );

        $fileOriginalString = Str::replace('{{formFields}}', $this->getFormFields(), $fileOriginalString);

        #Replace table headings
        $fileOriginalString = Str::replace('{{tableHeadings}}', $this->getTableHeadings(), $fileOriginalString);

        #Replace data
        $fileOriginalString = Str::replace('{{tableData}}', $this->getTableTableData(), $fileOriginalString);

        #create and copy code into file
        $this->file->put($fileDestinsation, $fileOriginalString);
        $this->info('Livewire view file created : ' . $fileDestinsation);
    }

    private function generateMigration()
    {
        $migrationFileName = now()->format('Y_m_d_His') . '_create_' . Str::snake(Str::plural($this->modelName)) . '_table';
        $migrationClassName = 'Create' . Str::plural($this->modelName) . 'Table';

        $fileOrigin = base_path('/stubs/my-crud-generator/migration.stub');
        $fileDestinsation = base_path('/database/migrations/' . $migrationFileName . '.php');

        if ($this->file->exists($fileDestinsation)) {
            $this->info('This migration file already exists : ' . $fileDestinsation);
            $this->info('Aborting creation.');
            return false;
        }

        $migrationfields = '';
        foreach ($this->formFields as $formField) {
            $field = "\t\t\t\$table->{{type}}('{{name}}')->nullable();\n";
            $field = Str::replace('{{type}}', $formField['type'], $field);
            $field = Str::replace('{{name}}', $formField['name'], $field);
            $migrationfields = Str::of($migrationfields)->append($field);
        }

        $fileOriginalString = Str::replace('{{class}}', $migrationClassName, $this->file->get($fileOrigin));
        $fileOriginalString = Str::replace('{{table}}', $this->table, $fileOriginalString);
        $fileOriginalString = Str::replace('{{fields}}', $migrationfields, $fileOriginalString);

        $this->file->put($fileDestinsation, $fileOriginalString);
        $this->info('Migration file created : ' . $fileDestinsation);
    }

    private function generateModel()
    {
        $fileOrigin = base_path('/stubs/my-crud-generator/model.stub');
        $fileDestinsation = base_path('/app/Models/' . $this->modelName . '.php');

        if ($this->file->exists($fileDestinsation)) {
            $this->info('This Model already exists : ' . $fileDestinsation);
            $this->info('Aborting creation.');
            return false;
        }

        $modelFields = '';
        foreach ($this->formFields as $formField) {
            $field = "\t\t\t'{{name}}',\n";
            $field = Str::replace('{{name}}', $formField['name'], $field);
            $modelFields = Str::of($modelFields)->append($field);
        }

        $fileOriginalString = Str::replace('{{class}}', $this->modelName, $this->file->get($fileOrigin));
        $fileOriginalString = Str::replace('{{fields}}', $modelFields, $fileOriginalString);

        $this->file->put($fileDestinsation, $fileOriginalString);
        $this->info('Model file created : ' . $fileDestinsation);
    }
}
