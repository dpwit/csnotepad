<? if ($failures) { ?>
*** Tests Failed <?=$ran-$success?> of <?=$ran?> ***

	<? 
		foreach($failures as $suite_failures) { 
			$suite = $suite_failures['suite'];
			$tests = $suite_failures['tests'];
?>
Suite: <?=$suite->getName()?>
	<? foreach($tests as $test){ ?>

	Test: <?=$test->getName()?> (<?=get_class($test)?>)

		<?=str_replace("\n","\n\t\t",$test->getFailureReason())?>

	<? } ?>

<?
		}
	?>
*** Tests Failed <?=$ran-$success?> of <?=$ran?> ***
<? } else { ?>

All <?=$ran?> tests succeeded!!
<? } ?>
