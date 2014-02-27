<html>
  <head><title>Personality</title></head>
  <body>

<?php
  $attrs = $_GET['attributes'];
  if (!is_array($attrs)) {
    $attrs = array();
}

function makeCheckboxes($name, $query, $options) {
  foreach ($options as $value => $label) {
    $checked = in_array($value, $query) ? "checked" : '';
    echo "<input type=\"checkbox\" name=\"{$name}\" 
          value=\"{$value}\" {$checked} />";
    echo "{$label}<br />\n"; }
  }

$personalityAttributes = array(
  'perky'=> "Perky",
  'morose'=> "Morose",
  'thinking'=> "Thinking",
  'feeling'=> "Feeling",
  'thrifty'=> "Spend-thrift",
  'prodigal'=> "Shopper"
); ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    Select your personality attributes:<br />
    <?php makeCheckboxes('attributes', $attrs, $personalityAttributes); ?><br />
    <input type="submit" name="s" value="Record my personality!" />
  </form>

<?php if (array_key_exists('s', $_GET)) { 
  $description = join (' ', $_GET['attributes']);
  echo "You have a {$description} personality.";
} ?>

  </body>
</html>