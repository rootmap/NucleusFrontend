<button type="button" class="btn btn-success" id="dashboard_tender_report" onclick="dashboard_tender_report()" style="position:absolute; right:3px;"><i class="icon-refresh"></i> Load Data</button>
<table class="table table-condensed">

    <thead>
    <tr>
    <th colspan="3">Tender Report</th>
    </tr>
    </thead>

    

    <tbody id="tender_report">
		<?php
        $sqlhighestsales=$obj->SelectAll("payment_method");
		$i=1;
		if(!empty($sqlhighestsales))
		foreach($sqlhighestsales as $highestsales):
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $highestsales->meth_name; ?></td>
            <td>0</td>
        </tr>    
		<?php 
		$i++;
		endforeach; ?>
    </tbody>

</table>