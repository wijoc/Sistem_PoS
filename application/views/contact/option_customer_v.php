 <?php foreach ($optCtm as $row) : ?>
 	<div class="col-lg-6">
    	<button class="btn btn-block btn-flat btn-outline-success" style="margin: 5px;" value="<?php echo base64_encode(urlencode($row['data_id'])) ?>">
    		<font style="font-weight: bold"><?php echo $row['label'] ?></font>
    	</button>
    </div>
<?php endforeach ?> 
<?php print("<pre>".print_r($optCtm, true)."</pre>") ?>