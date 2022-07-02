<?php class_exists('AIBettingEdge\AIBettingEdge\Template') or exit; ?>
<div class="flex flex-col w-full bg-yellow-100">
  <div class="flex title font-semibold"><?php echo $title ?></div>
  <div class="flex mt-5">
<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>
<ul>
  <?php foreach($colors as $color): ?>
  <li><?php echo $color ?></li>
  <?php endforeach; ?>
</ul>
</div>
</div>





