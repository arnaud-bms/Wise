<?php
namespace Telco\Generate;

use \Telco\Component\Component;

/**
 * Generate file
 *
 * @author gdievart
 */
class Generate extends Component 
{
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
        'dir'
    );
    
    /**
     * @var array Directory to generate files
     */
    protected $_dir;
    
    /**
     * @var array alias to list files
     */
    protected $_aliasFile = array();
    
    
    /**
     * Init generate
     * 
     * @param array $config 
     */
    protected function _init($config)
    {
        $this->_dir = $config['dir'];
        if(isset($config['alias'])) {
            $this->setAliasFiles($config['alias']);
        }
    }
    
    
    /**
     * Set alias files
     * 
     * @param array $alias
     */
    public function setAliasFiles($alias)
    {
        $this->_aliasFile = $alias;
    }
    
    
    /**
     * Generate file
     * 
     * @param string $alias
     * @param string $content
     */
    public function generateFile($alias, $content)
    {
        foreach($this->_aliasFile as $pattern => $filename) {
            $pattern = '#'.$pattern.'#';
            if(preg_match($pattern, $alias, $argv)) {
                array_shift($argv);
                foreach($argv as $key => $value) {
                    $filename = str_replace('$'.($key+1), $value, $filename);
                }
                file_put_contents($this->_dir.'/'.$filename, $content);
            }
        }
    }
}