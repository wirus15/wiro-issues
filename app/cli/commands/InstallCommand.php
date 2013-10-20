<?php

use Yiinitializr\Cli\Console;

/**
 * Installs application locally. Setups required directories, local database configuration 
 * and some variables if this is a new project.
 */
class InstallCommand extends CConsoleCommand
{
    private $config = array();

    public function run($args)
    {
        $this->updateConfigVars();
        $this->createDbConfig();
    }
    
    private function updateConfigVars()
    {
        $configDir = Yii::getPathOfAlias('application.config');
        foreach(scandir($configDir) as $configFile) {
            $configFile = "$configDir/$configFile";
            if(is_file($configFile)) {
                $this -> updateConfigFile($configFile);
            }
        }
    }
    
    private function updateConfigFile($file)
    {
        if(!Console::confirm('Update configuration files?')) {
            return;
        }
        
        $variables = array(
            array('APPLICATION_NAME', 'Application name', array('required'=>true)), 
            array('ADMIN_EMAIL', 'Administrator\'s email', array('required'=>true, 'pattern'=>'/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/')),
        );
        
        $content = file_get_contents($file);
        foreach($variables as $config) {
            $var = $config[0];
            if(strpos($content, "{{$var}}") !== false) {
                if(!isset($this->config[$var])) {
                    $value = Console::prompt($config[1], $config[2]);
                    $this->config[$var] = $value;
                }
                $content = str_replace("{{$var}}", $this->config[$var], $content);
            }
        }
        file_put_contents($file, $content);
    }
    
    private function createDbConfig()
    {
        $configFile = Yii::getPathOfAlias('application.config').'/local.php';
        if(file_exists($configFile) || !Console::confirm('Create local database config?')) {
            return;
        }
            
        $dbConfig = array();
        Console::output("Choose database driver:\n[1] sqlite\n[2] mysql");
        $dbType = Console::prompt('', array('required' => true, 'pattern'=>'/1|2/'));
        if($dbType == 1) {
            $sqliteFile = Yii::getPathOfAlias('application.data').'/main.db';
            @mkdir(dirname($sqliteFile), 02777);
            @chmod(dirname($sqliteFile), 02777);
            @chmod($sqliteFile, 02777);
            $dbConfig['connectionString'] = "sqlite:$sqliteFile";
        } else {
            $dbConfig['connectionString'] = sprintf('mysql:host=%s;port=%d;dbname=%s',
                Console::prompt('Database host', array('default' => 'localhost')),
                Console::prompt('Database port', array('default' => 3306)),
                Console::prompt('Database name', array('required' => true))
            );
            $dbConfig['username'] = Console::prompt('Database username', array('required'=>true));
            $dbConfig['password'] = Console::prompt('Password for '.$dbConfig['username']);   
        }
        
        $config = array('components' => array('db' => $dbConfig));
        file_put_contents($configFile, '<?php return '.var_export($config, true).';');
    }
}
