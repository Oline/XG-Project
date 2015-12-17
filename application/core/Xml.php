<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 3.0.0
 */

/**
 *
 * @author Jstar
 * @version v2
 * @tutorial
 *   $newClass=xml::getInstance('config.xml');
 *   echo $newClass->get_config('version');
 *   $newClass->writeConfig('version','blabla');
 *   echo $newClass->get_config('version');
 */

if ( ! defined ( 'INSIDE' ) ) { die ( header ( 'location:../../' ) ) ; }

class Xml
{
    //an istance of this class: see singleton pattern
    private static $instance = null;
    //the complete path to xml config: used to load and save it
    private $path;
    //SimpleXMLElement object that rappresent xml config
    private $config;

    /**
     * xml::__construct()
     * Constructor: access is private to enable class istancing only by getInstance() method, to ensure better performace
     *
     * @param String $sheet
     * @return null
     */
    private function __construct($sheet)
    {
        $this->path = XGP_ROOT . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $sheet;
        $this->config = simplexml_load_file($this->path);
    }

    /**
     * xml::doXpathQuery()
     * This function execute a Xpath query
     *
     * @param String $query
     * @return Array
     */
    public function doXpathQuery($query)
    {
        return $this->config->xpath($query);
    }

    /**
     * xml::getXmlEntity()
     * Search in the xml for a entity rappresented by $configName
     *
     * @param String $configName: the key
     * @return SimpleXMLElement object
     */
    private function getXmlEntity($configName)
    {
        //searching inside <configurations> and where config name=$configName
        $result = $this->doXpathQuery('/configurations/config[name="' . $configName . '"]');
        //if multiple result are returned so key is not unique
        if (!$result || count($result) !== 1)
        {
            throw new Exception(sprintf('Item with id "%s" does not exists or is not unique.', $configName));
        }
        list($result) = $result;
        return $result;
    }

    /**
     * xml::getConfig()
     * This function search in loaded xml for a value according to specific configuration name passed
     *
     * @param String $configName
     * @return String: the configuration value of given key
     */
    public function getConfig($configName)
    {
        // (string) is a cast to String type from SimpleXMLElement object: we need this to extract value
        return (string) $this->getXmlEntity($configName)->value;
    }

    /**
     * xml::getConfigs()
     * This function return all configurations loaded from xml file
     *
     * @return Array: an associative array of key-value
     */
    public function getConfigs()
    {
        $config = array();
        $xmlChildren = $this->config->children();
        foreach ($xmlChildren as $xmlObject)
        {
            $config[(string) $xmlObject->name] = (string) $xmlObject->value;
        }
        return $config;
    }

    /**
     * xml::writeConfig()
     * This function write the xml configuration file updating one or multiple key-value at time
     *
     * @param mixed $configName : String for single update or an associative array of key=>value
     * @param String $configValue : The value that will be setted in corrispective key $configName
     * @return null
     */
    public function writeConfig($configName, $configValue)
    {
        //if $configName is an array, then we wont update all values and do single save task at the end
        if (is_array($configName))
        {
            foreach ($configName as $key => $value)
            {
                $this->getXmlEntity($key)->value = $value;
            }
        }
        else
        {
            $this->getXmlEntity($configName)->value = $configValue;
        }
        $this->config->asXML($this->path);
    }

    /**
     * xml::getInstance()
     * Static function used to istance this class: implements singleton pattern to avoid multiple xml parsing.
     *
     * @param String $sheet : the complete name of xml configuration file.
     * @return xml object
     */
    public static function getInstance($sheet)
    {
        if (self::$instance == null)
        {
            //make new istance of this class and save it to field for next usage
            $newClass = __class__;
            self::$instance = new $newClass($sheet);
        }

        return self::$instance;
    }
}

/* end of Xml.php */
