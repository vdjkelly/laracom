<?php

namespace Modules\Core\Console\Commands;

use Modules\Core\Helpers\Repository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GenerateModules
 * @package App\Console\Commands
 */
class GenerateModules extends Command
{

    /**
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * @var string
     */
    protected $name = 'module:make';

    /**
     * @var string
     */
    protected $description = 'Generate new module.';

    /**
     * @var Repository
     */
    protected $module;

    /**
     * @var
     */
    protected $force;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * GenerateModules constructor.
     * @param Repository|null $module
     * @param Filesystem $files
     */
    public function __construct(Repository $module = null, Filesystem $files)
    {
        parent::__construct();
        $this->module = $module;
        $this->files = $files;
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'The names of modules will be created.'),
        );
    }

    /**
     *Ejecuta el codigo de la consola
     */
    public function handle()
    {
        $this->generate();
    }

    /**
     * @return string
     */
    public function getNameModule()
    {
        return Str::studly($this->argument('name'));
    }

    /**
     *Generador de Carpetas y Archivos
     */
    public function generate()
    {
        $name = $this->getNameModule();

        if ($this->module->has($name)) {
            if ($this->force) {
                $this->module->delete($name);
            } else {
                //Error en la consola si el modulo existe
                $this->error("El modulo [{$name}] ya existe!");
                return;
            }
        }
        //Generadores
        $this->getGenerateFolders();
        $this->getGenerateConfig();
        $this->getGenerateSeeder();
        $this->getGenerateControllers();
        $this->getGenerateRoute();
        $this->getGenerateProviders();
        $this->getGenerateResources();
        $this->getGenerateComposer();
        $this->getGenerateModule();
        $this->getGenerateStart();

        $this->info("El modulo [{$name}] a sido creado de manera correcta.");
    }

    /**
     * @return array
     */
    public function getFolders()
    {
        return array_values($this->module->config('paths.generator'));
    }

    /**
     *
     */
    protected function getGenerateFolders()
    {
        foreach ($this->getFolders() as $folder) {
            $path = $this->module->getModulePath($this->getNameModule()) . '/' . $folder;
            //Permisos a los directorios 755
            $this->files->makeDirectory($path, 0755, true);

        }
    }

    /**
     *
     */
    protected function getGenerateConfig()
    {
        $configStub = $this->files->get(__DIR__ . '/stubModules/scaffold/config.stub');
        $configStub = str_replace('STUDLY_NAME', studly_case($this->getNameModule()), $configStub);
        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/Config/config.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/Config/config.php'), $configStub);
        }
    }

    /**
     *
     */
    protected function getGenerateSeeder()
    {
        $seederStub = $this->files->get(__DIR__ . '/stubModules/seeder.stub');
        $seederStub = str_replace('CLASS_NAME', studly_case($this->getNameModule()).'DatabaseSeeder', $seederStub);
        $seederStub = str_replace('NAMESPACE', studly_case($this->getNameModule()), $seederStub);

        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/Database/Seeders/'. $this->getNameModule() . 'DatabaseSeeder.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/Database/Seeders/'. $this->getNameModule() . 'DatabaseSeeder.php'), $seederStub);
        }
    }

    /**
     *
     */
    protected function getGenerateControllers()
    {
        $controllerStub = $this->files->get(__DIR__ . '/stubModules/controller.stub');
        $controllerStub = str_replace('CLASS_NAME', studly_case($this->getNameModule()).'Controller', $controllerStub);
        $controllerStub = str_replace('NAMESPACE', studly_case($this->getNameModule()), $controllerStub);
        $controllerStub = str_replace('LOWER_NAME', strtolower($this->getNameModule()), $controllerStub);
        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/Http/Controllers/'. $this->getNameModule() . 'Controller.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/Http/Controllers/'. $this->getNameModule() . 'Controller.php'), $controllerStub);
        }

    }

    /**
     *
     */
    protected function getGenerateRoute()
    {
        $routesStub = $this->files->get(__DIR__ . '/stubModules/routes.stub');
        $routesStub = str_replace('LOWER_NAME', strtolower($this->getNameModule()), $routesStub);
        $routesStub = str_replace('STUDLY_NAME', studly_case($this->getNameModule()), $routesStub);
        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/Http/routes.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/Http/routes.php'), $routesStub);
        }
    }

    /**
     *
     */
    protected function getGenerateProviders()
    {
        $providersStub = $this->files->get(__DIR__ . '/stubModules/scaffold/provider.stub');
        $providersStub = str_replace('CLASS_NAME', studly_case($this->getNameModule()).'ServiceProvider', $providersStub);
        $providersStub = str_replace('NAMESPACE', studly_case($this->getNameModule()), $providersStub);
        $providersStub = str_replace('LOWER_NAME', strtolower($this->getNameModule()), $providersStub);
        $providersStub = str_replace('PATH_VIEWS', 'Resources/views', $providersStub);
        $providersStub = str_replace('PATH_LANG', 'Resources/lang', $providersStub);
        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/Providers/'. $this->getNameModule() . 'ServiceProvider.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/Providers/'. $this->getNameModule() . 'ServiceProvider.php'), $providersStub);
        }
    }

    /**
     *
     */
    protected function getGenerateResources()
    {
        $resourcesStubIndex = $this->files->get(__DIR__ . '/stubModules/views/index.stub');
        $resourcesStubMaster = $this->files->get(__DIR__ . '/stubModules/views/master.stub');

        $resourcesStubIndex = str_replace('LOWER_NAME', strtolower($this->getNameModule()), $resourcesStubIndex);
        $resourcesStubIndex = str_replace('STUDLY_NAME', studly_case($this->getNameModule()), $resourcesStubIndex);


        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/Resources/views/index.blade.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/Resources/views/index.blade.php'), $resourcesStubIndex);
        }

        $resourcesStubMaster = str_replace('LOWER_NAME', strtolower($this->getNameModule()), $resourcesStubMaster);
        $resourcesStubMaster = str_replace('STUDLY_NAME', studly_case($this->getNameModule()), $resourcesStubMaster);

        if(!is_dir(base_path('modules/'.$this->getNameModule() . '/Resources/views/layouts/'))){
            mkdir(base_path('modules/'. $this->getNameModule() . '/Resources/views/layouts/'));
        }

        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/Resources/views/layouts/master.blade.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/Resources/views/layouts/master.blade.php'), $resourcesStubMaster);
        }


    }

    /**
     *
     */
    protected function getGenerateComposer()
    {
        $composerStub = $this->files->get(__DIR__ . '/stubModules/composer.stub');
        $composerStub = str_replace('LOWER_NAME', $this->module->config('composer.vendor').'/'. strtolower($this->getNameModule()), $composerStub);
        $composerStub = str_replace('AUTHOR_NAME', $this->module->config('composer.author.name'), $composerStub);
        $composerStub = str_replace('AUTHOR_EMAIL', $this->module->config('composer.author.email'), $composerStub);
        $composerStub = str_replace('STUDLY_NAME', $this->getNameModule(), $composerStub);
        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/composer.json'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/composer.json'), $composerStub);
        }
    }

    /**
     *
     */
    protected function getGenerateModule()
    {
        $modulesStub = $this->files->get(__DIR__ . '/stubModules/modules.stub');
        $modulesStub = str_replace('STUDLY_NAME',  studly_case($this->getNameModule()), $modulesStub);
        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/module.json'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/module.json'), $modulesStub);
        }
    }

    /**
     *
     */
    protected function getGenerateStart()
    {
        $startStub = $this->files->get(__DIR__ . '/stubModules/start.stub');
        if (!$this->files->exists(base_path('modules/'. $this->getNameModule() . '/start.php'))) {
            $this->files->put(base_path('modules/'. $this->getNameModule() . '/start.php'), $startStub);
        }
    }

}
