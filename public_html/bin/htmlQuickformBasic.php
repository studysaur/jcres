<?php
/**
 * Usage example for HTML_QuickForm2 package: basic elements
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <style type="text/css">
/* Set up custom font and form width */
body {
    margin-left: 10px;
    font-family: Arial,sans-serif;
    font-size: small;
}
.quickform {
    min-width: 500px;
    max-width: 600px;
    width: 560px;
}
/* Use default styles included with the package */
<?php
if ('@data_dir@' != '@' . 'data_dir@') {
    $filename = '@data_dir@/HTML_QuickForm2/quickform.css';
} else {
//    $filename = dirname(dirname(dirname(__FILE__))) . '/data/quickform.css';
}
//readfile($filename);
?>
    </style>
    <title>HTML_QuickForm2 basic elements example</title>
  </head>
  <body>
<?php
$options = array(
    'a' => 'Letter A', 'b' => 'Letter B', 'c' => 'Letter C',
    'd' => 'Letter D', 'e' => 'Letter E', 'f' => 'Letter F'
);
$main = array("Pop", "Rock", "Classical");
$secondary = array(
    array(0 => "Belle & Sebastian", 1 => "Elliot Smith", 2 => "Beck"),
    array(3 => "Noir Desir", 4 => "Violent Femmes"),
    array(5 => "Wagner", 6 => "Mozart", 7 => "Beethoven")
);
require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';
$form = new HTML_QuickForm2('elements');
// data source with default values:
$form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
    'textTest'        => 'Some text',
    'areaTest'        => "Some text\non multiple lines",
    'userTest'        => 'luser',
    'selSingleTest'   => 'f',
    'selMultipleTest' => array('b', 'c'),
    'boxTest'         => '1',
    'radioTest'       => '2',
    'testDate'        => time(),
    'testHierselect'  => array(2, 5)
)));
// text input elements
$fsText = $form->addElement('fieldset')->setLabel('Text boxes');
$fsText->addElement(
    'text', 'textTest', array('style' => 'width: 300px;'), array('label' => 'Test Text:')
);
$fsText->addElement(
    'password', 'pwdTest', array('style' => 'width: 300px;'), array('label' => 'Test Password:')
);
$area = $fsText->addElement(
    'textarea', 'areaTest', array('style' => 'width: 300px;', 'cols' => 50, 'rows' => 7),
    array('label' => 'Test Textarea:')
);
$fsNested = $form->addElement('fieldset')->setLabel('Nested fieldset');
$fsNested->addElement(
    'text', 'userTest', array('style' => 'width: 200px'), array('label' => 'Username:')
);
$fsNested->addElement(
    'password', 'passTest', array('style' => 'width: 200px'), array('label' => 'Password:')
);
// Now we move the fieldset into another fieldset!
$fsText->insertBefore($fsNested, $area);
// selects
$fsSelect = $form->addElement('fieldset')->setLabel('Selects');
$fsSelect->addElement(
    'select', 'selSingleTest', null, array('options' => $options, 'label' => 'Single select:')
);
$fsSelect->addElement(
    'select', 'selMultipleTest', array('multiple' => 'multiple', 'size' => 4),
    array('options' => $options, 'label' => 'Multiple select:')
);
// checkboxes and radios
$fsCheck = $form->addElement('fieldset')->setLabel('Checkboxes and radios');
$fsCheck->addElement(
    'checkbox', 'boxTest', null, array('content' => 'check me', 'label' => 'Test Checkbox:')
);
$fsCheck->addElement(
    'radio', 'radioTest', array('value' => 1), array('content' => 'select radio #1', 'label' => 'Test radio:')
);
$fsCheck->addElement(
    'radio', 'radioTest', array('value' => 2), array('content' => 'select radio #2', 'label' => '(continued)')
);
$fsCustom = $form->addElement('fieldset')->setLabel('Custom elements');
$fsCustom->addElement(
    'date', 'testDate', null,
    array('format' => 'd-F-Y', 'minYear' => date('Y'), 'maxYear' => 2001)
)->setLabel('Today is:');
$fsCustom->addElement('hierselect', 'testHierselect', array('style' => 'width: 20em;'))
         ->setLabel('Hierarchical select:')
         ->loadOptions(array($main, $secondary))
         ->setSeparator('<br />');
// buttons
$fsButton = $form->addElement('fieldset')->setLabel('Buttons');
$testReset = $fsButton->addElement(
    'reset', 'testReset', array('value' => 'This is a reset button')
);
$fsButton->addElement(
    'inputbutton', 'testInputButton',
    array('value' => 'Click this button', 'onclick' => "alert('This is a test.');")
);
$fsButton->addElement(
    'button', 'testButton', array('onclick' => "alert('Almost nothing');", 'type' => 'button'),
    array('content' => '<img src="http://pear.php.net/gifs/pear-icon.gif" '.
        'width="32" height="32" alt="pear" />This button does almost nothing')
);
// submit buttons in nested fieldset
$fsSubmit = $fsButton->addElement('fieldset')->setLabel('These buttons can submit the form');
$fsSubmit->addElement(
    'submit', 'testSubmit', array('value' => 'Test Submit')
);
$fsSubmit->addElement(
    'button', 'testSubmitButton', array('type' => 'submit'),
     array('content' => '<img src="http://pear.php.net/gifs/pear-icon.gif" '.
        'width="32" height="32" alt="pear" />This button submits')
);
$fsSubmit->addElement(
    'image', 'testImage', array('src' => 'http://pear.php.net/gifs/pear-icon.gif')
);
// outputting form values
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    echo "<pre>\n";
    var_dump($form->getValue());
    echo "</pre>\n<hr />";
    // let's freeze the form and remove the reset button
    $fsButton->removeChild($testReset);
    $form->toggleFrozen(true);
}
$renderer = HTML_QuickForm2_Renderer::factory('default');
$form->render($renderer);
// Output javascript libraries, needed by hierselect
echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
echo $renderer;
?>
  </body>
</html>