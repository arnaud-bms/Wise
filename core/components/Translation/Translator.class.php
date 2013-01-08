<?php
namespace Telelab\Translation;

use Telelab\Component\Component;
use Telelab\Logger\Logger;
use Telelab\Translation\TranslatorException;

/**
 * Translator: i18n & l10n
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class Translator extends Component
{
    /**
     * @var Translator
     */
    private static $_instance = null;

    /**
     * @var string locale
     */
    protected $_locale;

    /**
     * @var array catalogues files
     */
    protected $_catalogues = array();

    /**
     * @var string
     */
    private $_fallbackLocale  = 'fr';

    /**
     * @var string
     */
    private $_fallbackCatalogue = 'messages';

    /**
     * @var array availables languages
     */
    protected $_availableLocales = array('fr');

    /**
     * @var string lang directory
     */
    protected $_languagePath;

    /**
     * @var array Required fields
     */
    protected $_requiredFields = array(
        'locale',
        'language_path'
    );

    /**
     * Constructor.
     *
     * @param string          $locale   The locale
     */
    protected function _init($config)
    {
        $this->_locale = $config['locale'];
        $this->_languagePath = $config['language_path'];
    }

    /**
     * Get instance Translator
     *
     * @param array $config
     * @return Translator
     */
    public static function getInstance($config = null)
    {
        if (!self::$_instance instanceOf Translator) {
            Logger::log('['.__CLASS__.'] new instance', Logger::LOG_DEBUG);
            self::$_instance = new Translator($config);
        }

        return self::$_instance;
    }

    /**
     * @param string $locale
     *
     */
    public function setLocale($locale)
    {
        $this->_locale = $locale;
    }


    /**
     * @return string locale
     */
    public function getLocale()
    {
        return $this->_locale;
    }


    /**
     * Sets the fallback locale(s).
     *
     * @param string $locale The fallback locale
     */
    public function setFallbackLocale($locale)
    {
        $this->_fallbackLocale = (array)$locale;
    }


    /**
     * Sets the fallback locale(s).
     *
     * @param string $catalogue The fallback catalogue
     */
    public function setFallbackCatalogue($catalogue)
    {
        $this->_fallbackCatalogue = (array)$catalogue;
    }


    /**
     * Set availables locales
     *
     * @param string|array $locales The availables locale(s)
     */
    public function setAvailableLocales($locales)
    {
        $this->_availableLocales = (array)$locales;
    }


    /**
     * @param string $id
     * @param array  $parameters
     * @param string $domain
     * @param string $locale
     *
     * @return string
     */
    public static function translate($id, array $parameters = array(), $catalogue = 'messages', $locale = null)
    {
        $_instance = self::getInstance();

        if (!isset($locale)) {
            $locale = $_instance->getLocale();
        }

        if (!isset($_instance->_catalogues[$catalogue])) {
            $catalogue = $_instance->_loadCatalogue($catalogue);
        }

        return strtr($_instance->_translate($id, $locale, $catalogue), $parameters);
    }

    /**
     * @param string $id
     * @param string $locale
     * @param string $catalogue
     * @throws TranslationException: empty translation
     * @return string translation
     */
    protected function _translate($id, $locale, $catalogue)
    {
        $xml = simplexml_load_file($this->_catalogues[$catalogue]);
        //error_log(print_r($xml));

        $query = '/messages/message[@id=\''.$id.'\']';      
        $result = $xml->xpath($query);

        if (empty($result)) {
            throw new TranslatorException('Empty translation : '.$id);
        }

        if (!isset($result[0]->$locale)) {
            if ($this->fallbackLocale !== $locale) {
                return $this->_translate($id, $this->fallbackLocale, $catalogue);
            } else {
                throw new TranslatorException('Invalid locale : '.$locale);
            }
        }

        return (string) $result[0]->$locale;
    }

    /**
     * @param string $catalogue
     * @throws TranslationException: empty catalogue
     * @return string translation
     */
    protected function _loadCatalogue($catalogue)
    {
        $file = rtrim($this->_languagePath, '/').'/'.$catalogue.'.xml';

        if (file_exists($file)) {
            $this->_catalogues[$catalogue] = $file;
        } else if ($this->fallbackCatalogue !== $catalogue) {
            if (!isset($this->_catalogues[$this->fallbackCatalogue])) {
                $this->_loadCatalogue($this->fallbackCatalogue);
            }

            return $this->fallbackCatalogue;
        } else {
            throw new TranslatorException('Invalid catalogue : '.$catalogue);
        }
        
        return $catalogue;
    }
}