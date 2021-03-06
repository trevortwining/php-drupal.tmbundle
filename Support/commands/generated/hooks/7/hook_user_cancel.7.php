/**
 * Implements hook_user_cancel().
 */
function <?php print $basename; ?>_user_cancel(\$edit, \$account, \$method) {
  ${1:switch (\$method) {
    case 'user_cancel_block_unpublish':
      // Unpublish nodes (current revisions).
      module_load_include('inc', 'node', 'node.admin');
      \$nodes = db_select('node', 'n')
        ->fields('n', array('nid'))
        ->condition('uid', \$account->uid)
        ->execute()
        ->fetchCol();
      node_mass_update(\$nodes, array('status' => 0));
      break;

    case 'user_cancel_reassign':
      // Anonymize nodes (current revisions).
      module_load_include('inc', 'node', 'node.admin');
      \$nodes = db_select('node', 'n')
        ->fields('n', array('nid'))
        ->condition('uid', \$account->uid)
        ->execute()
        ->fetchCol();
      node_mass_update(\$nodes, array('uid' => 0));
      // Anonymize old revisions.
      db_update('node_revision')
        ->fields(array('uid' => 0))
        ->condition('uid', \$account->uid)
        ->execute();
      // Clean history.
      db_delete('history')
        ->condition('uid', \$account->uid)
        ->execute();
      break;
  \}}
}

$2