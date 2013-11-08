<?php
namespace Telelab\Translation;

use Telelab\Component\Component;

/**
 * TranslatorHelper: i18n & l10n
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class TranslatorHelper extends Component
{

    /**
     * Constructor
     *
     * @param array $config
     */
    protected function init($config)
    {
        parent::init($config);
    }

    /**
     * Get instance Translator
     *
     * @param  string     $lang
     * @return Translator
     */
    public static function handle($lang)
    {
        $html = '<script type="text/javascript" src="/js/telelab/telelab.lang.js"></script>'
              . '<script type="text/javascript">'
              . 'lang.load('.$lang.');'
              . '</script>';

        return $html;
    }
}
