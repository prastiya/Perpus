 <div class="container-fluid">

          <!-- Page Heading -->

<?php echo $this->session->flashdata('message');  ?>

                  <a href="<?php echo base_url().'admin/tambah_anggota'; ?>"  class="btn btn-primary btn-icon-split"> <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text" >Tambah Data Anggota</span></a>

            <br>
            <br>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-info">Data Anggota</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Anggota</th>
                      <th>Gender</th>
                      <th>No.Telpon</th>
                      <th>Alamat</th>
                      <th>Email</th>
                      <th>Pilihan</th>
                      </tr>
                  </thead>
                   
                  
                  <tbody>
                    <?php
                        $no = 1;
                        foreach ($anggota as $a) {
                        ?>
                        <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $a->nama_anggota ?></td>
                        <td><?php echo $a->gender ?></td>
                        <td><?php echo $a->no_telp ?></td>
                        <td><?php echo $a->alamat ?></td>
                        <td><?php echo $a->email ?></td>
                        <td nowrap="nowrap">

                        <a href="<?php echo
                        base_url().'admin/edit_anggota/'.$a->id_anggota; ?>" class="btn btn-info btn-circle btn-sm">
                        <i class="fas fa-edit"></i>
                        </a>
          
                        <a href="<?php echo
                        base_url().'admin/hapus_anggota/'.$a->id_anggota; ?>" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                        </a>



                       
                        </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                 
                </table>
              </div>
            </div>
          </div>

        </div>





