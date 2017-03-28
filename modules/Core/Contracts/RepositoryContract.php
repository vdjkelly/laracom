<?php
/**
 * Created by PhpStorm.
 * User: vdjkelly
 * Date: 3/15/2017
 * Time: 9:22 p.m.
 */
namespace Modules\Core\Contracts;

use App\Exceptions\ModuleNotFoundException;
use Modules\Core\Helpers\Collection;
use Modules\Core\Helpers\Module;
use Modules\Core\Helpers\Repository;

interface RepositoryContract
{
    /**
     * Add other module location.
     *
     * @param string $path
     *
     * @return $this
     */
    public function addLocation($path);

    /**
     * Alternative method for "addPath".
     *
     * @param string $path
     *
     * @return $this
     */
    public function addPath($path);

    /**
     * Get all additional paths.
     *
     * @return array
     */
    public function getPaths();

    /**
     * Get scanned modules paths.
     *
     * @return array
     */
    public function getScanPaths();

    /**
     * Get & scan all modules.
     *
     * @return array
     */
    public function scan();

    /**
     * Get all modules.
     *
     * @return array
     */
    public function all();

    /**
     * Get cached modules.
     *
     * @return array
     */
    public function getCached();

    /**
     * Get all modules as collection instance.
     *
     * @return Collection
     */
    public function toCollection();

    /**
     * Get modules by status.
     *
     * @param $status
     *
     * @return array
     */
    public function getByStatus($status);

    /**
     * Determine whether the given module exist.
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * Get list of enabled modules.
     *
     * @return array
     */
    public function enabled();

    /**
     * Get list of disabled modules.
     *
     * @return array
     */
    public function disabled();

    /**
     * Get count from all modules.
     *
     * @return int
     */
    public function count();

    /**
     * Get all ordered modules.
     *
     * @param string $direction
     *
     * @return array
     */
    public function getOrdered($direction = 'asc');

    /**
     * Get a module path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Find a specific module.
     * @param $name
     * @return mixed|void
     */
    public function find($name);

    /**
     * Find a specific module by its alias.
     * @param $alias
     * @return mixed|void
     */
    public function findByAlias($alias);

    /**
     * Find all modules that are required by a module. If the module cannot be found, throw an exception.
     *
     * @param $name
     * @return array
     * @throws ModuleNotFoundException
     */
    public function findRequirements($name);

    /**
     * Alternative for "find" method.
     * @param $name
     * @return mixed|void
     */
    public function get($name);

    /**
     * Find a specific module, if there return that, otherwise throw exception.
     *
     * @param $name
     *
     * @return Module
     *
     * @throws ModuleNotFoundException
     */
    public function findOrFail($name);

    /**
     * Get all modules as laravel collection instance.
     *
     * @return Collection
     */
    public function collections();

    /**
     * Get module path for a specific module.
     *
     * @param $module
     *
     * @return string
     */
    public function getModulePath($module);

    /**
     * Get asset path for a specific module.
     *
     * @param $module
     *
     * @return string
     */
    public function assetPath($module);

    /**
     * Get a specific config data from a configuration file.
     *
     * @param $key
     *
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null);

    /**
     * Get storage path for module used.
     *
     * @return string
     */
    public function getUsedStoragePath();

    /**
     * Set module used for cli session.
     *
     * @param $name
     *
     * @throws ModuleNotFoundException
     */
    public function setUsed($name);

    /**
     * Get module used for cli session.
     *
     * @return string
     */
    public function getUsedNow();

    /**
     * Get used now.
     *
     * @return string
     */
    public function getUsed();

    /**
     * Get laravel filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFiles();

    /**
     * Get module assets path.
     *
     * @return string
     */
    public function getAssetsPath();

    /**
     * Get asset url from a specific module.
     *
     * @param string $asset
     *
     * @return string
     */
    public function asset($asset);

    /**
     * Determine whether the given module is activated.
     *
     * @param string $name
     *
     * @return bool
     */
    public function active($name);

    /**
     * Determine whether the given module is not activated.
     *
     * @param string $name
     *
     * @return bool
     */
    public function notActive($name);

    /**
     * Enabling a specific module.
     *
     * @param string $name
     *
     * @return bool
     */
    public function enable($name);

    /**
     * Disabling a specific module.
     *
     * @param string $name
     *
     * @return bool
     */
    public function disable($name);

    /**
     * Delete a specific module.
     *
     * @param string $name
     *
     * @return bool
     */
    public function delete($name);

    /**
     * Get stub path.
     *
     * @return string
     */
    public function getStubPath();

    /**
     * Set stub path.
     *
     * @param string $stubPath
     *
     * @return $this
     */
    public function setStubPath($stubPath);
}
