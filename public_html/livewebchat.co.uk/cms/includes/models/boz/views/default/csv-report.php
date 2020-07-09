<?
	if(@$_REQUEST['search']) $report->restrict('like',$_REQUEST['search']);
	cms_no_template();
	header("Content-type: text/plain");
	header("Content-disposition: attachment; filename=".Model::urlEncode($report->getReportTitle()).".csv");
	$report->setFormat('csv');

	function csv_format($cols){
		foreach($cols as $k=>$v){
			$cols[$k] = '"'.str_replace('"','""',$v).'"';
		}
		return join(",",$cols);
	}

	function drawHeadings($report){
		$report->triggerAction('pre_report_table');
		$report->triggerAction('head_report_table');
		$cols = $report->getListingHeadings();
		echo csv_format($cols);
		$report->triggerAction('model_listing_after_column_headings',',"%s"');
		echo "\n";
	}	
	function drawRow($report){
		if(!$report->checkAccess('view',false)) {
			return;
		}
		echo csv_format($report->getListingValues());
		$report->triggerAction('model_listing_after_column_data','"%s"');
		echo "\n";
		$report->triggerAction('model_listing_end');
	}

	$first = true;
	$count=0;
	while($report->next()){
		if($report->newTable()) {
			if(!$first){
				closeTable($report);
			}
			$first = false;
			drawHeadings($report);
		}
		drawRow($report);
		if($perPage && ++$count>$perPage) break;
	}
	if(!$first) closeTable($report);

	function closeTable($report){
		$report->triggerAction('after_table');
		echo "\n\n";
	}
	$report->triggerAction('report_summary',$report);
	$report->triggerAction('report_finished',$report);
