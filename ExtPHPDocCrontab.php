<?php
/**
 * User: Denis Porplenko <denis.porplenko@gmail.com>
 * Date: 15.07.14
 * Time: 23:24
 */
require_once('PHPDocCrontab.php');
class ExtPHPDocCrontab  extends PHPDocCrontab{

    protected function prepareActions()
    {
        $actions = array();
        $methods = Yii::app()->params['cronJobs'];

        if (!empty($methods)) {

            foreach ($methods as $runCommand => $runSettings) {
                $runCommand = explode(' ', $runCommand);
                if (count($runCommand) !== 2) {
                    continue;
                }

                $actions[] = array(
                    'command' => $runCommand[0],
                    'action'  => $runCommand[1],
                    'docs'    => $this->parseDocComment($this->arrayToDocComment($runSettings))
                    );
            }
        }
        return $actions;
    }

    protected function arrayToDocComment(array $runSettings)
    {
        $result = "/**\n";
        foreach ($runSettings as $key => $setting) {
            $result .= '* @' . $key . ' ' . $setting . "\n";
        }
        $result .= "*/\n";

        return $result;
    }
}