<?php

class supa_modules_example_controls_index extends supa_control {

    public function indexAction()
    {
        /**
         * Basic example of Data output via layout hooks...
         */
        $this->setLayout('content', "<div class=\"heading\">Homepage</div>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet vulputate ipsum. Suspendisse eu elit nec lacus consectetur cursus sit amet sed velit. Donec imperdiet tincidunt luctus. Sed egestas, nunc at feugiat eleifend, arcu libero pretium mauris, nec consequat turpis metus bibendum metus. Suspendisse non erat non tortor dapibus fringilla iaculis et urna. Morbi sodales lobortis placerat. Maecenas nunc justo, fringilla vel condimentum non, consequat vitae quam.</p>
            <p>Donec eu mauris purus. Donec aliquam lacus nec augue aliquet tristique. In hac habitasse platea dictumst. Sed vel mauris ut velit congue lacinia id sed ipsum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque tincidunt nisl vel tellus gravida vitae semper nulla pharetra. Sed gravida sapien id arcu venenatis dignissim. Etiam tincidunt lobortis augue, vitae malesuada nisl pellentesque id. Nulla eget eleifend justo. Aenean facilisis, ipsum in porta consectetur, enim erat tincidunt dui, vel gravida tortor tellus et felis. Donec vel tortor eu diam accumsan adipiscing ac eget est. Sed laoreet neque quis urna molestie iaculis. Phasellus interdum suscipit commodo. Aenean eget dolor sit amet erat pellentesque pulvinar non luctus dolor.</p>
            <p>Proin et velit id mauris pulvinar tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus porta nibh at nulla aliquam semper. Morbi elementum mollis ipsum id egestas. Duis tempus mollis imperdiet. Nullam pellentesque suscipit sem sed tincidunt. Sed nibh leo, cursus nec euismod quis, dictum et urna. In hac habitasse platea dictumst. Etiam volutpat porttitor dapibus. Phasellus ultrices, nulla nec euismod tincidunt, tortor turpis tincidunt dui, vitae condimentum diam sem quis augue. Duis sed felis leo.</p>

        ");
    }

    public function errorAction()
    {
        /**
         * Basic example of Data output via layout hooks...
         */
       $this->setLayout('content', "<div class=\"heading\">Error Page</div>
            <p>Sorry, but the page couldn't be found.</p>
       ");
    }

}