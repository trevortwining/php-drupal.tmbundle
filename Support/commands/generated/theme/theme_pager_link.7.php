/**
 * Implements theme_pager_link().
 */
function <?php print $basename; ?>_pager_link(\$variables) {
  ${1:\$text = \$variables['text'];
  \$page_new = \$variables['page_new'];
  \$element = \$variables['element'];
  \$parameters = \$variables['parameters'];
  \$attributes = \$variables['attributes'];

  \$page = isset(\$_GET['page']) ? \$_GET['page'] : '';
  if (\$new_page = implode(',', pager_load_array(\$page_new[\$element], \$element, explode(',', \$page)))) {
    \$parameters['page'] = \$new_page;
  \}

  \$query = array();
  if (count(\$parameters)) {
    \$query = drupal_get_query_parameters(\$parameters, array());
  \}
  if (\$query_pager = pager_get_query_parameters()) {
    \$query = array_merge(\$query, \$query_pager);
  \}

  // Set each pager link title
  if (!isset(\$attributes['title'])) {
    static \$titles = NULL;
    if (!isset(\$titles)) {
      \$titles = array(
        t('« first') => t('Go to first page'),
        t('‹ previous') => t('Go to previous page'),
        t('next ›') => t('Go to next page'),
        t('last »') => t('Go to last page'),
      );
    \}
    if (isset(\$titles[\$text])) {
      \$attributes['title'] = \$titles[\$text];
    \}
    elseif (is_numeric(\$text)) {
      \$attributes['title'] = t('Go to page @number', array('@number' => \$text));
    \}
  \}

  return l(\$text, \$_GET['q'], array('attributes' => \$attributes, 'query' => \$query));}
}

$2