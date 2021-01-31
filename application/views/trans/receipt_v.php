    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Receipt</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Receipt</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <ul class="nav nav-justified nav-tabs ml-auto p-2" role="tablist">
                  <li class="nav-item">
                      <a class="tabs-nav nav-link active" id="nav-big-receipt" href="#big-receipt" data-toggle="tab">Struk Besar</a>
                  </li>
                  <li class="nav-item">
                      <a class="tabs-nav nav-link" id="nav-small-receipt" href="#small-receipt" data-toggle="tab">Struk Kecil</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-content-above-tabContent">
			  	  <!-- Tab Struk besar -->
                  <div class="tab-pane active" id="big-receipt" role="tabpanel">
		            <!-- Main content -->
		            <div class="invoice p-3 mb-3">
		              <!-- title row -->
		              <div class="row">
		                <div class="col-7">
		                  <h4>
		                    <img style="width: 50px" src="<?php echo base_url().$dataProfile[0]['pfl_logo'] ?>">
		                    &nbsp; <strong><?php echo $dataProfile[0]['pfl_name'] ?></strong>
		                  </h4>
		                </div>
		                <div class="col-5">
		                	<small>
		                		<?php echo $dataProfile[0]['pfl_address'] ?>
			                </small>
		                </div>
		                <!-- /.col -->
		              </div>
		              <hr>
		              <!-- info row -->
		              <div class="row invoice-info">
		                <div class="col-md-3 col-sm-4 invoice-col text-center">
							<h2 style="font-weight: bold; text-decoration: underline;">RECEIPT</h2>
		                </div>
		                <!-- /.col -->
		                <div class="col-md-9 col-sm-8 invoice-col row">
							<span class="col-sm-4"><?php echo date($detailTrans[0]['ts_date']) ?></span>
							<span class="col-sm-5"><?php echo date($detailTrans[0]['ts_trans_code']) ?></span>
							<span class="col-sm-3"><?php echo 'Nama Kasir' ?></span>
		                </div>
		                <!-- /.col -->
		              </div>
		              <!-- /.row -->

		              <!-- Table row -->
		              <div class="row">
		                <div class="col-12 table-responsive">
	                      <table class="table table-bordered">
	                        <tbody>
	                          <?php 
	                          $no = 1;
	                          $totalBayar = 0; 
	                          foreach ($detailTrans as $row): 
	                            $totalBayar += $row['dts_total_price'];
	                          ?>
	                          <tr>
	                            <td><?php echo $no++ ?></td>
	                            <td><?php echo $row['prd_name']; ?></td>
	                            <td><?php echo $row['dts_product_amount'] ?></td>
	                            <td class="text-right"><?php echo number_format($row['dts_sale_price']) ?></td>
	                            <td class="text-right"><?php echo number_format($row['dts_total_price']) ?></td>
	                          </tr>
	                        <?php endforeach; ?>
	                        </tbody>
	                        <tfoot>
	                          <th colspan="4" class="text-right">Total : </th>
	                          <th><?php echo number_format($totalBayar) ?></th>
	                        </tfoot>
	                      </table>
		                </div>
		                <!-- /.col -->
		              </div>
		              <!-- /.row -->

		              <div class="row">
		                <!-- accepted payments column -->
		                <div class="col-md-6 row">
							<div class="col-sm-6 text-center">
								<p class="mb-5">Pembeli</p>
								<p class="pt-5">(................)</p>
							</div>
							<div class="col-sm-6 text-center">
								<p class="mb-5">Kasir</p>
								<p class="pt-5">(Nama Kasir)</p>
							</div>
		                </div>
		                <!-- /.col -->
		                <div class="col-md-6">
		                  <div class="table-responsive">
		                    <table class="table">
		                      <tr>
		                        <th style="width:50%">Subtotal :</th>
		                        <td>Rp<?php echo number_format($totalBayar, 2) ?></td>
		                      </tr>
		                      <tr>
		                        <th>Pengiriman :</th>
		                        <td>Rp<?php echo ($detailTrans[0]['ts_delivery_metode'] != 'N')? number_format($detailTrans[0]['ts_delivery_payment'], 2) : '0.00' ?></td>
		                      </tr>
		                      <tr>
		                        <th>Total:</th>
		                        <td><?php echo 'Rp'.number_format($detailTrans[0]['ts_sales_price'], 2) ?></td>
		                      </tr>
		                    </table>
		                  </div>
		                </div>
		                <!-- /.col -->
		              </div>
		              <!-- /.row -->

		              <!-- this row will not appear when printing -->
		              <div class="row no-print">
		                <div class="col-12">
		                  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
		                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
		                    Payment
		                  </button>
		                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
		                    <i class="fas fa-download"></i> Generate PDF
		                  </button>
		                </div>
		              </div>
		            </div>
                  </div>

                  <!-- Tab Kecil -->
				  <div class="tab-pane" id="small-receipt" role="tabpanel">
					<div class="fifty-eight-receipt" id="small-receipt">
						<center id="top">
							<div class="pl-3 pr-3 logo row">
								<img style="width: 50px" src="<?php echo base_url().$dataProfile[0]['pfl_logo'] ?>">
								<h2 class="pl-2"><?php echo $dataProfile[0]['pfl_name'] ?></h2>
							</div>
							<div class="info"> 
								<p><?php echo $dataProfile[0]['pfl_address'] ?></p>
							</div>
						</center>
						<hr>
						<div id="mid">
							<div class="info">
								<p> 
									Trans &nbsp;:&nbsp; <?php echo $detailTrans[0]['ts_trans_code'] ?><br>
									Tgl   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; <?php echo date('d.m.Y-H:i', strtotime($detailTrans[0]['ts_date'])) ?></br>
									Kasir &nbsp;&nbsp;:&nbsp; Nama Kasir</br>
								</p>
							</div>
						</div>
						<div id="bot">
							<table>
								<thead class="table-title">
									<th class="item">Prd</th>
									<th>Qty</th>
									<th>Harga</th>
									<th>Sub Total</th>
								</thead>
								<tbody>
									<?php 
										$totalBayar = 0; 
										foreach ($detailTrans as $row): 
											$totalBayar += $row['dts_total_price'];
									?>
										<tr>
											<td class="item-text"><?php echo $row['prd_name']; ?></td>
											<td class="item-text"><?php echo $row['dts_product_amount'] ?></td>
	                            			<td class="item-text text-right"><?php echo number_format($row['dts_sale_price']) ?></td>
											<td class="item-text text-right"><?php echo number_format($row['dts_total_price']) ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot class="table-title text-right">
									<tr>
										<th colspan="3">Total Belanja</th>
										<td><?php echo number_format($totalBayar) ?></td>
									</tr>
									<tr>
										<th colspan="3">Pengiriman :</th>
										<td><?php echo ($detailTrans[0]['ts_delivery_metode'] != 'N')? number_format($detailTrans[0]['ts_delivery_payment'], 2) : '0.00' ?></td>
									</tr>
									<tr>
										<th colspan="3">Grand Total:</th>
										<td><?php echo number_format($detailTrans[0]['ts_sales_price'], 2) ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div id="legalcopy">
							<p class="legal"><strong>Terimakasih telah berbelanja !</strong><br>
							Layanan Konsumen : <br> <?php echo $dataProfile[0]['pfl_telp'] ?> - <?php echo $dataProfile[0]['pfl_email'] ?>
							</p>
						</div>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->