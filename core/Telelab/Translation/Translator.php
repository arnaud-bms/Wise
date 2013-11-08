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
    private static $instance = null;

    /**
     * @var string locale
     */
    protected $locale;

    /**
     * @var array catalogues files
     */
    protected $catalogues = array();

    /**
     * @var string
     */
    private $fallbackLocale  = 'fr';

    /**
     * @var string
     */
    private $fallbackCatalogue = 'messages';

    /**
     * @var array availables languages
     */
    protected $availableLocales = array('fr');

    /**
     * @var string lang directory
     */
    protected $languagePath;

    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'locale',
        'language_path'
    );

    /**
     * Constructor.
     *
     * @param string $locale The locale
     */
    protected function init($config)
    {
        $this->locale = $config['locale'];
        $this->languagePath = $config['language_path'];
    }

    /**
     * Get instance Translator
     *
     * @param  array      $config
     * @return Translator
     */
    public static function getInstance($config = null)
    {
        if (!self::$instance instanceof Translator) {
            Logger::log('['.__CLASS__.'] new instance', Logger::LOG_DEBUG);
            self::$instance = new Translator($config);
        }

        return self::$instance;
    }

    /**
     * Set default locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Return default locale
     *
     * @return string locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Sets the fallback locale(s).
     *
     * @param string $locale The fallback locale
     */
    public function setFallbackLocale($locale)
    {
        $this->fallbackLocale = (array) $locale;
    }

    /**
     * Sets the fallback locale(s).
     *
     * @param string $catalogue The fallback catalogue
     */
    public function setFallbackCatalogue($catalogue)
    {
        $this->fallbackCatalogue = (array) $catalogue;
    }

    /**
     * Set availables locales
     *
     * @param string|array $locales The availables locale(s)
     */
    public function setAvailableLocales($locales)
    {
        $this->availableLocales = (array) $locales;
    }

    /**
     * Return translation for an id
     *
     * @param  string $id
     * @param  array  $parameters
     * @param  string $domain
     * @param  string $locale
     * @return string
     */
    public static function translate($id, array $parameters = array(), $catalogue = 'messages', $locale = null)
    {
        $instance = self::getInstance();

        if (!isset($locale)) {
            $locale = $instance->getLocale();
        }

        if (!isset($instance->catalogues[$catalogue])) {
            $catalogue = $instance->loadCatalogue($catalogue);
        }

        return strtr($instance->_translate($id, $locale, $catalogue), $parameters);
    }

    /**
     * Translate all catalogue
     *
     * @param  stringt $catalogue
     * @param  string  $locale
     * @return array
     */
    public static function translateCatalogue($catalogue = 'messages', $locale = null)
    {
        $instance = self::getInstance();

        if (!isset($locale)) {
            $locale = $instance->getLocale();
        }

        if (!isset($instance->catalogues[$catalogue])) {
            $catalogue = $instance->loadCatalogue($catalogue);
        }

        $fullCatalogue = array();
        foreach ($instance->catalogues[$catalogue]->message as $message) {
            $fullCatalogue[(string) $message['id']] = (string) $message->$locale;
        }

        return $fullCatalogue;
    }

    /**
     * Extract translate from catalogue
     *
     * @param  string                $id
     * @param  string                $locale
     * @param  string                $catalogue
     * @throws TranslationException: empty translation
     * @return string                translation
     */
    protected function _translate($id, $locale, $catalogue)
    {
        $query = '/messages/message[@id=\''.$id.'\']';
        $result = $this->catalogues[$catalogue]->xpath($query);

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
     * @param  string                $catalogue
     * @throws TranslationException: empty catalogue
     * @return string                translation
     */
    protected function loadCatalogue($catalogue)
    {
        $file = rtrim($this->languagePath, '/').'/'.$catalogue.'.xml';

        if (file_exists($file)) {
            $this->catalogues[$catalogue] = simplexml_load_file($file);
        } elseif ($this->fallbackCatalogue !== $catalogue) {
            if (!isset($this->catalogues[$this->fallbackCatalogue])) {
                $this->loadCatalogue($this->fallbackCatalogue);
            }

            return $this->fallbackCatalogue;
        } else {
            throw new TranslatorException('Invalid catalogue : '.$catalogue);
        }

        return $catalogue;
    }
}
