<?php

namespace AIBettingEdge\AIBettingEdge; ?>

<div class="wrap">
  <h2>Options</h2>

  <div class="test font-bold">This is where you could setup configurable plugin settings.</div>

  <form method="post" action="">
    <table class="form-table">
      <tbody>
        <?php foreach (Base::$options as $option) : // display options defined in plugins index.php
        ?>
          <tr valign='top'>
            <?php Backend::render_option($option); ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p class="submit">
      <input type="submit" class="button-primary" value="Save" />
    </p>
  </form>
</div>
