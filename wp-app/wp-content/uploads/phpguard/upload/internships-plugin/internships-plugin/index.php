<?php
/*
Plugin Name: Internships
Version: 0.0.3
*/

/*
 * ******************************************************************
 * Copyright (c) 2014 Pierre Beitz <pb@naymspace.de>, naymspace
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * ******************************************************************
 */

namespace internships\Internships;

class Base {

  // options to be set in the admin-area

  public static $options = array(
    'someTextOption' => array(
      'id'      => 'internships\Internships-point-weight',
      'title'   => 'Point weight',
      'type'    => 'text',
      'default' => 1
    )
  );


  function __construct() {
    spl_autoload_register(array($this, 'plugin_autoloader'));
    register_activation_hook(__FILE__, array($this, 'activate_plugin'));

    if (Helper::in_backend()) {
      new Backend();
    }

    if (!Helper::in_backend()) {
      new Frontend();
    }
  }

  function plugin_autoloader($class) {
    $dir = dirname(__FILE__);
    $namespace = explode('\\', $class);
    $className = $namespace[count($namespace) - 1];

    if (file_exists("{$dir}/modules/{$className}.php")) {
      require_once "{$dir}/modules/{$className}.php";
    }
  }

  function activate_plugin() {
    foreach (Base::$options as $option) {
      if ($option['default'] && null !== (get_option($option['id']))) {
        update_option($option['id'], $option['default']);
      }
    }
  }
}

new Base();
