/**
 * Implements hook_batch_alter().
 */
function <?php print $basename; ?>_batch_alter(&\$batch) {
  ${1:// If the current page request is inside the overlay, add ?render=overlay to
  // the success callback URL, so that it appears correctly within the overlay.
  if (overlay_get_mode() == 'child') {
    if (isset(\$batch['url_options']['query'])) {
      \$batch['url_options']['query']['render'] = 'overlay';
    \}
    else {
      \$batch['url_options']['query'] = array('render' => 'overlay');
    \}
  \}}
}

$2