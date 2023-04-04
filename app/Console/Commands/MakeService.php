<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {nameService}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Service class';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    public function getStubPath()
    {
        return dirname(__DIR__, 3) .'/stubs/interface.stub';
    }
    public function getStubVariables()
    {
        return [
            'NAMESPACE'         => 'App\\Http\\Services',
            'CLASS_NAME'        => $this->getSingularClassName($this->argument('nameService')),
        ];
    }

    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    public function getSourceFilePath()
    {
        return base_path('App/Http/Services') .'/' .$this->getSingularClassName($this->argument('nameService')) . 'Service.php';
    }



    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
