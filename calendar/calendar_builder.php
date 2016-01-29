<?php
	function calendar_builder() {
		$year = date('Y');
		$month = date('n');
		$header_text = date('F Y');
		$headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$days_in_week = 1;
		$day_counter = 0;
		$days_in_month = date('t', mktime(0,0,0,$month,1,$year) );
		$running_day = date('w', mktime(0,0,0,$month,1,$year) );
		
		$calendar = "<h1>$header_text</h1>";
		$calendar .= "<table border='1'>";
		
			#Add in headers
			$calendar .= "<tr><th>".implode("</th><th>",$headings)."</th></tr>";
			
			$calendar .= "<tr>";
			
			#Print 'blank' days up to the first
			for ( $i = 0; $i < $running_day; $i++ ):
				$calendar .= "<td class='non_day'>&nbsp;</td>";
				$days_in_week++;
			endfor;
			
			for ( $day = 1; $day <= $days_in_month; $day++ ):

				if( $day==date(j)): ##Add month in here too
					$highlight = "class='highlight'";
				else:
					$highlight = "";
				endif;

				$calendar .= "<td $highlight>";
					$calendar .= "<div class='day-number'>".$day."</div>";
				$calendar .= "</td>";
				
				if ( $running_day == 6 ):
					$calendar .= "</tr>";
					
					if ( ($day_counter+1) != $days_in_month ):
						$calendar .= "<tr>";
						
						$running_day = -1;
						$days_in_week = 0;
					endif;
				endif;
				
				$days_in_week++;
				$running_day++;
				$day_counter++;
			endfor;
			
			if ( $days_in_week < 8 ):
				for( $i = 1, $ii = (8 - $days_in_week); $i <= $ii; $i++ ):
					$calendar .= "<td class='non_day'>&nbsp;</td>";
				endfor;
			endif;
			
			$calendar .= "</tr>";
		
		$calendar .= "</table>";
		
		return $calendar;
	}
?>