

    <!-- Sidebar -->
   
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
   
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 font-weight-bold text-gray-800" style="font-family: 'Roboto Slab', serif;">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="<?php echo base_url().'admin/buku' ?>" style="text-decoration: none;">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Buku yang terdaftar</div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $this->M_perpus->get_data('buku')->num_rows(); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
               <a href="<?php echo base_url().'admin/anggota' ?>" style="text-decoration: none;">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Anggota yang terdaftar</div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $this->M_perpus->get_data('anggota')->num_rows(); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
               <a href="<?php echo base_url().'admin/peminjaman' ?>" style="text-decoration: none;">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Peminjaman belum selesai ok</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h2 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $this->M_perpus->edit_data(array('status_peminjaman'=>0),'transaksi')->num_rows(); ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
               <a href="<?php echo base_url().'admin/transaksi_selesai' ?>" style="text-decoration: none;">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Peminjaman Sudah selesai ok</div>
                      <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $this->M_perpus->edit_data(array('status_peminjaman'=>1),'transaksi')->num_rows(); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
          </div>

          <!-- Content Row -->

          <div class="row">
               <div class="col-lg-4">

              <!-- Dropdown Card Example -->
              
              <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#buku" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="buku">
                  <h6 class="m-0 font-weight-bold text-primary">Buku</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="buku">
                  <div class="card-body">
                  <div class="panel-body">
                          <div class="list-group">
                            <?php foreach ($buku as $b) { ?>
                              <a href="#" class="list-group-item" style="text-decoration: none;">
                                <span class="badge badge-info"><?php if($b->status_buku==1){echo "Tersedia";} else{echo "Dipinjam";} ?></span>&emsp;
                                <span class="m-0 font-weight-bold text-primary"><?php echo $b->judul_buku; ?></span>
                              </a>
                            <?php } ?>
                          </div>
                          <br>
                          <div class="text-right">
                              <a href="<?php echo base_url().'admin/buku' ?>" class="btn btn-info btn-icon-split">
                              <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                              </span>
                              <span class="text">Lihat Semua Buku</span>
                            </a>
                           
                          </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

  <div class="col-lg-3">
              <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#kategori" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="kategori">
                  <h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="kategori">
                  <div class="card-body">
                  <div class="panel-body">
                              <div class="list-group">
                                
                                <?php foreach ($kategori as $k) { ?>
                                  <a href="#" class="list-group-item" style="text-decoration: none;">
                                   &emsp;
                                    <span class="badge badge-info"><?php echo $k->nama_kategori ?></span>
                                  </a>
                                <?php } ?>
                              </div>
                              <div class="text-right">
                                <br>
                                 <a href="<?php echo base_url().'admin/kategori' ?>" class="btn btn-info btn-icon-split">
                              <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                              </span>
                              <span class="text">Lihat Kategori</span>
                            </a>
                               
                              </div>
                  </div>
                </div>
              </div>
            </div>
          </div>          


               <div class="col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#anggota" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="anggota">
                  <h6 class="m-0 font-weight-bold text-primary">Anggota Terbaru</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="anggota">
                  <div class="card-body">
                  <div class="panel-body">
                              <div class="list-group">
                                <?php foreach ($anggota as $a) { ?>
                                  <a href="#" class="list-group-item" style="text-decoration: none;">
                                   
                                    <span class="badge badge-info"><?php echo $a->gender; ?></span>&emsp;
                                    <span class="m-0 font-weight-bold text-primary"><?php echo $a->nama_anggota; ?></span>
                                  </a>
                                <?php } ?>
                              </div>
                              <div class="text-right">
                                <br>
                                 <a href="<?php echo base_url().'admin/anggota' ?>" class="btn btn-info btn-icon-split">
                              <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                              </span>
                              <span class="text">Lihat Semua Anggota </span>
                            </a>
                               
                              </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

               <div class="col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#peminjaman" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="peminjaman">
                  <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terakhir</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="peminjaman">
                  <div class="card-body">
                <div class="panel-body">
                              <div class="table-responsive">
                                <table class="tabel table-bordered tablehover table-striped">
                                  <thead>
                                    <tr>
                                      <th>Tgl. Transaksi</th>
                                      <th>Tgl. Pinjam</th>
                                      <th>Tgl. Kembali</th>
                                      <th>Total Denda</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($transaksi as $p) {
                                      ?>
                                      <tr>
                                        <td><?php echo date('d/m/Y',strtotime($p->tgl_pencatatan)); ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($p->tgl_pinjam)); ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($p->tgl_kembali)); ?></td>
                                        <td><?php echo "Rp. ".number_format($p->total_denda)." ,-"; ?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                                    <div class="text-right">
                                      <br>
                                       <a href="<?php echo base_url().'admin/transaksi' ?>" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                          <i class="fas fa-arrow-right"></i>
                                        </span>
                                        <span class="text">Lihat Semua Transaksi </span>
                                      </a>
                                    
                                    </div>
                                  </div>
                                
                  
                </div>
              </div>
            </div>
          </div>




            <!-- Area Chart -->
           


        
    
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->



</body>

</html>
