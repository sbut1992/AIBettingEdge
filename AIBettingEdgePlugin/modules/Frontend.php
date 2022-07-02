<?php
/*
 * ******************************************************************
 * Copyright (c) 2014 Pierre Beitz <pb@naymspace.de>, naymspace
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * ******************************************************************
 */


namespace AIBettingEdge\AIBettingEdge;

use Exception;

class Frontend {

  function __construct() {
    add_action('wp_enqueue_scripts', array($this, 'register_assets'));
    // Add custom REST API endpoint
    add_action('rest_api_init', function () {
      register_rest_route('api/v1', '/generate-pages', [
        'methods' => 'GET',
        'callback' => [$this, 'generate_pages'],
      ]);
    });
    // if Helper::get_option('someCheckboxOption'){
    //  add_action('wp_footer', function(){ Helper::render_template('myTemplate'); }); // render some template in the footer
    // }
  }

  function generate_pages($data) {

    try {
      // Setup
      global $wpdb;
      $todayPageTitle = "Today's MLB Schedule";
      $date = $data['date'];

      // Query
      $query = "SELECT * FROM Games WHERE DATE_FORMAT(game_date, '%Y-%m-%d') = '$date';";
      $result = $wpdb->get_results($query);

      // Generate Today's Schedule
      $pageId = null;
      $pageExists =  get_page_by_title($todayPageTitle);
      if ($pageExists) {
        $pageId = $pageExists->ID;
      }

      $content = Helper::render_today_pretty_table($result);

      $page = array(
        'ID' => $pageId,
        'post_title' => $todayPageTitle,
        'post_name' => 'todays-mlb-schedule',
        'post_content' => $content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'page',
        'filter' => true
      );

      if (empty($pageExists)) {
        wp_insert_post($page);
      } else {
        wp_update_post($page);
      }

      // Generate pages
      foreach ($result as $item) {
        try {
          $title = "$item->team_home vs $item->team_away";
          $slug = sanitize_title_with_dashes($title);

          $postId = null;
          $postExists = get_page_by_title($title, OBJECT, 'post');

          if ($postExists) {
            $postId = $postExists->ID;
          }

          $post = array(
            'ID' => $postId,
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_content' => $title
          );

          if (empty($postExists)) {
            wp_insert_post($post);
          } else {
            wp_update_post($post);
          }
        } catch (Exception $e) {
          return $e;
        }
      }
    } catch (Exception $e) {
      return $e;
    }

    return $result;
  }

  // load your scripts and styles
  function register_assets() {
    $this->add_script('main'); // adds scripts/main.js
    $this->add_style('main'); // adds stylesheets/main.css
  }

  private function add_style($name) {
    wp_register_style(__NAMESPACE__ . "-style-{$name}", plugins_url("/../stylesheets/{$name}.css", __FILE__));
    wp_enqueue_style(__NAMESPACE__ . "-style-{$name}");
  }

  private function add_script($name, $dependencies = array(), $version = "1.0", $include_in_footer = true) {
    wp_register_script(__NAMESPACE__ . "-script-{$name}", plugins_url("/../scripts/{$name}.js", __FILE__), $dependencies, $version, $include_in_footer);
    wp_enqueue_script(__NAMESPACE__ . "-script-{$name}");
  }
}
