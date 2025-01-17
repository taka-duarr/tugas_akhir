<?php
// var_dump($Carts); // Debug isi data keranjang
?>

<!DOCTYPE html>
<html lang="en">

<script src="https://cdn.tailwindcss.com"></script>
<!-- component -->
<!-- Create By Joker Banny -->
<style>
    @layer utilities {
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  }
</style>

<body>
  <div class="min-h-screen bg-gray-100 pt-20">
    <h1 class="mb-10 text-center text-2xl font-bold">Keranjang</h1>
    

    <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
      <!-- Cart Items -->
      <div class="rounded-lg md:w-2/3">
        <?php 
        $total = 0; // Total seluruh keranjang
        foreach ($Carts as $item) { 
            $subtotal = $item['jumlah'] * $item['harga_barang']; // Subtotal per item
            $total += $subtotal; // Tambahkan ke total keseluruhan
            $_SESSION['total'] = $total;
        ?>
        <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
          <img src="imgBarang/<?php echo htmlspecialchars($item['gambar_barang']); ?>" alt="product-image" class="w-full rounded-lg sm:w-40" />
          <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
            <div class="mt-5 sm:mt-0">
              <h2 class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($item['nama_barang']); ?></h2>
            </div>
            <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
              <div class="flex items-center border-gray-100">
                <form action="index.php?modul=cart&fitur=update" method="POST" class="inline-block">
                  <input type="hidden" name="id_barang" value="<?php echo htmlspecialchars($item['id_barang']); ?>" />
                  <input type="hidden" name="jumlah" value="<?php echo $item['jumlah'] - 1; ?>" />
                  <button 
                      type="submit" 
                      class="rounded bg-gray-100 px-3 py-1 text-black hover:bg-gray-300"
                      <?php if ($item['jumlah'] <= 1) echo 'disabled'; ?> 
                  >
                      -
                  </button>
                </form>
                <input class="h-8 w-8 border bg-white text-center text-xs outline-none" type="number" value="<?php echo htmlspecialchars($item['jumlah']); ?>" min="1" />
                <form action="index.php?modul=cart&fitur=update" method="POST" class="inline-block">
                  <input type="hidden" name="id_barang" value="<?php echo htmlspecialchars($item['id_barang']); ?>" />
                  <input type="hidden" name="jumlah" value="<?php echo $item['jumlah'] + 1; ?>" />
                  <button 
                      type="submit" 
                      class="rounded bg-gray-100 px-3 py-1 text-black hover:bg-gray-300"
                  >
                      +
                  </button>
                </form>
              </div>
              <div class="flex items-center space-x-4">
                <p class="text-sm">Rp <?php echo number_format($item['harga_barang']); ?></p>
              </div>
              <button class=" bg-black hover:bg-gray-700 text-white font-bold py-1 px-2 rounded">
                  <a href="index.php?modul=cart&fitur=delete&id_cart=<?php echo $item['id_cart']; ?>">Delete</a>
              </button>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>

      

      <!-- Subtotal -->
       <!-- Subtotal -->
<div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
    <form method="POST" action="index.php?modul=transaksi&fitur=add">
        <div class="mt-4">
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
            <textarea 
                id="alamat" 
                name="alamat" 
                rows="4" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm" 
                placeholder="Masukkan alamat lengkap Anda" 
                required></textarea>
        </div>
        <input type="hidden" name="id_user" value="<?= $_SESSION['user']['id'] ?>">
        <div class="flex justify-between mt-6">
            <p class="text-lg font-bold">Total</p>
            <p class="text-lg font-bold">Rp <?php echo number_format($total); ?></p>
        </div>
        <button type="submit" class="px-6 py-3 mt-4 w-full text-white bg-black rounded-lg hover:bg-gray-800">
            Checkout
        </button>
    </form>
</div>
    </div>

      
    
  

  <div class="mt-10 mb-10 flex justify-center">
    <button onclick="location.href='index.php?modul=cust&fitur=shop'" 
            class="rounded-md bg-black py-2 px-6 w-full font-medium text-white hover:bg-gray-600">
      Back to Menu
    </button>
  </div>
</body>
</html>
