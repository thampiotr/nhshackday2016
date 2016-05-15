<?php

//This function parses an XML result for a trial. Two inputs are needed, first an XML object, and second the STRING of the outcome being measured
function trialParser ($xmlObject, $userDefinedOutcome)
{
//Process: a) Searching outcomes for first occurence of of the outcomes word
	//For the sake of sanity, convert the XML object to an array:
	$input = json_decode(json_encode($xmlObject), TRUE);

	//$outcome contains the matched outcome

	//Now we pick out the first outcome which contains the outcome term
	$found = FALSE;


	//The outcomes list is stored in: $input['clinical_results']['outcome_list']
	//Cycle through the outcomes list, and try to identify the first 
	foreach ($input['clinical_results']['outcome_list']['outcome'] as $key=>$value)
	{
		// while (!$found)
		// {
			//So explode the subobject by the user defined outcome.
			$tempArray = explode($userDefinedOutcome, strtolower($value['title']));
			//rint_r($tempArray);
			//Now we count the number of array elements. If >1, then the term is found
			if (count($tempArray) >= 2)
			{
				$found = TRUE;

				//Set the $outcome variable [i.e. the one we are meeting]
				$outcome = $value; 
				break;
			}
		// }
	}	 

	//$outcome contains the matched outcome
	/*echo "<pre>"; 
	print_r($outcome);
	echo "</pre>";*/

//Next we need to pull the desired figures from $outcome, i.e Treated VS untreated out from this
//Take the outcome, and convert to a 2D Array
//In 1 direction: group ID, in the other: value

	//First populate an array with groupdata
	$groupData = array();
	$counter = 0;
	foreach ($outcome['group_list']['group'] as $key=>$value)
	{	
		$groupData[$counter]['id'] = $value['@attributes']['group_id'];
		$groupData[$counter]['title'] = $value['title'];
		$groupData[$counter]['description'] = $value['description'];
		$counter++;
	}

//Set a value for units
foreach ($outcome['measure_list']['measure'] as $key=>$value)
{
	$globalUnits=$value['units'];
}

//Now populate it with the POPULATION SIZE data
	foreach ($outcome['measure_list']['measure'][0]['category_list']['category']['measurement_list']['measurement'] as $key=>$value)
	{
		//Lookup $value['@attributes']['group_id'] in [$groupData][$counter]['id'] and set $value['@attributes']['value']
		//Cycle through the group data
		foreach ($groupData as $key => $groupValue) {

			if ($groupData[$key]['id'] == $value['@attributes']['group_id'])
			{
				$groupData[$key]['datasetSize'] = $value['@attributes']['value'];
				$groupData[$key]['units'] = $globalUnits;
			}
		}
	}

//Now populate it with NUMBER MEETING CONDITION data
	foreach ($outcome['measure_list']['measure'][1]['category_list']['category']['measurement_list']['measurement'] as $key=>$value)
	{
		//Lookup $value['@attributes']['group_id'] in [$groupData][$counter]['id'] and set $value['@attributes']['value']
		//Cycle through the group data
		foreach ($groupData as $key => $groupValue) {

			if ($groupData[$key]['id'] == $value['@attributes']['group_id'])
			{
				$groupData[$key]['numberMeetingCondition'] = $value['@attributes']['value'];
			}
		}
	}

//Now we do the stastical analysis



	/*echo "<pre>";
	print_r($groupData);
	echo "</pre>";*/

	$outputArray = array();
	$outputArray['trialID'] = $input['id_info']['nct_id'];
	$outputArray['outcome']=array('type'=>$outcome['type'], 'title'=>$outcome['title'], 'description'=>$outcome['description'],'time_frame'=>$outcome['time_frame'],'population'=>$outcome['population']);
	$outputArray['trialResults'] = $groupData;
	
	return $outputArray;

//Next we need to run stats on this to work out relative risk
	//To do this, we define the group with index $group


//Now we output the relative risk however Ali wants it.

	//This function identifies 
	//print_r($xmlObject);
	//matchOutcomeMeasures($xmlObject, $outcome);
	
	//For this, we pull in the data for the results
	//Do Statistics
	//Offer an option for user exclusion
	//Output in JSON for a forrest plot.
}

?>