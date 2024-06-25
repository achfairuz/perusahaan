 <style>
     .disabled-link {
         color: #999;
         /* Warna teks yang non-interaktif */
         pointer-events: none;
         /* Mencegah tautan dari interaksi pengguna */
         text-decoration: none;
         /* Menghapus dekorasi tautan seperti garis bawah */
     }
 </style>

 <?php
    include "../koneksi.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: ../login.php");
        exit();
    }

    $username = $_SESSION['username'];

    ?>

 <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-2" style="border-bottom: 1px solid black;">
     <h2 class="fw-bold text-mainColor">Daftar Cuti</h2>



     <div class="btn-toolbar mb-2 mb-md-0">
         <a href="?page=formCuti">
             <button type="button" class="btn btn-sm btn-outline-secondary btn-ajukan-ajuanCuti">
                 <span data-feather="plus"></span>
                 Ajukan Cuti
             </button>
         </a>
     </div>
 </div>


 <!-- SHOW CUTI -->
 <div class="table-responsive">
     <table class="table table-striped table-sm text-center">
         <thead>
             <tr>
                 <th scope="col" class="px-3">NO</th>
                 <th scope="col" class="px-3">Tanggal Mulai</th>
                 <th scope="col" class="px-3">Tanggal Selesai</th>
                 <th scope="col" class="px-3">File Surat</th>
                 <th scope="col" class="px-3">Alasan</th>
                 <th scope="col" class="px-3">Status Cuti</th>
                 <th scope="col" class="px-3">Action</th>
             </tr>
         </thead>
         <tbody>
             <?php
                $no = 1;
                $sql = "SELECT * FROM cuti WHERE username = '$username' ORDER BY tanggal_mulai ASC";
                $result = $koneksi->query($sql);

                // Memeriksa apakah ada data cuti
                if ($result->num_rows > 0) {
                    while ($a = $result->fetch_assoc()) {
                        $id_cuti = $a['id_cuti'];
                ?>
                     <tr>
                         <td class="p-3"><?php echo $no++; ?></td>
                         <td class="p-3"><?php echo $a['tanggal_mulai']; ?></td>
                         <td class="p-3"><?php echo $a['tanggal_selesai']; ?></td>
                         <td class="p-3"><a href="../uploads/surat cuti/<?php echo ($a['file']); ?>"><?php echo $a['file']; ?></a></td>
                         <td class="p-3"><?php echo $a['alasan']; ?></td>
                         <td class="p-3">
                             <p class="btn <?php if ($a['status_cuti'] == 'Disetujui') {
                                                echo "badge bg-success";
                                            } elseif ($a['status_cuti'] == 'Ditolak') {
                                                echo "badge bg-danger";
                                            } else {
                                                echo "badge bg-warning";
                                            } ?>"><?php echo $a['status_cuti']; ?></p>
                         </td>
                         <td class="p-3">
                             <a href="?page=update_cuti&id_cuti=<?php echo $id_cuti; ?>" <?php echo ($a['status_cuti'] == 'Disetujui' || $a['status_cuti'] == 'Ditolak') ? 'class="disabled-link"' : ''; ?>>
                                 Update
                             </a>


                             <button class="btn px-2 py-2 btn-batalkan-cuti text-danger border-0" data-id="<?php echo $id_cuti; ?>" <?php echo ($a['status_cuti'] == 'Disetujui' || $a['status_cuti'] == 'Tidak Ditolak') ? 'disabled' : ''; ?>>
                                 Delete
                             </button>
                         </td>

                     </tr>
             <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada ajuan cuti.</td></tr>";
                }
                ?>
         </tbody>
     </table>
 </div>


 <!-- POPUP Batalkan -->
 <div id="popupBatalkan" class="popup popupdelete">
     <div class="popup-content pop-up rounded">
         <div class="title text-center">
             <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
             <h4 class="text-danger fw-bold text-center">Apakah Anda Ingin Membatalkan Cuti Anda ?</h4>
         </div>
         <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
             <button class="btn btn-danger mt-3" id="Batalkan">Batalkan</button>
             <button class="btn btn-secondary mt-3" id="cancelBatalkan">Cancel</button>

         </div>
     </div>
 </div>
 <script>
     document.querySelectorAll('.btn-batalkan-cuti').forEach(button => {
         button.addEventListener('click', function() {
             batalkan = 'CRUD.php?stts=batal_cuti&id_cuti=' +
                 this.getAttribute('data-id');
             document.getElementById('popupBatalkan').style.display = 'block';
         });
     });

     document.getElementById('Batalkan').addEventListener('click', function() {
         window.location.href = batalkan;
     });


     document.querySelectorAll('#cancelBatalkan').forEach(button => {
         button.addEventListener('click', function() {
             document.getElementById('popupBatalkan').style.display = 'none';
         });
     });
 </script>