<?php class supa_modules_blog_models_posts extends supa_eav {
/**
 * the eav abstract doesn't need anything to provide models and shizz. It uses this class
 * name as entity name. if this class is ultimately not needed, i think it'll optionally
 * allow for models to be completely module.xml configurable.
 */

    public function getViewUrl($unique)
    {

        if(is_string($unique)) {
            $output = $this->getConfig('path/baseurl').'blog/view/slug/'. (string) $unique;
        } elseif(is_int($unique)) {
            $output = $this->getConfig('path/baseurl').'blog/view/id/'. (string) $unique;
        } else {
            $output = '#';
        }

        return $output;

    }

}