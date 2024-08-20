
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12">
          <!-- small box -->
         <div class="box">
            <div class="box-header">
              <h3 class="box-title">Welcome
			  <?php			  
				$admin_data=$this->session->userdata('admin_data');
				echo $admin_data['name']; 
			  ?> !
			  </h3>
            </div>
        </div>
      </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->

      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

