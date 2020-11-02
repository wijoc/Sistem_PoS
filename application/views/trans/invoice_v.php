    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Invoice</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Invoice</li>
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
                      <a class="tabs-nav nav-link active" id="nav-invoice" href="#invoice" data-toggle="tab">Invoice</a>
                  </li>
                  <li class="nav-item">
                      <a class="tabs-nav nav-link" id="nav-struk" href="#struk" data-toggle="tab">Struk</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane active" id="invoice" role="tabpanel">
		            <!-- Main content -->
		            <div class="invoice p-3 mb-3">
		              <!-- title row -->
		              <div class="row">
		                <div class="col-12">
		                  <h4>
		                    <i class="fas fa-globe"></i> AdminLTE, Inc.
		                    <small class="float-right">Date: 2/10/2014</small>
		                  </h4>
		                </div>
		                <!-- /.col -->
		              </div>
		              <!-- info row -->
		              <div class="row invoice-info">
		                <div class="col-sm-4 invoice-col">
		                  From
		                  <address>
		                    <strong>Admin, Inc.</strong><br>
		                    795 Folsom Ave, Suite 600<br>
		                    San Francisco, CA 94107<br>
		                    Phone: (804) 123-5432<br>
		                    Email: info@almasaeedstudio.com
		                  </address>
		                </div>
		                <!-- /.col -->
		                <div class="col-sm-4 invoice-col">
		                  To
		                  <address>
		                    <strong>John Doe</strong><br>
		                    795 Folsom Ave, Suite 600<br>
		                    San Francisco, CA 94107<br>
		                    Phone: (555) 539-1037<br>
		                    Email: john.doe@example.com
		                  </address>
		                </div>
		                <!-- /.col -->
		                <div class="col-sm-4 invoice-col">
		                  <b>Invoice #007612</b><br>
		                  <br>
		                  <b>Order ID:</b> 4F3S8J<br>
		                  <b>Payment Due:</b> 2/22/2014<br>
		                  <b>Account:</b> 968-34567
		                </div>
		                <!-- /.col -->
		              </div>
		              <!-- /.row -->

		              <!-- Table row -->
		              <div class="row">
		                <div class="col-12 table-responsive">
	                      <table class="table table-bordered">
	                        <thead>
	                          <th>No.</th>
	                          <th>Product</th>
	                          <th>Jumlah</th>
	                          <th>Harga satuan</th>
	                          <th>Total</th>
	                        </thead>
	                        <tbody>
	                          <?php 
	                          $no = 1;
	                          $totalBayar = 0; 
	                          foreach ($detailTrans as $row): 
	                            $totalBayar += $row['dtp_total_price'];
	                          ?>
	                          <tr>
	                            <td><?php echo $no++ ?></td>
	                            <td><?php echo $row['prd_name']; ?></td>
	                            <td><?php echo $row['dtp_product_amount'] ?></td>
	                            <td class="text-right"><?php echo number_format($row['dtp_purchase_price']) ?></td>
	                            <td class="text-right"><?php echo number_format($row['dtp_total_price']) ?></td>
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
		                <div class="col-6">
		                  <p class="lead">Payment Methods:</p>
		                  <img src="<?php echo base_url() ?>assets/dist/img/credit/visa.png" alt="Visa">
		                  <img src="<?php echo base_url() ?>assets/dist/img/credit/mastercard.png" alt="Mastercard">
		                  <img src="<?php echo base_url() ?>assets/dist/img/credit/american-express.png" alt="American Express">
		                  <img src="<?php echo base_url() ?>assets/dist/img/credit/paypal2.png" alt="Paypal">

		                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
		                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
		                    plugg
		                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
		                  </p>
		                </div>
		                <!-- /.col -->
		                <div class="col-6">
		                  <p class="lead">Amount Due 2/22/2014</p>

		                  <div class="table-responsive">
		                    <table class="table">
		                      <tr>
		                        <th style="width:50%">Subtotal:</th>
		                        <td>$250.30</td>
		                      </tr>
		                      <tr>
		                        <th>Tax (9.3%)</th>
		                        <td>$10.34</td>
		                      </tr>
		                      <tr>
		                        <th>Shipping:</th>
		                        <td>$5.80</td>
		                      </tr>
		                      <tr>
		                        <th>Total:</th>
		                        <td>$265.24</td>
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
                </div>
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane" id="struk" role="tabpanel">
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
    <?php print("<pre>".print_r($detailTrans, true)."</pre>"); ?>