<?php
function get_production_version($versions) {
    $production_versions = array();
    foreach ($versions as $version) {
        if (strpos($version, '-') !== false) {
            $parts = explode('-', $version);
            $is_production = true;
            foreach ($parts as $part) {
                if (strpos($part, 'dev') === 0 || strpos($part, 'test') === 0 || strpos($part, 'integration') === 0) {
                    $is_production = false;
                    break;
                }
            }
            if ($is_production) {
                $production_versions[] = $version;
            }
        }
    }
    if (count($production_versions) > 0) {
        return $production_versions[0];
    } else {
        return null;
    }
}
$versions = array(
    "2.5.0-dev.1",
    "2.4.2-5354",
    "2.4.2-test.675",
    "2.4.1-integration.1"
);
$production_version = get_production_version($versions);
?>
<footer>
  <div style="text-align: left;">
    <p>Product version: <?php echo $production_version; ?></p>
  </div>
</footer>