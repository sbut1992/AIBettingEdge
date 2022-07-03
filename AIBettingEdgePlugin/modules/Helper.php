<?php

namespace AIBettingEdge\AIBettingEdge;

class Helper {

  public static function in_backend() {
    return is_admin() && (!defined("DOING_AJAX") || !DOING_AJAX);
  }

  public static function get_option($option) {
    return get_option(Base::$options[$option]["id"]);
  }

  public static function render_template($name, $option = null) {
    include dirname(dirname(__FILE__)) . "/templates/{$name}.php";
  }

  public static function render_today_pretty_table($data) {
    $html = "";
    $html .= "<div class='flex flex-col w-full max-w-2xl text-sm'>";
    $html .= "<div class='header font-bold'>Today</div>";
    $html .= "<div class='grid grid-cols-2 grid-flow-row gap-2'>";

    // Add data
    foreach ($data as $item) {
      $team_home = $item->team_home;
      $team_away = $item->team_away;
      $logo_dir = "https://aibettingedge.com/wp-content/uploads/logos/mlb/";
      $team_home_logo = $logo_dir . sanitize_title_with_dashes($team_home) . ".png";
      $team_away_logo = $logo_dir . sanitize_title_with_dashes($team_away) . ".png";

      $title = "$team_home vs $team_away";
      $slug = sanitize_title_with_dashes($title);
      $date = explode(' ', $item->game_date, 2);
      $html .= "<div class='w-full p-3'>";
      $html .= "<div class='flex flex-row p-5 rounded-lg shadow-sm hover:shadow-md cursor-pointer transition-all duration-250'>";

      $html .= "<div class='flex flex-col flex-grow ml-4'>"; // Col 1
      $html .= "<div class='flex font-medium items-center my-1'><img class='inline-block w-6 h-6 mr-2' src='$team_home_logo' />$team_home</div>";
      $html .= "<div class='flex font-medium items-center my-1'><img class='inline-block w-6 h-6 mr-2' src='$team_away_logo' />$team_away</div>";
      $html .= "</div>";

      $html .= "<div class='flex flex-col'>"; // Col 2
      $html .= "<div class=''>Today</div>";
      $html .= "<div class=''>" . date("g:i a", strtotime($date[1])) . "</div>";
      $html .= "<div class='mt-3 w-16'><a class='flex justify-center py-1 px-2 font-semibold bg-blue-500 text-white no-underline hover:bg-blue-600 hover:shadow-md rounded-lg transition-all duration-250' href='/{$slug}'>View</a></div>";
      $html .= "</div>";

      $html .= "</div>";
      $html .= "</div>";
    }

    $html .= "</div>";
    $html .= "</div>";

    return $html;
  }

  public static function render_today_table($data) {
    $html = "";
    //$html .= "<div class='flex w-full'>";
    //$html .= "<table class='flex w-full'>";
    $html .= "<table class='table-auto text-left align-middle'>";
    $html .= "<thead>";
    $html .= "<th class='w-32'>Game Date</th>";
    $html .= "<th class='w-32'>Time</th>";
    $html .= "<th>Home Team</th>";
    $html .= "<th>Away Team</th>";
    $html .= "<th class='w-32'>Venue</th>";
    $html .= "<th class='w-32'></th>"; // Actions
    $html .= "</thead>";
    $html .= "<tbody>";

    // Add data
    foreach ($data as $item) {
      $team_home = $item->team_home;
      $team_away = $item->team_away;
      $title = "$team_home vs $team_away";
      $slug = sanitize_title_with_dashes($title);
      $date = explode(' ', $item->game_date, 2);
      $html .= "<tr>";
      $html .= "<td>{$date[0]}</td>";
      $html .= "<td>{$date[1]}</td>";
      $html .= "<td>{$item->team_home}</td>";
      $html .= "<td>{$item->team_away}</td>";
      $html .= "<td> Test Venue </td>";
      $html .= "<td><a href='/{$slug}'>View Matchup</a></td>";
      $html .= "</tr>";
    }

    $html .= "</tbody>";
    $html .= "</table>";
    //$html .= "</div>";

    return $html;
  }
}
