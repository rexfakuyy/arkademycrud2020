<?php
    // Koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "arkademy";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    // jika tombol simpan di klik
    if(isset($_POST['bsimpan']))
    {
        // apakah Data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            // Data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE produk set
            nama_produk = '$_POST[tnama_produk]',
            keterangan = '$_POST[tketerangan]',
            harga = '$_POST[tharga]',
            jumlah = '$_POST[tjumlah]'
            WHERE nama_produk = '$_GET[namaproduk]'
            ");
            if($edit) // jika edit sukses
            {
                echo "<script>
                        alert('Edit data suksess!');
                        document.location='index.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Edit data GAGAL!!');
                        document.location='index.php';
                    </script>";
            }
            
        } else
        {
            // Data yang akan disimpan baru
                $simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah)
                VALUES ('$_POST[tnama_produk]',
                '$_POST[tketerangan]',
                '$_POST[tharga]',
                '$_POST[tjumlah]')
            ");
            if($simpan) // jika simpan sukses
            {
                echo "<script>
                        alert('Simpan data suksess!');
                        document.location='index.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL!!');
                        document.location='index.php';
                    </script>";
            }
        }


        
    }


    // jika tombol Edit atau Hapus di klik
    if(isset($_GET['hal']))
    {
        // jika edit Data 
        if($_GET['hal'] == "edit")
        {
            // tampilkan Data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * from produk WHERE nama_produk = '$_GET[namaproduk]' ");
            $data = mysqli_fetch_array($tampil);
            if($data) 
            {
                // jika data ditemukan maka data ditampung dulu kedalam variabel
                $vnama_produk = $data['nama_produk'];
                $vketerangan = $data['keterangan'];
                $vharga = $data['harga'];
                $vjumlah = $data['jumlah'];
            }
        }
        else if($_GET['hal'] == "hapus")
        {
            // hapus Data
            $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE nama_produk = '$_GET[namaproduk]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus Data Suksess!!');
                        document.location='index.php';
                    </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARKADEMY CRUD 2020 PHP & MYSQL + Bootstrap 4</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="text-center ">CRUD 2020 PHP & MYSQL + Bootstrap 4</h1>
    <h2 class="text-center">@Arkademy</h2>

    <!-- Ini Card Form -->
    <div class="card mt-3">
        <div class="card-header bg-warning text-white">
        Form Input Produk
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="tnama_produk" value="<?=@$vnama_produk?>" class="form-control" placeholder="Masukkan Nama Produk!" required>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="tketerangan" value="<?=@$vketerangan?>" class="form-control" placeholder="Masukkan Keterangan Produk!" required>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="tharga" value="<?=@$vharga?>" class="form-control" placeholder="Masukkan Harga Produk!" required>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="text" name="tjumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Masukkan Jumlah Produk!" required>
                </div>
                <button type="submit" class="btn btn-warning text-white" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-light" name="breset">Kosongkan</button>
            </form>
        </div>
    </div>


    <!-- Ini Card Tabel -->
    <div class="card mt-3">
        <div class="card-header bg-warning text-white">
        Daftar Produk
        </div>
        <div class="card-body">
            
            <table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Keterangan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Aksi </th>
                </tr>
                <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * from produk order by nama_produk"); // kalo pake desc atau descending pada querynya maka akan memunculkan data terbaru di paling bawah bukan di paling atas
                    while($data = mysqli_fetch_array($tampil)) :
                        
                ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$data['nama_produk']?></td>
                    <td><?=$data['keterangan']?></td>
                    <td><?=$data['harga']?></td>
                    <td><?=$data['jumlah']?></td>
                    <td>
                        <a href="index.php?hal=edit&namaproduk=<?=$data['nama_produk']?>" class="btn btn-primary"> Edit </a>
                        <a href="index.php?hal=hapus&namaproduk=<?=$data['nama_produk']?>" onclick="return confirm('Apakah yakin ingin menghapus Data ini?')" class="btn btn-danger"> Hapus </a>
                    </td>
                </tr>
                    <?php endwhile; // penutup perulangan while diatas ?>
            </table>
        </div>
    </div>


</div>




    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>