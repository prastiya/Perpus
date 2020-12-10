 <div class="container-fluid">

          <!-- Page Heading -->
<div class="row">
            <div class="col-sm-4">
                <div class="card shadow mb-4">
                  <div class="card-header">
                  <h5 class="m-0 font-weight-bold text-info">Tambah Data Katagori</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="<?= base_url('admin/kategori'); ?>">
                    <div class="form-group">
                      <input type="text" name="nama_kategori" id="nama_kategori"
                        placeholder="Masukkan Nama Kategori"
                        class="form-control form-control-user">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-success" name="tambah"><i
                          class="fa fa-plus"></i> Tambah</button>
                      <button type="reset" class="btn btn-sm btn-danger"><i
                          class="fa fa-times"></i> Batal</button>
                    </div>
                  </form>
                  <?php echo $this->session->flashdata('message');  ?>
                </div>
              </div>
            </div>

          <!-- DataTales Example -->
          <div class="col-sm-8">
              <div class="card shadow">
                <div class="card-header">
              <h5 class="m-0 font-weight-bold text-info">Data Kategori</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kategori</th>
                      <th>Pilihan</th>
                     
                    </tr>
                  </thead>
                   
                  
                  <tbody>
                     <?php 

                    $no = 1;
                    foreach ($kategori as $k) {
                     ?>
                    
                    <tr>
                      <td><?php echo $no++ ?></td>
                      <td><?php echo $k->nama_kategori ?></td>
                      <td nowrap="nowrap" align="center"> 
                        <a href="<?php echo
                        base_url().'admin/hapus_kategori/'.$k->id_kategori; ?>" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                        </a></td>
                    </tr>
                     <?php } ?> 
                   </tbody>
                 
                </table>
              </div>
            </div>
          </div>
</div>
</div>
</div>
        </div>
        <!-- /.container-fluid -->
<!-- Button trigger modal -->


