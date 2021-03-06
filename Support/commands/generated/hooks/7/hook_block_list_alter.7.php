/**
 * Implements hook_block_list_alter().
 */
function <?php print $basename; ?>_block_list_alter(&\$blocks) {
  ${1:global \$language, \$theme_key;

  // This example shows how to achieve language specific visibility setting for
  // blocks.

  \$result = db_query('SELECT module, delta, language FROM {my_table\}');
  \$block_languages = array();
  foreach (\$result as \$record) {
    \$block_languages[\$record->module][\$record->delta][\$record->language] = TRUE;
  \}

  foreach (\$blocks as \$key => \$block) {
    // Any module using this alter should inspect the data before changing it,
    // to ensure it is what they expect.
    if (!isset(\$block->theme) || !isset(\$block->status) || \$block->theme != \$theme_key || \$block->status != 1) {
      // This block was added by a contrib module, leave it in the list.
      continue;
    \}

    if (!isset(\$block_languages[\$block->module][\$block->delta])) {
      // No language setting for this block, leave it in the list.
      continue;
    \}

    if (!isset(\$block_languages[\$block->module][\$block->delta][\$language->language])) {
      // This block should not be displayed with the active language, remove
      // from the list.
      unset(\$blocks[\$key]);
    \}
  \}}
}

$2