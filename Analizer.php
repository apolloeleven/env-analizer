<?php
/**
 * User: sai
 * Date: 4/2/18
 * Time: 1:24 PM
 * @author Saiat Kalbiev <kalbievich11@gmail.com>
 */

namespace apollo11\envAnalizer;


use Composer\Script\Event;

class Analizer
{

    /**
     * @param Event $event
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @throws exceptions\FileNotFoundException
     * @throws exceptions\InvalidFileException
     */
    public static function analizeEnv(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();

        if (!isset($extras['apollo11-parameters'])) {
            throw new \InvalidArgumentException('The parameter handler needs to be configured through the extra.apollo11-parameters setting.');
        }
        $configs = $extras['apollo11-parameters'];

        if (!is_array($configs) || empty($configs)) {
            throw new \InvalidArgumentException('The extra.apollo11-parameters setting must be an array that should contain `env-path` and `env-dist-path`.');
        }

        if(isset($configs['env-path']) && isset($configs['env-dist-path'])) {
            $analizer = new Env($configs['env-path'],$configs['env-dist-path']);
            $analizer->checkMissingVariables();

        } else {
            throw new \InvalidArgumentException('Either `env-path` or `env-dist-path` was not found.');
        }

    }


}