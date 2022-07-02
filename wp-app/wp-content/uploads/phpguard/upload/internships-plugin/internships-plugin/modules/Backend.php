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


namespace internships\Internships;

class Backend {

  function __construct() {
    add_action('admin_menu', array($this, 'plugin_menu'));
  }

  // displays plugins menu in wordpress' toolbar, TODO: alter the second string, if you want a more readable name in the backend
  function plugin_menu() {
    //add_menu_page(__('Teams', 'sports-bench'), __('Teams', 'sports-bench'), 'edit_posts', 'add_data', 'sports_bench_teams_form_page_handler', 'dashicons-groups', 6);
    add_menu_page(
      'Internships',
      'Internships',
      'manage_options',
      'approve-internships',
      function () {

        if (!current_user_can('manage_options')) {
          wp_die(__('You currently do not have permission for this action.'));
        }

        global $wpdb;
        $tableName = "InternshipDatabase";

        // Post approve / deny
        if (isset($_POST) && isset($_POST['item_id'])) {
          $id = $_POST['item_id'];
          $approve = null;
          if ($_POST['action'] == "approve") {
            $approve = 1;
          } else {
            $approve = 0;
          }
          $wpdb->update('InternshipsDatabase', array('Approved' => $approve), array('id' => $id));
          echo "<meta http-equiv='refresh' content='0'>";
        };

        // Get submissions requiring approval
        $sql = "SELECT * FROM $tableName WHERE Approved IS NULL";
        $rows = $wpdb->get_results($sql);

        // Test data
        /*
        array_push(
          $rows,

          (object) [
            'id' => 1,
            'arm_member_id' => 'User123',
            'InternshipName' => 'Test Internship',
            'InternshipRegion' => 'United States',
            'InternshipLocation' => 'Colorado',
            'InternshipCategory' => 'Computer Science',
            'InternshipLink' => 'https://test.com',
            'InternshipDeadline' => 'February 12, 2023'
          ],
          (object) [
            'id' => 2,
            'arm_member_id' => 'User325',
            'InternshipName' => 'Test Internship',
            'InternshipRegion' => 'United States',
            'InternshipLocation' => 'California',
            'InternshipCategory' => 'Computer Science',
            'InternshipLink' => 'https://test.com',
            'InternshipDeadline' => 'January 12, 2023'
          ]
        );
        */

        // Entry count
        $entries = count($rows);

        echo "<h1>Internship Submissions</h1>";

        echo '<table class="wp-list-table widefat fixed users">';
        echo '<thead><tr>';
        echo '<th>User</th>';
        echo '<th>Name</th>';
        echo '<th>Region</th>';
        echo '<th>Location</th>';
        echo '<th>Category</th>';
        echo '<th>Link</th>';
        echo '<th>Deadline</th>';
        echo '<th></th>';
        echo '<th></th>';
        echo '</tr></thead>';
        echo '<tbody>';

        // Interships for approval
        if ($entries > 0) {
          for ($x = 0; $entries > $x; $x++) {
            echo "<tr>";

            echo "<td>{$rows[$x]->arm_member_id}</td>";
            echo "<td>{$rows[$x]->InternshipName}</td>";
            echo "<td>{$rows[$x]->InternshipRegion}</td>";
            echo "<td>{$rows[$x]->InternshipLocation}</td>";
            echo "<td>{$rows[$x]->InternshipCategory}</td>";
            echo "<td><a target='_blank' href='{$rows[$x]->InternshipLink}'>{$rows[$x]->InternshipLink}</a></td>";
            echo "<td>{$rows[$x]->InternshipDeadline}</td>";

            // Deny
            echo "<td><form method='post'>";
            echo "<input type='hidden' name='item_id' id='item_id' value='{$rows[$x]->arm_member_id}' />";
            echo "<input type='hidden' name='action' id='action' value='deny' />";
            echo "<button type='submit'>Deny</button>";
            echo "</form></td>";

            // Approve
            echo "<td><form method='post'>";
            echo "<input type='hidden' name='item_id' id='item_id' value='{$rows[$x]->arm_member_id}' />";
            echo "<input type='hidden' name='action' id='action' value='approve' />";
            echo "<button type='submit'>Approve</button>";
            echo "</form></td>";

            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='9'><i>There are no submissions requiring approval.</i></td></tr>";
        }

        echo '</tbody>';
        echo '</table>';
      },
      'data:image/svg+xml;base64,' . base64_encode('<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path fill="black" d="M576 1376v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm0-384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm-512-768v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm-512-768v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm512 384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm0-384v-192q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v192q0 14 9 23t23 9h320q14 0 23-9t9-23zm128-320v1088q0 66-47 113t-113 47h-1344q-66 0-113-47t-47-113v-1088q0-66 47-113t113-47h1344q66 0 113 47t47 113z"/></svg>'),
      2
    );
  }

  function page_handler() {
    // display plugin's options page
    Helper::render_template('admin/options');
  }

  function page_init() {
    echo "<h1>Manage Internships</h1>";
    if (!current_user_can('manage_options')) {
      wp_die(__('You currently do not have permission for this action.'));
    }
  }


  // handle posted option-values
  function handle_options() {
    foreach (Base::$options as $option) {
      $id = $option['id'];
      $new_value = isset($_POST[$id]) ? $_POST[$id] : null;
      switch ($option['type']) {
        case 'text':
          if (isset($new_value))
            update_option($id, $new_value);
          break;

        case 'checkbox':
          update_option($id, isset($new_value));
          break;
      }
    }
  }


  public static function render_option($option) {
    switch ($option['type']) {
      case 'text':
        Helper::render_template('admin/helpers/form_label', $option);
        Helper::render_template('admin/helpers/form_text', $option);
        break;

      case 'checkbox':
        Helper::render_template('admin/helpers/form_label', $option);
        Helper::render_template('admin/helpers/form_checkbox', $option);
        break;
    }
  }
}
