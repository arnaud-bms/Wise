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
     * @param string $locale   The locale
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
     * Set default locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->_locale = $locale;
    }


    /**
     * Return default locale
     *
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
     * Return translation for an id
     *
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
     * Translate all catalogue
     *
     * @param stringt $catalogue
     * @param string $locale
     * @return array
     */
    public static function translateCatalogue($catalogue = 'messages', $locale = null)
    {
        $_instance = self::getInstance();

        if (!isset($locale)) {
            $locale = $_instance->getLocale();
        }

        if (!isset($_instance->_catalogues[$catalogue])) {
            $catalogue = $_instance->_loadCatalogue($catalogue);
        }

        $fullCatalogue = array();
        foreach ($_instance->_catalogues[$catalogue]->message as $message) {
            $fullCatalogue[(string)$message['id']] = (string)$message->$locale;
        }

        return $fullCatalogue;
    }


    /**
     * Extract translate from catalogue
     *
     * @param string $id
     * @param string $locale
     * @param string $catalogue
     * @throws TranslationException: empty translation
     * @return string translation
     */
    protected function _translate($id, $locale, $catalogue)
    {
        $query = '/messages/message[@id=\''.$id.'\']';
        $result = $this->_catalogues[$catalogue]->xpath($query);

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
     * Load catalogue
     *
     * @param string $catalogue
     * @throws TranslationException: empty catalogue
     * @return string translation
     */
    protected function _loadCatalogue($catalogue)
    {
        $file = rtrim($this->_languagePath, '/').'/'.$catalogue.'.xml';

        if (file_exists($file)) {
            $this->_catalogues[$catalogue] = simplexml_load_file($file);
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