/**
 * Implements theme_simpletest_test_table().
 */
function <?php print $basename; ?>_simpletest_test_table(\$variables) {
  ${1:\$table = \$variables['table'];

  drupal_add_css(drupal_get_path('module', 'simpletest') . '/simpletest.css');
  drupal_add_js(drupal_get_path('module', 'simpletest') . '/simpletest.js');
  drupal_add_js('misc/tableselect.js');

  // Create header for test selection table.
  \$header = array(
    array('class' => array('select-all')),
    array('data' => t('Test'), 'class' => array('simpletest_test')),
    array('data' => t('Description'), 'class' => array('simpletest_description')),
  );

  // Define the images used to expand/collapse the test groups.
  \$js = array(
    'images' => array(
      theme('image', array('path' => 'misc/menu-collapsed.png', 'alt' => t('Expand'), 'title' => t('Expand'))) . ' <a href="#" class="simpletest-collapse">(' . t('Expand') . ')</a>',
      theme('image', array('path' => 'misc/menu-expanded.png', 'alt' => t('Collapse'), 'title' => t('Collapse'))) . ' <a href="#" class="simpletest-collapse">(' . t('Collapse') . ')</a>',
    ),
  );

  // Cycle through each test group and create a row.
  \$rows = array();
  foreach (element_children(\$table) as \$key) {
    \$element = &\$table[\$key];
    \$row = array();

    // Make the class name safe for output on the page by replacing all
    // non-word/decimal characters with a dash (-).
    \$test_class = strtolower(trim(preg_replace("/[^\w\d]/", "-", \$key)));

    // Select the right "expand"/"collapse" image, depending on whether the
    // category is expanded (at least one test selected) or not.
    \$collapsed = !empty(\$element['#collapsed']);
    \$image_index = \$collapsed ? 0 : 1;

    // Place-holder for checkboxes to select group of tests.
    \$row[] = array('id' => \$test_class, 'class' => array('simpletest-select-all'));

    // Expand/collapse image and group title.
    \$row[] = array(
      'data' => '<div class="simpletest-image" id="simpletest-test-group-' . \$test_class . '"></div>' .
        '<label for="' . \$test_class . '-select-all" class="simpletest-group-label">' . \$key . '</label>',
      'class' => array('simpletest-group-label'),
    );

    \$row[] = array(
      'data' => '&nbsp;',
      'class' => array('simpletest-group-description'),
    );

    \$rows[] = array('data' => \$row, 'class' => array('simpletest-group'));

    // Add individual tests to group.
    \$current_js = array(
      'testClass' => \$test_class . '-test',
      'testNames' => array(),
      'imageDirection' => \$image_index,
      'clickActive' => FALSE,
    );

    // Sorting \$element by children's #title attribute instead of by class name.
    uasort(\$element, '_simpletest_sort_by_title');

    // Cycle through each test within the current group.
    foreach (element_children(\$element) as \$test_name) {
      \$test = \$element[\$test_name];
      \$row = array();

      \$current_js['testNames'][] = \$test['#id'];

      // Store test title and description so that checkbox won't render them.
      \$title = \$test['#title'];
      \$description = \$test['#description'];

      \$test['#title_display'] = 'invisible';
      unset(\$test['#description']);

      // Test name is used to determine what tests to run.
      \$test['#name'] = \$test_name;

      \$row[] = array(
        'data' => drupal_render(\$test),
        'class' => array('simpletest-test-select'),
      );
      \$row[] = array(
        'data' => '<label for="' . \$test['#id'] . '">' . \$title . '</label>',
        'class' => array('simpletest-test-label'),
      );
      \$row[] = array(
        'data' => '<div class="description">' . \$description . '</div>',
        'class' => array('simpletest-test-description'),
      );

      \$rows[] = array('data' => \$row, 'class' => array(\$test_class . '-test', (\$collapsed ? 'js-hide' : '')));
    \}
    \$js['simpletest-test-group-' . \$test_class] = \$current_js;
    unset(\$table[\$key]);
  \}

  // Add js array of settings.
  drupal_add_js(array('simpleTest' => \$js), 'setting');

  if (empty(\$rows)) {
    return '<strong>' . t('No tests to display.') . '</strong>';
  \}
  else {
    return theme('table', array('header' => \$header, 'rows' => \$rows, 'attributes' => array('id' => 'simpletest-form-table')));
  \}}
}

$2